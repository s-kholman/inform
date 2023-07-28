<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SokarController extends Controller
{
    public function index(){
       return view('sokar.index');
    }
}
