<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {

        // ログインユーザーに紐づく最初のフォルダを取得する
        $folder = Auth::user()->folders()->first();

        return view('home', [
            'my_folder_id' => $folder->id,
        ]);
    }
}
