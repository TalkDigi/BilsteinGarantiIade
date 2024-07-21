<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Session;
use App\Models\Question;
use App\Models\File;

class SettingController extends Controller
{
    public function index() {

        return view('dashboard.pages.settings.index');
    }

    public function sss() {
        $Questions = Question::orderBy('order', 'asc')->get();
        return view('dashboard.pages.settings.sss', compact('Questions'));
    }

    public function file() {
        $Files = File::all();
        return view('dashboard.pages.settings.file', compact('Files'));
    }

    public function settingsStore(Request $request) {
        $keys = array_keys($request->key);
        $to_create = [];

        foreach ($keys as $key) {
            if(isset($request->value[$key])) {
                $to_create[] = [
                    'key' => $key,
                    'value' => $request->value[$key]
                ];
            } else {
                $to_create[] = [
                    'key' => $key,
                    'value' => ''
                ];
            }
        }


        foreach ($to_create as $setting) {
                Setting::updateOrCreate(
                    ['key' => $setting['key']], // Eşleşme koşulu
                    ['value' => $setting['value']] // Güncellenecek veya oluşturulacak değer
                );
            }

        Session::flash('success', 'Ayarlar başarıyla güncellendi.');

        return redirect()->back()->with('success', 'Ayarlar başarıyla güncellendi.');

    }
}
