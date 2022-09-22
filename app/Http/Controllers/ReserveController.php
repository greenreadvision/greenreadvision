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

    function show() {

        return view('pm.reserve.show');
    }

    function update() {

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

    function edit() {
        
    }

    public function store(Request $request)
    {
        $reserve_ids = Reserve::select('reverse_id')->get()->map(function ($reserve) {
            return $reserve->reserve_id;
        })->toArray();

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

        $id = RandomId::getNewId($reserve_ids);

        $intern = null;
        if($request->input('signer')=='實習生'){
            $intern = $request->input('intern');
        }

        $post = Reserve::create([
            'reserve_id' => $id,
            'name' => $request->input('name'),
            'stock' => $request->input('stock'),
            'category' => $request->input('category'),
            'location' => $request->input('location'),
            'signer' => $request->input('signer'),
            'note' => $request->input('note'),
            'project_id' => $request->input('project_id')
        ]);

        return redirect()->route('reserve.index');
    }
}
