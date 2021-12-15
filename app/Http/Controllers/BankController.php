<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Functions\RandomId;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Null_;

class BankController extends Controller
{
    /**
     * Fix textarea data without wrap from front_end.
     */
    // private function replaceEnter(Bool $database, String $content)
    // {
    //     if ($database)
    //         return str_replace("\n", "<br />", str_replace("\r\n", "<br />", $content));
    //     else
    //         return str_replace("<br />", "\n", $content);
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $bank=Bank::all();
        return view('pm.bank.indexBank')->with('data', $bank);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:banks|string',
            'bank_account_name' => 'required|string',
            'bank' =>  'required|string',
            'bank_branch' => 'required|string',
            'bank_account_number' => 'required|string',
        ]);

        $bank_ids = Bank::select('bank_id')->get()->map(function ($bank) {
            return $bank->bank_id;
        })->toArray();
        $id = RandomId::getNewId($bank_ids);
        $post = Bank::create([
            'bank_id' => $id,
            'name' => $request->input('name'),
            'bank_account_name' => $request->input('bank_account_name'),
            'bank' => $request->input('bank'),
            'bank_branch' => $request->input('bank_branch'),
            'bank_account_number' => $request->input('bank_account_number'),
        ]);
        return redirect()->route('bank.index');
    }

    public function update(Request $request, String $bank_id)
    {
        $bank = Bank::find($bank_id);
        //
        $request->validate([
            'name' => 'required|string',
            'bank_account_name' => 'required|string',
            'bank' =>  'required|string',
            'bank_branch' => 'required|string',
            'bank_account_number' => 'required|string',
        ]);

        $bank->update($request->except('_method', '_token'));

        return redirect()->route('bank.index');
    }
    public function destroy(String $bank_id)
    {
        //Delete the invoice
        $bank = Bank::find($bank_id);
    
        $bank->delete();

        return redirect()->route('bank.index');
    }

}
