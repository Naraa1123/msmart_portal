@extends('layouts.teacher')

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            @if(Session('message'))
                <h2 class="alert alert-success">{{ Session('message') }}</h2>
            @endif
            <div class="card">
                <div class="card-header">
                    <h4>Profile</h4>
                </div>

                <div class="card-body">
                    <form action="{{ url('teacher/profile/password-update/'.$user->id) }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <div>Name: {{$user->userDetails->firstname}}</div>
                        <div>Хэрэглэгчийн код: {{$user->school_id}}</div>
                        <div>Утасны дугаар: {{$user->userDetails->phone_number_1}}</div>
                        <br>
                        <div class="row">

                            <div class="form-group">
                                <label>Current Password:</label>
                                <input type="password" class="form-control form-control-solid" name="old_password"
                                       placeholder="Current Password" required/>
                                @error('old-password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group">
                                <label>New Password:</label>
                                <input type="password" class="form-control form-control-solid" name="password"
                                       placeholder="New Password" required/>
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group">
                                <label>Repeat password</label>
                                <div class="input-group input-group-solid">
                                    <input for="password-confirm" type="password" name="password_confirmation"
                                           class="form-control form-control-solid" placeholder="Verify Password"
                                           required/>
                                    @error('password-confirm') <small
                                        class="text-danger">{{ $message }}</small> @enderror
                                </div>
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
