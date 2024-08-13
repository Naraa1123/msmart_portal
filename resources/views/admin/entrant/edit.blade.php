@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>
                        Элсэх хүсэлт засах
                        <a href="{{ url('admin/entrant') }}" class="btn btn-primary btn-sm text-white float-end">BACK</a>
                    </h3>
                </div>

                <div class="card-body">
                    <form action="{{ url('admin/entrant/'.$entrant->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            <div class="col-md-12 mb-3">
                                <label for="department_id">Тэнхим</label>
                                <select name="department_id" class="form-control">
                                    @foreach ($deps as $dep)
                                        <option value="{{ $dep->id }}"{{ $dep->id == $entrant->department_id ? 'selected':'' }}>
                                            {{$dep->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="name">Нэр</label>
                                <input type="text" name="name" class="form-control" value="{{$entrant->name}}">
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" value="{{$entrant->email}}">
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="phone">Утас</label>
                                <input type="number" name="phone" class="form-control" value="{{$entrant->phone}}">
                                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <button type="submit" class="btn btn-primary float-end">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
