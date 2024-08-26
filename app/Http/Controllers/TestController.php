<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Artisan;

class TestController extends Controller
{
    //

    public function delete_closures () {
        $closures = \App\Models\Closure::all();
        foreach ($closures as $closure) {
            $closure->delete();
        }
        Session::flash('success', 'Ay kapamalar silindi.');

        //return dashboard
        return redirect()->route('dashboard');
    }

    public function send_email() {
        //run check:customer-closures command
        $exitCode = Artisan::call('check:customer-closures');
        Session::flash('success', 'E-postalar gönderildi.');
        return redirect()->route('dashboard');
    }
}
