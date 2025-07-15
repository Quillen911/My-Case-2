<?php

namespace App\Http\Controllers\Web;

use Illuminate\Htpp\Request;
use App\Http\Controllers\Controller;

class SepetController extends Controller
{
    public function sepet()
    {
        return view('sepet');
    }
}