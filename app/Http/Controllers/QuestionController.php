<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{

    public function store(Request $request) {

        if($request->id != null) {

            $question = Question::find($request->id);

            if($question == null) {

                return redirect()->back()->with('error', 'Soru bulunamadı.');
            }

            if($request->status == 'on') {

                $question->status = 1;

            } else {

                $question->status = 0;

            }

            $question->order = $request->order;

            $question->title = $request->title;

            $question->text = $request->text;

            if($question->save()) {

                return redirect()->back()->with('success', 'Soru başarıyla güncellendi.');

            } else {

                return redirect()->back()->with('error', 'Soru güncellenirken bir hata oluştu.');

            }

        } else {

            $question = new Question();

            if($request->status == 'on') {

                $question->status = 1;

            } else {

                $question->status = 0;

            }
            $question->order = $request->order;

            $question->title = $request->title;

            $question->text = $request->text;

            if($question->save()) {

                return redirect()->back()->with('success', 'Soru başarıyla eklendi.');

            } else {

                return redirect()->back()->with('error', 'Soru eklenirken bir hata oluştu.');

            }

        }

    }

    public function destroy($id) {

        $question = Question::find($id);

        if($question == null) {

            return redirect()->back()->with('error', 'Soru bulunamadı.');

        }

        if($question->delete()) {

            return redirect()->back()->with('success', 'Soru başarıyla silindi.');

        } else {

            return redirect()->back()->with('error', 'Soru silinirken bir hata oluştu.');

        }

    }

}
