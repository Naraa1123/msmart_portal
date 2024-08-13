@extends('layouts.admin')

@section('content')

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">
                        User Edit
                    </h3>
                </div>

                <form action="{{ url('admin/user/'.$user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">

                        @if($user->role_as == 3)
                            <div class="form-group">
                                <label for="class">Анги</label>
                                <select class="form-control" name="class" id="class">
                                    @foreach($classes as $class)
                                        <option
                                            value="{{ $class->id }}"
                                            {{ (old('class') ? old('class') : $currentUserClassId) == $class->id ? 'selected' : '' }}>{{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('class') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        @endif


                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="gender">Хүйс:</label>
                                <select name="gender" class="form-control" id="gender" required>
                                    <option value="male" {{ $user->userDetails->gender == 'male' ? 'selected' : '' }}>
                                        Эрэгтэй
                                    </option>
                                    <option
                                        value="female" {{ $user->userDetails->gender == 'female' ? 'selected' : '' }} >
                                        Эмэгтэй
                                    </option>
                                    <option
                                        value="other" {{ $user->userDetails->gender == 'other' ? 'selected' : '' }} >
                                        Бусад
                                    </option>
                                </select>
                                @error('gender') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="status">Төлөв</label>
                                <select name="status" class="form-control" id="status">
                                    <option value="studying" {{$userDetail->status == 'studying' ? 'selected' : ''}}>
                                        Суралцаж байгаа
                                    </option>
                                    <option value="graduated" {{$userDetail->status == 'graduated' ? 'selected' : ''}}>
                                        Төгссөн
                                    </option>
                                    <option
                                        value="took_leave" {{$userDetail->status == 'took_leave' ? 'selected' : ''}}>
                                        Чөлөө авсан
                                    </option>
                                    <option
                                        value="dropped_out" {{$userDetail->status == 'dropped_out' ? 'selected' : ''}}>
                                        Гарсан
                                    </option>
                                </select>
                                @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                        </div>
                        <div class="form-group" id="reasonField"
                             style="display: {{$userDetail->status != 'studying' ? 'block' : 'none'}};">
                            <label for="reason">Тайлбар</label>
                            <div class="input-group">
                                <input name="reason" class="form-control"
                                       type="text" value="{{$userDetail->reason}}"
                                       id="reason"/>
                            </div>
                        </div>
                        <div class="form-row" >
                            <div class="form-group col-md-6">
                                <label for="lastname" class="col-2 col-form-label">Овог</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">#</span></div>
                                    <input placeholder="энд овог бичнэ үү" name="lastname" class="form-control"
                                           type="text" value="{{$userDetail->lastname}}"
                                           id="lastname" required/>
                                </div>
                                @error('lastname') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="firstname" class="col-2 col-form-label">Нэр</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">#</span></div>
                                    <input placeholder="энд нэр бичнэ үү" name="firstname" class="form-control"
                                           type="text" value="{{$userDetail->firstname}}"
                                           id="firstname" required/>
                                </div>
                                @error('firstname') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="email" class="col-2 col-form-label">Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">@</span></div>
                                    <input placeholder="энд email бичнэ үү" name="email" class="form-control"
                                           type="email" value="{{$user->email}}"
                                           id="email"/>
                                </div>
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="registration_number" class="col-4 col-form-label">Регистерийн дугаар</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">РД</span></div>
                                    <input placeholder="энд регистерийн дугаар бичнэ үү" name="registration_number"
                                           class="form-control"
                                           type="text" value="{{$userDetail->registration_number}}"
                                           id="registration_number" required/>
                                </div>
                                @error('registration_number') <small
                                    class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="phone_number_1" class="col-4 col-form-label">Утасны дугаар 1</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">#</span></div>
                                    <input placeholder="энд утасны дугаар бичнэ үү" name="phone_number_1"
                                           class="form-control"
                                           type="number" value="{{$userDetail->phone_number_1}}"
                                           id="phone_number_1" required/>
                                </div>
                                @error('phone_number_1') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="phone_number_2" class="col-4 col-form-label">Утасны дугаар 2</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">#</span></div>
                                    <input placeholder="энд утасны дугаар бичнэ үү" name="phone_number_2"
                                           class="form-control"
                                           type="number" value="{{$userDetail->phone_number_2}}"
                                           id="phone_number_2" required/>
                                </div>
                                @error('phone_number_2') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="phone_number_3" class="col-4 col-form-label">Утасны дугаар 3</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">#</span></div>
                                    <input placeholder="энд утасны дугаар бичнэ үү" name="phone_number_3"
                                           class="form-control"
                                           type="number" value="{{$userDetail->phone_number_3}}"
                                           id="phone_number_3"/>
                                </div>
                                @error('phone_number_3') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>


                            <div class="form-group col-md-6">
                                <label for="guardian_name" class="col-6 col-form-label">Асран хамгаалагчийн нэр</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">#</span></div>
                                    <input placeholder="асран хамгаалагчийн нэрийг нэр бичнэ үү" name="guardian_name"
                                           class="form-control"
                                           type="text" value="{{$userDetail->guardian_name}}"
                                           id="guardian_name"/>
                                </div>
                                @error('guardian_name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>


                            <div class="form-group col-md-6">
                                <label for="guardian_phone_number" class="col-6 col-form-label">Асран хамгаалагчын
                                    дугаар</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">#</span></div>
                                    <input placeholder="асран хамгаалагчийн утасны дугаарыг бичнэ үү"
                                           name="guardian_phone_number" class="form-control"
                                           type="number" value="{{$userDetail->guardian_phone_number}}"
                                           id="guardian_phone_number"/>
                                </div>
                                @error('guardian_phone_number') <small
                                    class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="date_of_birth" class="col-6 col-form-label">Төрсөн он сар өдөр оруулна
                                    уу</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">&</span></div>
                                    <input name="date_of_birth" class="form-control"
                                           type="date" value="{{$userDetail->date_of_birth}}"
                                           id="date_of_birth"/>
                                </div>
                                @error('date_of_birth') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="admission_year" class="col-6 col-form-label">Элссэн он сар өдөр оруулна
                                    уу</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">&</span></div>
                                    <input name="admission_year" class="form-control"
                                           type="date" value="{{$userDetail->admission_year}}"
                                           id="admission_year"/>
                                </div>
                                @error('admission_year') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="made_contract">Гэрээ байгуулсан эсэх</label>
                                <select name="made_contract" class="form-control" id="made_contract">
                                    <option value="no" {{ $userDetail->made_contract == 'no' ? 'selected' : '' }}>Үгүй</option>
                                    <option value="yes" {{ $userDetail->made_contract == 'yes' ? 'selected' : '' }}>Тийм</option>
                                </select>
                                @error('made_contract') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Зураг хавсаргана уу</label>
                                <div></div>
                                <div class="custom-file">
                                    <input name="image" type="file" class="custom-file-input form-control" id="image"/>
                                    <label class="custom-file-label" for="image">Зураг хавсаргана уу</label>
                                    <img src="{{ asset("$userDetail->image") }}" height="100px" width="150px"
                                         alt="image">
                                </div>
                                @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label for="address" class="col-6 col-form-label">Хаяг оруулна уу</label>
                                <div class="input-group">
                                    <textarea name="address" class="form-control"
                                              id="address">{{$userDetail->address}}</textarea>
                                </div>
                                @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>


                        <div class="card-footer">
                            <div class="row">
                                <div class="col-2">
                                </div>
                                <div class="col-10">
                                    <button type="submit" class="btn btn-success mr-2">UPDATE</button>
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
        document.getElementById('status').addEventListener('change', function () {
            var reasonField = document.getElementById('reasonField');
            if (this.value !== 'studying') {
                reasonField.style.display = 'block';
            } else {
                reasonField.style.display = 'none';
            }
        });
    </script>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>

@endsection
