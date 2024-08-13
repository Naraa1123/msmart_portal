@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        Add Slider
                        <a href="{{ url('admin/web/slider') }}" class="btn btn-danger btn-sm text-white float-end">BACK</a>
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
                    <form action="{{ url('admin/web/slider/'.$slider->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            <div class="mb-3">
                                <label for="image">Image</label>
                                <input type="file" name="image" class="form-control"><br>
                                <img src="{{ asset("$slider->image") }}" height="100px" width="150px" alt="image">
                            </div>
                            <div class="mb-3">
                                <label for="status">Status</label>
                                <input type="checkbox" name="status" {{ $slider->status == '1' ? 'checked':'' }} >
                                (Checked = Hidden, Unchecked = Visible)
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary btn-sm float-end">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
