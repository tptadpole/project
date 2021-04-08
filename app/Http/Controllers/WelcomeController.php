<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spu;
use DB;

class WelcomeController extends Controller
{
    /**
     * Show the homepage and recommend commodity
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $homepageProducts = Spu::all()->toArray();
        return view('welcome')->with(['homepageProducts' => $homepageProducts]);
    }
}
