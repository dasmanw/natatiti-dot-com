<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomController extends Controller
{
    public function langChange(string $lang)
    {
        session()->put('locale', $lang);
        return redirect()->back();
    }

    public function getContent()
    {   
        return view('content.modal.dynamicbits');
    }
}
