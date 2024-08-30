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
                            <h3 class="card-label">USER INFORMATION</h3>
                        </div>

                        <div class="card-toolbar">
                            <!--begin::Button-->
                            <button class="btn btn-primary font-weight-bolder" onclick="goBack()">
                                <i class="la la-arrow-left"></i>BACK
                            </button>
                            <!--end::Button-->
                        </div>

                    </div>

                    <div class="card-body">

                        @if($userDetail->reason)
                            <h1>{{$userDetail->reason}}</h1>
                        @endif

                        <!--begin: Datatable-->
                        <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                               style="margin-top: 13px !important">
                            <tbody>
                            <tr height="35">
                                <td style="background: #ccc" width="15%">Тэнхим</td>
                                <td width="20%">{{ optional($user->class)->department->name  ?? 'No Available' }}</td>
                                {{-- <td style="background: #ccc" width="15%">Элссэн Анги</td> --}}
                                {{-- <td width="20%">{{ optional($user->class)->name  ?? 'No Available' }}</td> --}}

                                {{-- <td colspan="2" rowspan="5" align="center">
                                    <div class="student-img">
                                        <img src="{{ asset("$userDetail->image") }}" alt="No image">
                                    </div>
                                </td> --}}
                                <td style="background: #ccc">Оюутны код</td>
                                <td>{{$user->school_id}}</td>
                            </tr>


                            <tr height="35">
                                <td style="background: #ccc">Овог</td>
                                <td>{{ $userDetail->lastname }}</td>
                                <td style="background: #ccc">Нэр</td>
                                <td> {{$userDetail->firstname}}</td>

                            </tr>
                            <tr height="35">
                                <td style="background: #ccc">Регистерийн дугаар</td>
                                <td> {{$userDetail->registration_number}}</td>
                                <td style="background: #ccc">Хүйс</td>
                                <td>{{ $userDetail->gender }}</td>
                            </tr>


                            <tr height="35">
                                <td style="background: #ccc">Утасны дугаар 1</td>
                                <td>{{ $userDetail->phone_number_1 }}</td>
                                <td style="background: #ccc"> Email</td>
                                <td>{{$user->email}}</td>
                            </tr>

                            <tr height="35">
                                <td style="background: #ccc">Утасны дугаар 2</td>
                                <td>{{ $userDetail->phone_number_2  }}</td>
                                <td style="background: #ccc">Асран хамгаалагчын нэр</td>
                                <td>{{$userDetail->guardian_name}}</td>
                            </tr>

                            <tr height="35">

                                <td style="background: #ccc">Асран хамгаалагчын дугаар</td>
                                <td> {{$userDetail->guardian_phone_number}}</td>
                                <td style="background: #ccc">Элссэн он сар өдөр</td>
                                <td>{{ $userDetail->admission_year }}</td>

                            </tr>
                            <tr height="35">
                                <td style="background: #ccc">Төрсөн он сар өдөр</td>
                                <td>{{ $userDetail->date_of_birth  }}</td>
                                <td style="background: #ccc">Төлөв</td>
                                <td>{{$userDetail->status}}</td>
                                {{-- <td style="background: #ccc"> Хаяг</td>
                                <td colspan="4"></td> --}}
                            </tr>
                            <tr height="35">
                                <td style="background: #ccc">Диплом авсан эсэх</td>
                                <td>@if($userDetail->has_diploma=='received')
                                        Диплом авсан
                                    @else
                                        Диплом аваагүй
                                    @endif
                                </td>
                                <td style="background: #ccc">Дипломын сэдэв</td>
                                <td>{{$userDetail->diploma_name}}</td>
                                {{-- <td style="background: #ccc"> Хаяг</td>
                                <td colspan="4"></td> --}}
                            </tr>
                            <tr height="35">
                                <td style="background: #ccc">Диплом авсан огноо</td>
                                <td>
                                    {{$userDetail->diploma_received_date}}
                                </td>

                            </tr>
                            </tbody>
                        </table>
                        <!--end: Datatable-->
                    </div>

                    <hr>
                    @if($user->role_as == 3)
                        <div class="card-body">
                            <h3>ТӨЛБӨР</h3>
                            <table class="table table-bordered table-hover table-checkable" id="kt_datatable">
                                <tbody>
                                <tr height="35">
                                    <td style="background: #ccc" width="15%">Үндсэн дүн</td>
                                    <td width="20%">@mongolian_currency($user->payment->total_amount)₮</td>

                                    <td style="background: #ccc">Хямдрал</td>
                                    <td>{{$user->payment->discount_percentage}}%</td>
                                </tr>

                                <tr height="35">
                                    <td style="background: #ccc" width="15%">Төлөх дүн</td>
                                    <td width="20%">@mongolian_currency($user->payment->due_amount)₮</td>

                                    <td style="background: #ccc">Төлбөрийн төлөв</td>
                                    <td>
                                        @if($user->payment->status=='completed')
                                            бүрэн төлсөн
                                        @elseif($user->payment->status=='remaining_pays')
                                            төлбөрийн үлдэгдэлтэй
                                        @endif
                                    </td>
                                </tr>

                                <tr height="35">
                                    <td style="background: #ccc" width="15%">Нийт төлсөн дүн</td>

                                    <td width="20%">
                                        @php
                                            $totalPaid = $user->payment->fees->sum('paid_amount');
                                        @endphp
                                        @mongolian_currency($totalPaid)₮
                                    </td>

                                    <td style="background: #ccc">Үлдэгдэл төлбөр</td>
                                    <td>
                                        @php
                                            $remainingAmount = $user->payment->due_amount - $totalPaid;
                                        @endphp
                                        @mongolian_currency($remainingAmount)₮
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <hr>
                    @if($user->role_as == 3)
                        <div class="card-body">
                            <h3>Ирцийн мэдээлэл</h3>
                            <!--begin: Datatable-->
                            <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                                   style="margin-top: 13px !important">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Тэнхим</th>
                                    <th>Анги</th>
                                    <th>Өдөр</th>
                                    <th>Ирцийн төлөв</th>
                                    <th>Тэмдэглэл</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($student_attendance as $key=>$item)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{$item->class->name }}</td>
                                        <td>{{$item->class->department->name}}</td>
                                        <td>{{$item->attendance_date }}</td>
                                        <td class="datatable-cell-sorted datatable-cell" data-field="Status"
                                            aria-label="1">
                                            @if($item->attendance_type == '1')
                                                <span style="width: 112px;">
                                                <span
                                                    class="label font-weight-bold label-lg  label-light-danger label-inline">тас</span>
                                            </span>
                                            @elseif($item->attendance_type == '2')
                                                <span style="width: 110px;">
                                                <span
                                                    class="label font-weight-bold label-lg  label-light-success label-inline">ирсэн</span>
                                            </span>
                                            @elseif($item->attendance_type == '3')
                                                <span style="width: 110px;">
                                                <span
                                                    class="label font-weight-bold label-lg  label-light-warning label-inline">хоцорсон</span>
                                            </span>
                                            @elseif($item->attendance_type == '4')
                                                <span style="width: 110px;">
                                                <span
                                                    class="label font-weight-bold label-lg  label-light-info label-inline">өвчтэй</span>
                                            </span>
                                            @elseif($item->attendance_type == '5')
                                                <span style="width: 110px;">
                                                <span
                                                    class="label font-weight-bold label-lg  label-light-primary label-inline">чөлөөтэй</span>
                                            </span>
                                            @elseif($item->attendance_type == '6')
                                                <span style="width: 110px;">
                                                <span
                                                    class="label font-weight-bold label-lg  label-light-primary label-inline">BB</span>
                                            </span>
                                            @else
                                                <span style="width: 110px;">
                                                <span
                                                    class="label font-weight-bold label-lg  label-light-primary label-inline">Хөгжүүлэгчид хэл</span>
                                            </span>
                                            @endif
                                        </td>

                                        <td>{{ $item->comment ?? '' }}</td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <!--end: Datatable-->
                        </div>
                    @endif
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
@endsection


@section('script')
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
@endsection
