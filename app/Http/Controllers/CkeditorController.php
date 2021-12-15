<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;

App::make('files')->link(storage_path('app/public'), public_path('storage'));

use App\Board;
use App\Ckeditor;
use App\Functions\RandomId;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Null_;
use SebastianBergmann\Environment\Console;

class CkeditorController extends Controller
{
    public function upload(Request $request)
    {
        if($request->hasFile('upload')) {
            //get filename with extension
            $filenamewithextension = $request->file('upload')->getClientOriginalName();
            
            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            
            //get file extension
            $extension = $request->file('upload')->getClientOriginalExtension();
            
            //filename to store
            $filenametostore = $filename.'_'.time().'.'.$extension;
            
            //Upload File
            $url = $request->file('upload')->storeAs('public/ckeditor', $filenametostore);
 
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/ckeditor/'.$filenametostore);
            $msg = 'Image successfully uploaded';
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            
            // Render HTML output
            @header('Content-type: text/html; charset=utf-8');
            echo $re;
        }
    }
}
