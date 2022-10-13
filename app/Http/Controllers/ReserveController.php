<?php

namespace App\Http\Controllers;

use App\User;
Use App\Intern;
use App\Functions\RandomId;
use App\Reserve;

use Illuminate\Http\Request;
use PDO;

class ReserveController extends Controller
{
    function index() {
        return view('pm.reserve.index');
    }

    function show(String $location) {
        $users = [];
        $allUsers = User::orderby('nickname')->with('goods')->get();
        $interns = Intern::where('status', '!=', 'resign')->get();
        
        foreach ($allUsers as $allUser) {
            if ($allUser->role != 'manager' && $allUser->status != 'resign') {
                array_push($users, $allUser);
            }
        }

        $reserves = Reserve::orderby('created_at', 'desc')->get();

        return view('pm.reserve.show', ['reserves' => $reserves, 'users' => $users, 'interns' => $interns, 'location' => $location]);
    }

    public function update(Request $request, String $location, String $reserve_id)
    {
        $reserve = Reserve::find($reserve_id);
        //$project = Project::find($request->input('project_id'));
        //
        $request->validate([
            'name' => 'required|string|min:1|max:191',
            'stock' => 'required|string|min:1|max:191',
            'category' => 'required|string|min:1|max:191',
            // 'cabinet_number' => 'nullable|exists:cabinet_number',
            'signer' => 'required|string|min:1|max:15',
            'note' => 'nullable|exists:note',
            'project_id' => 'nullable|exists:project_id'
        ]);


        $reserve->update($request->except('_method', '_token'));

        $reserve->name = $request ->input('name');
        $reserve->stock = $request->input('stock');
        $reserve->category = $request->input('category');
        $reserve->signer = $request->input('signer');
        $reserve->project_id = $request->input('project_id');
        $reserve->save();
        
        return redirect()->route('reserve.show', $location);

    }

    function create() {
        $users = [];
        $allUsers = User::orderby('nickname')->where('status', '!=', 'resign')->get();
        $interns = Intern::where('status', '!=', 'resign')->get();
        foreach ($allUsers as $allUser) {
            if ($allUser->role != 'manager' && $allUser->role != 'resigned') {
                array_push($users, $allUser);
            }
        }
        return view('pm.reserve.create', ['users' => $users, 'interns' => $interns]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:1|max:191',
            'stock' => 'required|string|min:1|max:191',
            'category' => 'required|string|min:1|max:191',
            'location' => 'required|string|min:1|max:191',
            // 'cabinet_number' => 'nullable|exists:cabinet_number',
            'signer' => 'required|string|min:1|max:15',
            'note' => 'nullable|exists:note',
            'project_id' => 'nullable|exists:project_id'
        ]);

        $reserve_ids = Reserve::select('reserve_id')->get()->map(function ($reserve) {
            return $reserve->reserve_id;
        })->toArray();
        $id = RandomId::getNewId($reserve_ids);

        $intern = null;
        if($request->input('signer')=='實習生'){
            $signer = $request->input('intern');
        }
        else{
            $signer = $request->input('signer');
        }
        $location = $request->input('location');

        $post = Reserve::create([
            'reserve_id' => $id,
            'name' => $request->input('name'),
            'stock' => $request->input('stock'),
            'category' => $request->input('category'),
            'location' => $location,
            'signer' => $signer,
            'note' => $request->input('note'),
            'project_id' => $request->input('project_id')
        ]);

        return redirect()->route('reserve.show', $location);
    }

    public function delete(String $location, String $id)
    {
        $reserve = Reserve::find($id);

        $reserve->delete();
        return redirect()->route('reserve.show', $location);
    }
}
