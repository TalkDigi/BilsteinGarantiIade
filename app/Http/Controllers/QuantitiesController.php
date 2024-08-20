<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Quantity;

class QuantitiesController extends Controller
{
    public function index()
    {

        //public altında processes klasörü içerisinde, waiting-jobs, running-jobs, completed-jobs, failed-jobs klasörleri oluşturulacak.
        //her klasör altındaki dosyalar toplanacak. dosya isimleri key olacak.

        $folders = ['waiting-jobs', 'running-jobs', 'completed-jobs', 'failed-jobs'];
        $statuses = [
            'waiting-jobs' => 'Sırada',
            'running-jobs' => 'Çalışıyor',
            'completed-jobs' => 'Tamamlandı',
            'failed-jobs' => 'Başarısız'
        ];

        foreach ($folders as $folder) {
            if (!file_exists(public_path('processes/' . $folder))) {
                mkdir(public_path('processes/' . $folder), 0777, true);
            }
        }

        //tüm $folders elementi altındaki dosyaları al bir arrayde sakla
        $files = [];

        foreach ($folders as $folder) {
            //get files inside the folder
            $insideFolders = array_diff(scandir(public_path('processes/' . $folder)), array('..', '.'));

            foreach ($insideFolders as $insideFolder) {

                $uuid = null;
                if($insideFolder == '.DS_Store') {
                    continue;
                }

                $lastDashPos = strrpos($insideFolder, '-');

                if ($lastDashPos !== false) {
                    $uuidWithExtension = substr($insideFolder, $lastDashPos + 1);
                    $uuid = substr($uuidWithExtension, 0, strrpos($uuidWithExtension, '.'));
                }

                $files[$insideFolder] = [
                    'status' => $statuses[$folder],
                    'uuid' => $uuid,
                    'created_at' => date('d.m.Y H:i:s', filectime(public_path('processes/' . $folder . '/' . $insideFolder))),
                ];
            }
        }

        $Quantities = Quantity::all();

        return view('dashboard.pages.settings.quantities.index', compact('files', 'Quantities'));
    }

    public function upload(Request $request) {
        //get file name
        $filename = $request->file('file')->getClientOriginalName();

        //generate a new file name. its should be $filename.extension-uniqueid
        $newFilename = $filename . '-' . uniqid() . '.' . $request->file('file')->getClientOriginalExtension();

        //check if public/processes/waiting-jobs is exist. if its not exist create it,give permission and then upload the file
        if (!file_exists(public_path('processes/waiting-jobs'))) {
            mkdir(public_path('processes/waiting-jobs'), 0777, true);
        }

        $request->file('file')->move(public_path('processes/waiting-jobs'), $newFilename);

        Session::flash('success', 'Dosya başarıyla yüklendi. Dosyanın boyutuna göre içe aktarma işlemi biraz zaman alabilir.');

        return redirect()->route('dashboard.setting.quantities');

    }

    public function delete($uuid) {
        $folders = ['waiting-jobs', 'running-jobs', 'completed-jobs', 'failed-jobs'];

       //bu klasörler içindeki tüm dosyaları topla.
        //eğer isimlerinin içinde bu uuid de geçiyorsa sil.
        foreach ($folders as $folder) {
            $files = array_diff(scandir(public_path('processes/' . $folder)), array('..', '.'));

            foreach ($files as $file) {
                if (strpos($file, $uuid) !== false) {
                    unlink(public_path('processes/' . $folder . '/' . $file));
                }
            }
        }

        //quantities tablosundan file_id =uuid ait kayıtları sil.
        Quantity::where('file_id', $uuid)->delete();

        Session::flash('success', 'Dosya başarıyla silindi.');
        return redirect()->route('dashboard.setting.quantities');
    }
}
