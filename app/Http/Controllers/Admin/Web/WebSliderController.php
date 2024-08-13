<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use App\Models\WebSlider;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\File;

class WebSliderController extends Controller
{
    public function index()
    {
        Paginator::useBootstrapFive();
        $sliders = WebSlider::orderBy('id', 'DESC')->paginate(10);
        return view('admin.web.slider.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.web.slider.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'required|image'
        ]);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('uploads/slider/',$filename);
            $validatedData['image'] = 'uploads/slider/'.$filename;
        }

        $validatedData['status'] = $request->status == true ? '1':'0';

        WebSlider::create([
            'image' => $validatedData['image'],
            'status' => $validatedData['status']
        ]);

        return redirect('admin/web/slider')->with('message', 'Slider Added Successfully!');
    }

    public function edit($id)
    {
        $slider = WebSlider::findOrFail($id);
        return view('admin.web.slider.edit', compact('slider'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'image' => 'required|image'
        ]);

        $slider = WebSlider::findOrFail($id);

        if($request->hasFile('image')){

            $destination = $slider->image;

            if(File::exists($destination)){
                File::delete($destination);
            }

            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('uploads/slider/',$filename);
            $validatedData['image'] = 'uploads/slider/'.$filename;
        }

        $validatedData['status'] = $request->status == true ? '1':'0';

        WebSlider::where('id', $slider->id)->update([
            'image' => $validatedData['image'] ?? $slider->image,
            'status' => $validatedData['status']
        ]);

        return redirect('admin/web/slider')->with('message', 'Slider Updated Successfully!');
    }

    public function destroy($id)
    {
        $slider = WebSlider::find($id);

        if($slider->count() > 0){
            $destination = $slider->image;
            if(File::exists($destination))
            {
                File::delete($destination);
            }

            $slider->delete();
            return redirect('admin/web/slider')->with('message', 'Slider Deleted Successfully!');
        }
        return redirect('admin/web/slider')->with('message', 'Something went wrong!');
    }
}
