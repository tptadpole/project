<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Spu;

class WelcomeController extends Controller
{
    /**
     * Display the homepage and 前8個商品標題
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($users_id = Auth::id()) {
            $homepageProducts = Spu::where('users_id', '!=', $users_id)->take(8)->get()->toArray();
        } else {
            $homepageProducts = Spu::take(8)->get()->toArray();
        }
        
        return view('welcome')->with(['homepageProducts' => $homepageProducts]);
    }
}
