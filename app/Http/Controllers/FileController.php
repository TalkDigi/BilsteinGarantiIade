<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FileController extends Controller
{
    //

    public function store(Request $request) {
        Log::info('FileController@store', ['request' => $request->all()]);

        $fileName = $request->file('file')->getClientOriginalName();
        $fileName = str_replace(' ', '-', $fileName);
        $search = ['ç', 'Ç', 'ğ', 'Ğ', 'ı', 'İ', 'ö', 'Ö', 'ş', 'Ş', 'ü', 'Ü'];
        $replace = ['c', 'C', 'g', 'G', 'i', 'I', 'o', 'O', 's', 'S', 'u', 'U'];
        $fileName = str_replace($search, $replace, $fileName);

        //add uniqid to file name. as an example file.pdf should be file-uniqid.pdf
        $fileName = pathinfo($fileName, PATHINFO_FILENAME) . '-' . uniqid() . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
        Log::info('FileController@store', ['fileName' => $fileName]);

        if($request->file('file')->storeAs('public/application-files', $fileName)) {
            Log::info('Başarılı');
            return response()->json(['path' => $fileName]);
        } else {
            Log::info('Başarısız');
            return response()->json(['error' => 'File could not be uploaded.'], 500);
        }
    }

    public function quill(Request $request) {
        Log::info('FileController@quill', ['request' => $request->all()]);

        $fileName = $request->file('image')->getClientOriginalName();
        $fileName = str_replace(' ', '-', $fileName);
        $search = ['ç', 'Ç', 'ğ', 'Ğ', 'ı', 'İ', 'ö', 'Ö', 'ş', 'Ş', 'ü', 'Ü'];
        $replace = ['c', 'C', 'g', 'G', 'i', 'I', 'o', 'O', 's', 'S', 'u', 'U'];
        $fileName = str_replace($search, $replace, $fileName);

        //add uniqid to file name. as an example file.pdf should be file-uniqid.pdf
        $fileName = pathinfo($fileName, PATHINFO_FILENAME) . '-' . uniqid() . '.' . pathinfo($fileName, PATHINFO_EXTENSION);

        if($request->file('image')->storeAs('public/docs', $fileName)) {
            return response()->json(['url' => '/storage/docs/' . $fileName]);
        } else {
            Log::info('Başarısız');
            return response()->json(['error' => 'File could not be uploaded.'], 500);
        }
    }

    public function delete(Request $request) {
        //find file inside storage - application-files. delete it.
        $path = storage_path('app/public/application-files/' . $request->file);
        if(file_exists($path)) {
            unlink($path);
            return response()->json(['success' => true, 'message' => 'Dosya silindi.']);
        } else {
            return response()->json(['success' => true, 'message' => 'Dosya bulunamadı.']);
        }
    }
}
