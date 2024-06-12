<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuideController extends Controller
{
    public function sss() {
        $Questions = \App\Models\Question::orderBy('order', 'asc')->get();
        return view('dashboard.pages.guide.sss', compact('Questions'));
    }
}
