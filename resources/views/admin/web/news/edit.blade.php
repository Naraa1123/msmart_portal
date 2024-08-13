@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add News
                        <a href="{{ url('admin/web/news') }}" class="btn btn-primary btn-sm text-white float-end">BACK</a>
                    </h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-warning">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ url('admin/web/news/'.$news->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">
                                    Home
                                </button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="image-tab" data-bs-toggle="tab" data-bs-target="#image-tab-pane" type="button" role="tab" aria-controls="image-tab-pane" aria-selected="false">
                                    News Image
                                </button>
                            </li>

                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade border p-3 show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">

                                <div class="mb-3">
                                    <label for="title">Гарчиг</label>
                                    <input type="text" name="title" class="form-control" value="{{ $news->title }}">
                                </div>

                                <div class="mb-3">
                                    <label for="description">Тайлбар</label>
                                    <textarea id="editor" name="description" class="form-control" rows="4">{{$news->description}}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="youtube_link_1">Youtube Link 1 (Заавал биш)</label>
                                    <input type="text" name="youtube_link_1" class="form-control" value="{{$news->youtube_link_1}}">
                                </div>

                                <div class="mb-3">
                                    <label for="youtube_link_2">Youtube Link 2 (Заавал биш)</label>
                                    <input type="text" name="youtube_link_2" class="form-control" value="{{$news->youtube_link_2}}">
                                </div>

                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <input type="checkbox" name="status" {{ $news->status == '1' ? 'checked':'' }} >
                                    (Checked = Private, Unchecked = Public)
                                </div>

                            </div>


                            <div class="tab-pane fade border p-3" id="image-tab-pane" role="tabpanel" aria-labelledby="image-tab" tabindex="0">
                                <div class="mb-3">
                                    <label>Upload Product Image</label><br><br>
                                    <input type="file" class="form-control" name="image[]" multiple />
                                </div>
                                <div>
                                    @if ($news->newsImages)
                                        <div class="row">
                                            @foreach ($news->newsImages as $image)
                                                <div class="col-md-2">
                                                    <img src="{{ asset($image->image) }}" style="width:80px; height:80px;"  class="me-4 border" alt="image">
                                                    <a href="{{ url('admin/web/news-image/delete/'.$image->id) }}" class="d-block" >Remove</a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        No Image Found
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary float-end">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            });
    </script>

@endsection
