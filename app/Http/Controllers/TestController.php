<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index() 
    {
    	return view('test.index');
    }

    public function showImageUpload() 
    {
        return view('test.upload');
    }

    public function imageUpload(Request $request)
    {
    	
    	if($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            
            // $name = $file->getClientOriginalName();

            // store image
            $url = Storage::disk('public')->put('users/mike@yeah.com/avatars/', $file);

            echo '<img src="http://localhost:8888/gdates/storage/app/public/' . $url . '">yeah</a>';

        	dd($url);
            // assign to be saved in the database

        }

        echo 'no image uploaded';
    }
}
