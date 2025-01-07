@extends('layouts.app')

@section('content')

    <div class="login-student">
        <div class="row" style="padding: 0; margin: 0;">
            <div class="col-md-4" style="padding: 0; margin: 0;">
                <div class="welcome-text">
                    Та М Смарт академийн <b>Portal<br> системд</b> тавтай морилно уу.
                </div>
                <div class="login-form">
                    <form method="POST" action="{{ route('login') }}" class="login-system">
                        @csrf
                        <div class="logo-img">
                            <img src="https://msmart.mn/uploads/web_data_setting/1704178380.png" alt="" width="100%">
                        </div>
                        <h3>Нэвтрэх</h3>

                        <label for="school_id">{{ __('Оюутны код') }}</label>
                        <input type="text" placeholder="Оюутны код" id="school_id" class="form-control @error('school_id') is-invalid @enderror" name="school_id" value="{{ old('school_id') }}" required autofocus>
                        @error('school_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror



                        <label for="password">{{__('Нууц үг')}}</label>
                        <input id="password" type="password" placeholder="Нууц үг"
                               class="form-control @error('password') is-invalid @enderror" name="password" required
                               autocomplete="current-password">

                        <div class="show">
                            <input type="checkbox" id="togglePassword" style="display: none;">
                            <span id="eyeIcon" class="fa fa-eye"></span>
                        </div>


                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        @if(session('error'))
                            <div class="bg-red-500 text-white p-4 rounded-md">
                                {{ session('error') }}
                            </div>
                        @endif

                        <button type="submit" class="student-button">{{ __('Нэвтрэх') }}</button>
                    </form>



                </div>
            </div>
            <div class="col-md-8">
                <div class="student-right-img"></div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("eyeIcon").addEventListener("click", function() {
            var passwordInput = document.getElementById('password');
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                this.classList.remove("fa-eye");
                this.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                this.classList.remove("fa-eye-slash");
                this.classList.add("fa-eye");
            }
        });


    </script>



@endsection

