<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spu;
use DB;

class WelcomeController extends Controller
{
    /**
     * Display the homepage and recommend commodity
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $homepageProducts = Spu::take(8)->get()->toArray();
        return view('welcome')->with(['homepageProducts' => $homepageProducts]);
    }
}
