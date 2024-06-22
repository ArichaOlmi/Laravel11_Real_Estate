<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Slider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {
        $sliders = Slider::get();

        return view('frontend.homepage', compact('sliders'));
    }
}
