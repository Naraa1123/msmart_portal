@extends('layouts.admin')

@section('content')

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">
                        User Create
                    </h3>
                </div>

                <form action="{{ url('admin/user') }}" method="POST" enctype="multipart/form-data" >
                    @csrf
                    <div class="card-body">

                        <div class="form-group">
                            <label for="class">Анги</label>
                                <select class="form-control" name="class" id="class"
                                        required>
                                    @foreach($classes as $class)
                                        <option
                                            value="{{ $class->id }}" {{ old('class') == $class->id ? 'selected' : '' }}>{{ $class->name }} </option>
                                    @endforeach
                                </select>
                            @error('class') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-row">
                            <!-- Gender Field -->
                            <div class="form-group col-md-6">
                                <label for="gender">Хүйс сонгоно уу:</label>
                                <select name="gender" class="form-control" id="gender" required>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Эрэгтэй</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Эмэгтэй</option>
                                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Бусад</option>
                                </select>
                                @error('gender') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <!-- Role_as Field -->
                            <div class="form-group col-md-6">
                                <label for="role_as">Хэрэглэгчийн төрөл</label>
                                <select name="role_as" class="form-control" id="role_as">
                                    <option value="3" {{ old('role_as') == '3' ? 'selected' : '' }}>Оюутан</option>
                                    <option value="2" {{ old('role_as') == '2' ? 'selected' : '' }}>Багш</option>
                                    <option value="4" {{ old('role_as') == '4' ? 'selected' : '' }}>Оператор</option>
                                    <option value="5" {{ old('role_as') == '5' ? 'selected' : '' }}>Санхүүч</option>
                                </select>
                                @error('role_as') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="lastname" class="col-2 col-form-label">Овог</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">#</span></div>
                                    <input placeholder="энд овог бичнэ үү" name="lastname" class="form-control"
                                           type="text" value="{{old('lastname')}}"
                                           id="lastname" required/>
                                </div>
                                @error('lastname') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="firstname" class="col-2 col-form-label">Нэр</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">#</span></div>
                                    <input placeholder="энд нэр бичнэ үү" name="firstname" class="form-control"
                                           type="text" value="{{old('firstname')}}"
                                           id="firstname" required/>
                                </div>
                                @error('firstname') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="email" class="col-2 col-form-label">Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">@</span></div>
                                    <input placeholder="энд email бичнэ үү" name="email" class="form-control"
                                           type="email" value="{{old('email')}}"
                                           id="email"/>
                                </div>
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="registration_number" class="col-4 col-form-label">Регистерийн дугаар</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">РД</span></div>
                                    <input placeholder="энд регистерийн дугаар бичнэ үү" name="registration_number" class="form-control"
                                           type="text" value="{{old('registration_number')}}"
                                           id="registration_number" required/>
                                </div>
                                @error('registration_number') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="phone_number_1" class="col-4 col-form-label">Утасны дугаар 1</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">#</span></div>
                                    <input placeholder="энд утасны дугаар бичнэ үү" name="phone_number_1" class="form-control"
                                           type="number" value="{{old('phone_number_1')}}"
                                           id="phone_number_1" required/>
                                </div>
                                @error('phone_number_1') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="phone_number_2" class="col-4 col-form-label">Утасны дугаар 2</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">#</span></div>
                                    <input placeholder="энд утасны дугаар бичнэ үү" name="phone_number_2" class="form-control"
                                           type="number" value="{{old('phone_number_2')}}"
                                           id="phone_number_2" required/>
                                </div>
                                @error('phone_number_2') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label for="phone_number_3" class="col-4 col-form-label">Утасны дугаар 3</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">#</span></div>
                                    <input placeholder="энд утасны дугаар бичнэ үү" name="phone_number_3" class="form-control"
                                           type="number" value="{{old('phone_number_3')}}"
                                           id="phone_number_3" />
                                </div>
                                @error('phone_number_3') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>


                            <div class="form-group col-md-6">
                                <label for="guardian_name" class="col-6 col-form-label">Асран хамгаалагчийн нэр</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">#</span></div>
                                    <input placeholder="асран хамгаалагчийн нэрийг нэр бичнэ үү" name="guardian_name" class="form-control"
                                           type="text" value="{{old('guardian_name')}}"
                                           id="guardian_name"/>
                                </div>
                                @error('guardian_name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>


                            <div class="form-group col-md-6">
                                <label for="guardian_phone_number" class="col-6 col-form-label">Асран хамгаалагчын дугаар</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">#</span></div>
                                    <input placeholder="асран хамгаалагчийн утасны дугаарыг бичнэ үү" name="guardian_phone_number" class="form-control"
                                           type="number" value="{{old('guardian_phone_number')}}"
                                           id="guardian_phone_number" />
                                </div>
                                @error('guardian_phone_number') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="date_of_birth" class="col-6 col-form-label">Төрсөн он сар өдөр оруулна уу</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">&</span></div>
                                    <input name="date_of_birth" class="form-control"
                                           type="date" value="{{old('date_of_birth')}}"
                                           id="date_of_birth" />
                                </div>
                                @error('date_of_birth') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="admission_year" class="col-6 col-form-label">Элссэн он сар өдөр оруулна уу</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">&</span></div>
                                    <input name="admission_year" class="form-control"
                                           type="date" value="{{old('admission_year')}}"
                                           id="admission_year" />
                                </div>
                                @error('admission_year') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label>Зураг хавсаргана уу</label>
                                <div></div>
                                <div class="custom-file">
                                    <input name="image" type="file" class="custom-file-input form-control" id="image" value="{{old('image')}}"/>
                                    <label class="custom-file-label" for="image" >Зураг хавсаргана уу</label>
                                </div>
                                @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="made_contract">Гэрээ байгуулсан эсэх</label>
                                <select name="made_contract" class="form-control" id="made_contract">
                                    <option value="no" {{ old('made_contract') == 'no' ? 'selected' : '' }}>Үгүй</option>
                                    <option value="yes" {{ old('made_contract') == 'yes' ? 'selected' : '' }}>Тийм</option>
                                </select>
                                @error('made_contract') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Гэрээ хавсаргана уу</label>
                                <div></div>
                                <div class="custom-file">
                                    <input name="contract[]" multiple
                                    
                                           type="file"
                                           class="custom-file-input form-control"
                                           id="contract" value="{{old('contract')}}"/>
                                    <label class="custom-file-label" for="contract" >Гэрээнүүд хавсаргана уу /олон байх боломжтой/</label>
                                </div>
                                @error('contract') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label for="address" class="col-6 col-form-label">Хаяг оруулна уу</label>
                                <div class="input-group">
                                    <textarea name="address" class="form-control" id="address">{{old('address')}}</textarea>
                                </div>
                                @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <hr>

                        <div id="feeSection" style="display: none;">
                                <h3 class="card-title">
                                    Төлбөрийн хэсэг
                                </h3>

                            <div class="form-group col-md-12">
                                <label for="total_amount" class="col-6 col-form-label">Үндсэн төлбөр</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">#</span></div>
                                    <input placeholder="үндсэн төлбөрийг бичнэ үү" name="total_amount" class="form-control"
                                           type="number" value="{{old('total_amount')}}"
                                           id="total_amount" />
                                </div>
                                @error('total_amount') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label for="discount_percentage" class="col-6 col-form-label">Хямдралын хувь</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">%</span></div>
                                    <input placeholder="хямдралын хувь бичнэ үү" name="discount_percentage" class="form-control"
                                           type="number" value="{{old('discount_percentage')}}"
                                           id="discount_percentage"
                                           min="0"
                                           max="100"/>
                                </div>
                                @error('discount_percentage') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>


                            <div class="form-group col-md-12">
                                <label for="due_amount" class="col-6 col-form-label">Төлөх дүн</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">#</span></div>
                                    <input placeholder="төлөх дүн бичнэ үү" name="due_amount" class="form-control"
                                           type="number" value="{{old('due_amount')}}"
                                           id="due_amount"
                                           min="0"
                                           disabled
                                    />
                                </div>
                                @error('due_amount') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>


                            <div class="form-group col-md-12">
                                <label for="paid_amount" class="col-6 col-form-label">Төлсөн дүн</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">#</span></div>
                                    <input placeholder="төлсөн дүн бичнэ үү" name="paid_amount" class="form-control"
                                           type="number" value="{{old('paid_amount')}}"
                                           id="paid_amount"
                                           min="0"/>
                                </div>
                                @error('paid_amount') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label for="outstanding_amount" class="col-6 col-form-label">Үлдэгдэл дүн</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">#</span></div>
                                    <input name="outstanding_amount" class="form-control"
                                           type="number" value="{{old('outstanding_amount')}}"
                                           id="outstanding_amount"
                                           disabled/>
                                </div>
                                @error('outstanding_amount') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label for="payment_method">Төлөлтийн хэлбэр</label>
                                <select name="payment_method" class="form-control" id="payment_method">
                                    <option
                                        value="TRANSFERRED" {{ old('payment_method') == 'бэлнээр' ? 'selected' : '' }}>
                                        ШИЛЖҮҮЛЭГ
                                    </option>
                                    <option
                                        value="CASH" {{ old('payment_method') == 'дансаар' ? 'selected' : '' }}>
                                        БЭЛЭН_МӨНГӨ
                                    </option>
                                    <option value="ББСБ" {{ old('payment_method') == 'ББСБ' ? 'selected' : '' }}>
                                        ББСБ
                                    </option>
                                </select>
                                @error('payment_method') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label for="payment_description" class="col-6 col-form-label">Төлөлтийн тайлбар</label>
                                <div class="input-group">
                                    <textarea name="payment_description" class="form-control" id="payment_description">{{old('payment_description')}}</textarea>
                                </div>
                                @error('payment_description') <small class="text-danger">{{ $message }}</small> @enderror
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

    <script>
        var KTSelect2 = function () {
            var demos = function () {
                // basic
                $('#class').select2({
                    placeholder: "Select a class"
                });

            }

            var modalDemos = function () {
                $('#class_modal').on('shown.bs.modal', function () {
                    // basic
                    $('#class_modal').select2({
                        placeholder: "Select a class"
                    });
                });
            }

            // Public functions
            return {
                init: function () {
                    demos();
                    modalDemos();
                }
            };
        }();

        // Initialization
        jQuery(document).ready(function () {
            KTSelect2.init();
        });
    </script>


    <script>

        document.getElementById('total_amount').addEventListener('input', updateTotalAmount);
        document.getElementById('discount_percentage').addEventListener('input', updateTotalAmount);
        document.getElementById('paid_amount').addEventListener('input', calculateOutstandingAmount);

        function updateTotalAmount() {
            var principalAmount = parseFloat(document.getElementById('total_amount').value) || 0;
            var discountPercentage = parseFloat(document.getElementById('discount_percentage').value) || 0;

            // Ensure discount percentage is within bounds
            if (discountPercentage < 0 || discountPercentage > 100) {
                alert('Хямдралын хувь 0% ~ 100% ын хоорондох утга л оруулах боломжтой');
                document.getElementById('discount_percentage').value = '';
                return;
            }

            var totalAmount = principalAmount * (1 - discountPercentage / 100);
            document.getElementById('due_amount').value = totalAmount.toFixed(2);
        }

        function calculateOutstandingAmount() {
            var totalAmount = parseFloat(document.getElementById('due_amount').value) || 0;
            var paidAmount = parseFloat(document.getElementById('paid_amount').value) || 0;
            var outstandingAmount = totalAmount - paidAmount;
            document.getElementById('outstanding_amount').value = outstandingAmount.toFixed(2);
        }

    </script>

    <script>
        document.getElementById('role_as').addEventListener('change', function() {
            var selectedRole = this.value;
            var feeSection = document.getElementById('feeSection');

            if(selectedRole == '3') {
                feeSection.style.display = 'block';
            } else {
                feeSection.style.display = 'none';
            }
        });

        document.getElementById('role_as').dispatchEvent(new Event('change'));
    </script>
@endsection
