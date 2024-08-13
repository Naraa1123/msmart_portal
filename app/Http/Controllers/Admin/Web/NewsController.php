<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsImage;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\File;

class NewsController extends Controller
{
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originalName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originalName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            $request->file('upload')->move(public_path('media'), $fileName);
            $url = asset('/media/' . $fileName);
            return response()->json(
                ['fileName' => $fileName,
                    'uploaded' => 1,
                    'url' => $url]
            );
        }

    }

    public function index()
    {
        Paginator::useBootstrapFive();
        $news = News::orderBy('id', 'DESC')->paginate(10);
        return view('admin.web.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.web.news.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'youtube_link_1' => 'nullable',
            'youtube_link_2' => 'nullable',
            'status' => 'nullable',
            'image' => [
                'required'
            ]
        ]);

        $validatedData['status'] = $request->status == true ? '1' : '0';


        $news = News::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'youtube_link_1' => $validatedData['youtube_link_1'],
            'youtube_link_2' => $validatedData['youtube_link_2'],
            'status' => $validatedData['status']
        ]);

        if ($request->hasFile('image')) {
            $uploadPath = 'uploads/news/image/';

            $i = 1;
            foreach ($request->file('image') as $imageFile) {
                $extension = $imageFile->getClientOriginalExtension();
                $filename = time() . $i++ . '.' . $extension;
                $imageFile->move($uploadPath, $filename);
                $finalImagePathName = $uploadPath . $filename;

                $news->newsImages()->create([
                    'news_id' => $news->id,
                    'image' => $finalImagePathName
                ]);
            }
        }

        return redirect('admin/web/news')->with('message', 'News амжилттай нэмэгдлээ');
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('admin.web.news.edit', compact('news'));
    }

    public function update($id, Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'youtube_link_1' => 'nullable',
            'youtube_link_2' => 'nullable',
            'status' => 'nullable',
            'image' => [
                'nullable'
            ]
        ]);

        $news = News::findOrFail($id);

        if ($news) {
            $news->update([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'youtube_link_1' => $validatedData['youtube_link_1'],
                'youtube_link_2' => $validatedData['youtube_link_2'],
                'status' => $request->status == true ? '1' : '0',
            ]);

            if ($request->hasFile('image')) {
                $uploadPath = 'uploads/news/image/';
                $i = 1;

                foreach ($request->file('image') as $imageFile) {
                    $extension = $imageFile->getClientOriginalExtension();
                    $filename = time() . $i++ . '.' . $extension;
                    $imageFile->move($uploadPath, $filename);
                    $finalImagePathName = $uploadPath . $filename;

                    $news->newsImages()->create([
                        'news_id' => $news->id,
                        'image' => $finalImagePathName
                    ]);
                }
            }
            return redirect('admin/web/news')->with('message', 'News Updated Successfully!');
        } else {
            return redirect('admin/web/news')->with('message', 'No Such News Id Found!');
        }
    }

    public function destroyImage($id)
    {
        $newsImage = NewsImage::findOrFail($id);
        if (File::exists($newsImage->image)) {
            File::delete($newsImage->image);
        }
        $newsImage->delete();
        return redirect()->back()->with('message', 'News Image Deleted Successfully!');
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        if ($news->newsImages) {
            foreach ($news->newsImages as $image) {
                if (File::exists($image->image)) {
                    File::delete($image->image);
                }
            }
        }

        $news->delete();
        return redirect('admin/web/news')->with('message', 'News амжилттай устгадлаа');
    }
}
