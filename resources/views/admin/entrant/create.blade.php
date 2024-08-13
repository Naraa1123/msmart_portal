@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>
                        Элсэх хүсэлт нэмэх
                        <a href="{{ url('admin/entrant') }}" class="btn btn-primary btn-sm text-white float-end">BACK</a>
                    </h3>
                </div>

                <div class="card-body">
                    <form action="{{ url('admin/entrant') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-md-12 mb-3">
                                <label for="department_id">Тэнхим</label>
                                <select name="department_id" class="form-control">
                                    @foreach ($deps as $dep)
                                        <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="name">Нэр</label>
                                <input type="text" name="name" class="form-control" value="{{old('name')}}">
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" value="{{old('email')}}">
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="phone">Утас</label>
                                <input type="number" name="phone" class="form-control" value="{{old('phone')}}">
                                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <button type="submit" class="btn btn-primary float-end">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
