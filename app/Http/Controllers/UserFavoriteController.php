<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFavoriteController extends Controller
{
    // ワークスペースをお気に入りに登録するアクション
    public function store($id)
    {
        \Auth::user()->favorite($id);
        return back();
    }
    
    // ワークスペースのお気に入りを解除するアクション
    public function destroy($id)
    {
        \Auth::user()->unfavorite($id);
        return back();
    }
}
