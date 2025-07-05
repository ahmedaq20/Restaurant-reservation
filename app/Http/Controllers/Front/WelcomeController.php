<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Table;

class WelcomeController extends Controller
{
    public function index(){
        return view('welcome');
    }


    public function form(){
        $tables= Table::all();
        return view('front.form',compact('tables'));
    }

    
}