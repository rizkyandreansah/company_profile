<?php

namespace App\Http\Controllers\editor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller

{
    public function index()
    {
        return view('pages.editor.dashboard.index');
    }
}
