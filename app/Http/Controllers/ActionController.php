<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Rating;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    public function ratingStore(Request  $request)
    {
        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
        ],[
            'rating.*' => 'Пожалуйста, оцените фильм ',
        ]);
        Rating::create([
            'tmdb_id' => $request->tmdb_id,
            'text' => $request->text,
            'rating' => $request->rating,
            'user_id' => auth()->user()->id,
        ]);
        return redirect()->back()->with('status', 'Ваш отзыв успешно добавлен! Спасибо за оценку!');
    }

    public function comment(Request   $request)
    {
        try {
            $request->validate([
                'comment' => 'required|string',
            ],[
                'comment.*' => 'Пожалуйста, напишите комментарий',
            ]);
            Comment::create([
                'tmdb_id' => $request->tmdb_id,
                'text' => $request->comment,
                'user_id' => auth()->user()->id,
            ]);

            return redirect()->back()->with('comment', 'Ваш коммент успешно создан!');

        }catch (\Exception $e){
            dd($e->getMessage());
        }

    }
}
