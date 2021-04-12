<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spu;

class AdminSpuController extends Controller
{
    /**
     * Display all spu's information
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $spus = Spu::paginate(10);
        return view('adminSpu')->with(['spus' => $spus]);
    }

    /**
     * edit the spu's information.
     *
     * @param int $spu_id
     * @return \Illuminate\Http\Response
     */
    public function edit($spu_id)
    {
        $spu = Spu::find($spu_id)->toArray();
        return view('adminEditSpu')->with([ 'spu' => $spu ]);
    }
}
