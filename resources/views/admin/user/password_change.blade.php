@extends('layouts.admin')

@section('content')

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">
                        {{$user->userDetails->firstname}} хэрэглэгчийн нэвтрэх нууц үгийг солих
                    </h3>
                </div>

                <form action="{{ url('admin/user/password_update/'.$user->id) }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">


                        <div class="form-group row">
                            <label for="password" class="col-2 col-form-label">Нууц үг:</label>
                            <div class="col-12">
                                <input id="password" type="password" class="form-control form-control-solid" name="password"
                                       placeholder="Нууц үг" required/>
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="abbreviation" class="col-2 col-form-label">Нууц үг баталгаажуулах:</label>
                            <div class="col-12">
                                <input for="password-confirm" type="password" name="password_confirmation"
                                       class="form-control form-control-solid" placeholder="Нууц үг дахин бичнэ үү"
                                       required/>
                                @error('password-confirm') <small
                                    class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>



                        <div class="card-footer">
                            <div class="row">
                                <div class="col-2">
                                </div>
                                <div class="col-10">
                                    <button type="submit" class="btn btn-success mr-2">SAVE</button>
                                    <button type="button" class="btn btn-secondary" onclick="goBack()">BACK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
@endsection
