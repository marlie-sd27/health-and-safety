<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{

    // download a submitted file
    public function __invoke(Request $request)
    {
        if(Storage::exists( $request->file ))
        {
            return Storage::download( $request->file);
        } else {
            return redirect()->back()->with('error', 'Sorry, that file doesn\'t appear to exist');
        }
    }
}
