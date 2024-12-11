@extends('layouts.admin')

@section('style')
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.5')}}" rel="stylesheet"
          type="text/css"/>
    <!--end::Page Vendors Styles-->
@endsection

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">

                <!--begin::Card-->
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon2-favourite text-primary"></i>
                        </span>
                            <h3 class="card-label">Төлбөрийн мэдээллүүд</h3>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="row align-items-center">
                            <div class="col-lg-12 col-xl-12">
                                <div class="row align-items-center">
                                    <!-- Class Filter -->
                                    <div class="col-md-3 col-sm-12 my-2">
                                        <div class="d-flex align-items-center">
                                            <label for="filterClass" class="mr-3 mb-0">Анги:</label>
                                            <select id="filterClass" class="form-control">
                                                <option value="">Анги сонгоно уу:</option>
                                                @foreach($classes as $class)
                                                    <option value="{{$class->name}}">{{$class->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-sm-12 my-2">
                                        <div class="d-flex align-items-center">
                                            <label for="filterPayment" class="mr-3 mb-0">Төлбөр:</label>
                                            <select id="filterPayment" class="form-control">
                                                <option value="">Төлбөр сонгоно уу:</option>
                                                <option value="paid">Бүх төлбөрөө төлсөн</option>
                                                <option value="partial">Төлбөрийн үлдэгдэлтэй</option>
                                                <option value="unpaid">Төлбөр төлөөгүй</option>
                                            </select>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                        <br>


                        <!--begin: Datatable-->
                        <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                               style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Анги</th>
                                <th>Оюутны овог нэр</th>
                                <th>Оюутны код</th>
                                <th>Утасны дугаарууд</th>
                                <th>Үндсэн дүн</th>
                                <th>Хямдрал</th>
                                <th>Төлөх дүн</th>
                                <th>Төлсөн Нийт Дүн</th>
                                <th>Үлдэгдэл Дүн</th>
                                <th>Үйлдэл</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($payments as $key=>$item)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>@if(!empty($item->user->class->name))
                                            {{$item->user->class->name}}
                                        @endif</td>
                                    <td>{{$item->user->userDetails->lastname}} {{$item->user->userDetails->firstname}}</td>
                                    <td>{{$item->user->school_id}} </td>
                                    <td>
                                        {{$item->user->userDetails->phone_number_1}}
                                        {{$item->user->userDetails->phone_number_2}}
                                        {{$item->user->userDetails->phone_number_3}}
                                        {{$item->user->userDetails->guardian_phone_number}}
                                    </td>

                                    <td>@mongolian_currency($item->total_amount)₮</td>
                                    <td>{{$item->discount_percentage}}%</td>
                                    <td>@mongolian_currency($item->due_amount)₮</td>

                                    <td>
                                        @php
                                            $totalPaid = $item->fees->sum('paid_amount');
                                        @endphp
                                        @mongolian_currency($totalPaid)₮
                                    </td>

                                    <td>
                                        @php
                                            $remainingAmount = $item->due_amount - $totalPaid;
                                        @endphp
                                        @mongolian_currency($remainingAmount)₮
                                    </td>

                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#payHistoryModal{{$item->id}}"
                                           class="btn btn-warning btn-sm">
                                            <i class="las la-book-open"></i>
                                        </a>

                                        <a href="#" data-toggle="modal" data-target="#payModal{{$item->id}}"
                                           class="btn btn-success btn-sm">
                                            <i class="las la-money-check-alt"></i>
                                        </a>

                                        <div class="modal fade" id="payHistoryModal{{$item->id}}" tabindex="-1"
                                             role="dialog" aria-labelledby="payHistoryModalLabel{{$item->id}}"
                                             aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="payHistoryModalLabel{{$item->id}}">
                                                            Төлбөрийн түүх</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th>Төлсөн дүн</th>
                                                                <th>Төлбөрийн арга</th>
                                                                <th>Тайлбар</th>
                                                                <th>Төлсөн огноо</th>
                                                                <th>Зураг</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($item->fees as $fee)
                                                                <tr>
                                                                    <td>@mongolian_currency($fee->paid_amount)₮</td>
                                                                    <td>{{$fee->payment_method}}</td>
                                                                    <td>{{$fee->description}}</td>
                                                                    <td>{{$fee->paid_date}}</td>
                                                                    <td>
                                                                        <img src="{{ asset($fee->payment_image) }}" style="width:50px; height:50px;" class="me-4 border img-thumbnail" alt="зураг байхгүй" data-toggle="modal" data-target="#imageModal{{ $loop->index }}">

                                                                        <div class="modal fade" id="imageModal{{ $loop->index }}" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel{{ $loop->index }}" aria-hidden="true">
                                                                            <div class="modal-dialog modal-lg" role="document">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="imageModalLabel{{ $loop->index }}">Гүйлгээний эсвэл төлбөрийн баримт зураг</h5>
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                            <span aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <img src="{{ asset($fee->payment_image) }}" class="img-fluid" alt="Responsive image">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Хаах
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="payModal{{$item->id}}" tabindex="-1" role="dialog"
                                             aria-labelledby="payModalLabel{{$item->id}}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="payModalLabel{{$item->id}}">Төлбөр
                                                            төлөх</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form
                                                        action="{{ route('admin.payment.pay', ['id' => encrypt($item->id) ]) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">

                                                            <label for="paid_amount">Төлбөрийн мөнгөн дүн: </label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend"><span
                                                                        class="input-group-text">₮</span></div>
                                                                <input placeholder="төлсөн дүн бичнэ үү"
                                                                       name="paid_amount" class="form-control"
                                                                       type="number"
                                                                       id="paid_amount"
                                                                       min="100"
                                                                       max="{{$remainingAmount}}"
                                                                       required/>
                                                            </div>

                                                            <label for="payment_method">Төлөлтийн хэлбэр</label>
                                                            <select name="payment_method" class="form-control"
                                                                    id="payment_method" required>
                                                                <option
                                                                    value="TRANSFERRED" {{ old('payment_method') == 'бэлнээр' ? 'selected' : '' }}>
                                                                    ШИЛЖҮҮЛЭГ
                                                                </option>
                                                                <option
                                                                    value="CASH" {{ old('payment_method') == 'дансаар' ? 'selected' : '' }}>
                                                                    БЭЛЭН_МӨНГӨ
                                                                </option>
                                                                <option
                                                                    value="ББСБ" {{ old('payment_method') == 'ББСБ' ? 'selected' : '' }}>
                                                                    ББСБ
                                                                </option>
                                                            </select>

                                                            <label for="description{{$item->id}}">Тайлбар: </label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend"><span
                                                                        class="input-group-text">#</span></div>
                                                                <input placeholder="тайлбар энд бичнэ үү"
                                                                       name="description" class="form-control"
                                                                       type="text"
                                                                       id="description{{$item->id}}"
                                                                       required/>
                                                            </div>

                                                            <!-- Payment Date -->
                                                            <label for="paid_date" class="col-6 col-form-label">Төлбөр төлсөн он сар өдөр</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend"><span class="input-group-text">&</span></div>
                                                                <input name="paid_date" class="form-control"
                                                                       type="datetime-local" value="{{ old('paid_date') }}"
                                                                       max="{{ date('Y-m-d H:i:s') }}"
                                                                       id="paid_date{{$item->id}}" />
                                                            </div>

                                                            <!-- Payment Image -->
                                                            <label>Гүйлгээний зураг</label>
                                                            <div class="custom-file">
                                                                <input name="payment_image" type="file" class="custom-file-input form-control" id="image{{$item->id}}"
                                                                       accept="image/png, image/jpeg"/>
                                                                <label class="custom-file-label" for="image{{$item->id}}">Гүйлгээний зураг хавсаргана уу</label>
                                                            </div>

                                                        </div>


                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Цуцлах
                                                            </button>
                                                            <button type="submit" class="btn btn-primary">Төлөх</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <!--end: Datatable-->
                    </div>
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>

@endsection

@section('vendor')
    <!--begin::Page Vendors(used by this page)-->
    <script src="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.5')}}"></script>
    <!--end::Page Vendors-->
@endsection

@section('script')
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{asset('admin/assets/js/pages/crud/datatables/data-sources/merchant.js?v=7.0.5')}}"></script>
    <!--end::Page Scripts-->

    <script>
        $(document).ready(function () {
            $('[data-toggle="modal"]').on('click', function () {
                var classValue = $(this).data('class');
                if (classValue) {
                    $('#payModal' + classValue).modal();
                }
            });
        });
    </script>

    <script>
        var KTSelect2 = function () {
            var demos = function () {
                $('#filterClass').select2({
                    placeholder: "Анги сонгоно уу"
                });
            }

            var modalDemos = function () {
                $('#filterClass_modal').on('shown.bs.modal', function () {
                    // basic
                    $('#filterClass_modal').select2({
                        placeholder: "Анги сонгоно уу"
                    });
                });
            }

            return {
                init: function () {
                    demos();
                    modalDemos();
                }
            };
        }();

        jQuery(document).ready(function () {
            KTSelect2.init();
        });
    </script>

    <script>
        $(document).ready(function () {
            // DataTable initialization

            if ($.fn.DataTable.isDataTable('#kt_datatable')) {
                $('#kt_datatable').DataTable().destroy();
            }

            var table = $('#kt_datatable').DataTable({
                responsive: true,
                pageLength: 10,
                responsive: true,
            });


            $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                var filterClass = $('#filterClass').val();
                var className = data[1];
                if (filterClass === "" || className === filterClass) {
                    return true;
                }
                return false;
            });


            $('#filterClass').change(function () {
                table.draw();
            });

            $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                var filterPayment = $('#filterPayment').val(); // Get the selected filter value
                var totalPaid = parseFloat(data[8].replace(/[^0-9.-]+/g, "")) || 0; // Parse total paid amount from column 2
                var totalFee = parseFloat(data[7].replace(/[^0-9.-]+/g, "")) || 0; // Parse total fee amount from column 3

                if (filterPayment === "") {
                    return true; // Show all rows if no filter is selected
                }

                if (filterPayment === "paid" && totalPaid === totalFee) {
                    return true; // Filter for fully paid
                }

                if (filterPayment === "partial" && totalPaid > 0 && totalPaid < totalFee) {
                    return true; // Filter for partially paid
                }

                if (filterPayment === "unpaid" && totalPaid === 0) {
                    return true; // Filter for unpaid
                }

                return false; // Otherwise, hide the row
            });

            $('#filterPayment').change(function () {
                table.draw();
            });
        });

    </script>

{{--    @if(session('message'))--}}
{{--        <script>--}}
{{--            window.addEventListener('load', function () {--}}
{{--                Swal.fire({--}}
{{--                    title: 'Success!',--}}
{{--                    text: '{{ session('message') }}',--}}
{{--                    icon: 'success',--}}
{{--                    confirmButtonText: 'OK'--}}
{{--                });--}}
{{--            });--}}
{{--        </script>--}}
{{--    @endif--}}

{{--    @if(session('error'))--}}
{{--        <script>--}}
{{--            window.addEventListener('load', function () {--}}
{{--                Swal.fire({--}}
{{--                    title: 'Error!',--}}
{{--                    text: '{{ session('error') }}',--}}
{{--                    icon: 'error',--}}
{{--                    confirmButtonText: 'OK'--}}
{{--                });--}}
{{--            });--}}
{{--        </script>--}}
{{--    @endif--}}
@endsection



