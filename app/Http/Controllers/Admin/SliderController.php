<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\SliderRequest;
// use Illuminate\Http\File;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class SliderController extends Controller
{
   
    public function index(): View
    {
        $sliders = Slider::get();

        return view('admin.sliders.index', compact('sliders'));
    }

    public function create(): View
    {
        return view('admin.sliders.create');
    }

    public function store(SliderRequest $request): RedirectResponse
    {
        if($request->validated()){
            $banner = $request->file('banner')->store('assets/slider','public');
            Slider::create($request->except('banner') + ['banner' => $banner]);
        }

        return redirect()->route('admin.sliders.index')->with([
            'message' => 'successfully created !',
            'alert-type' => 'success'
        ]);
    }

    public function edit(Slider $slider): View
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(SliderRequest $request, Slider $slider): RedirectResponse
    {
        if($request->validated()){
            if($request->banner){
                File::delete('storage/' . $slider->banner);
                $banner = $request->file('banner')->store('assets/slider','public');
                $slider->update($request->except('banner') + ['banner' => $banner]);
            }else {
                $slider->update($request->validated());
            }
        }

        return redirect()->route('admin.sliders.index')->with([
            'message' => 'successfully updated !',
            'alert-type' => 'info'
        ]);
    }

    public function destroy(Slider $slider): RedirectResponse
    {
        File::delete('storage/' . $slider->banner);
        $slider->delete();

        return back()->with([
            'message' => 'successfully deleted !',
            'alert-type' => 'danger'
        ]);
    }
}