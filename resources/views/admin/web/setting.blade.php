@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        Site information
                        <a href="{{ url('admin/dashboard') }}" class="btn btn-danger btn-sm text-white float-end">BACK</a>
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
                    <form action="{{ url('admin/web/setting/update/d03a7f43-f1e3-47b0-8a61-21e79df08c7f') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="mb-3">
                                <label for="web_name">WEB-ын үндсэн нэр</label>
                                <input type="text" name="web_name" value="{{ $web->web_name }}" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="address">Хаяг</label>
                                <textarea name="address" rows="3" class="form-control">{{ $web->address }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="web_logo">Logo</label>
                                <input type="file" name="web_logo" class="form-control" > <br>
                                <img src="{{ asset("$web->web_logo") }}" height="100px" width="150px" alt="web_logo">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" value="{{$web->email}}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone_number">Утас</label>
                                <input type="text" name="phone_number" class="form-control" value="{{ $web->phone_number}} ">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="account_number">Дансны дугаар</label>
                                <input type="number" name="account_number" class="form-control" value="{{$web->account_number}}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="account_name">Данс эзэмшигчийн нэр</label>
                                <input type="text" name="account_name" class="form-control" value="{{$web->account_name}}">
                            </div>

                            <div class="mb-3">
                                <label for="google_map_link">Google Map Link</label>
                                <input type="text" name="google_map_link" value="{{ $web->google_map_link }}" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="facebook_link">Facebook Link</label>
                                <input type="text" name="facebook_link" value="{{ $web->facebook_link }}" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="instagram_link">Instagram Link</label>
                                <input type="text" name="instagram_link" value="{{ $web->instagram_link }}" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="youtube_link">YouTube Link</label>
                                <input type="text" name="youtube_link" value="{{ $web->youtube_link }}" class="form-control">
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
