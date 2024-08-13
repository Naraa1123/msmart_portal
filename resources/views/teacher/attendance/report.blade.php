@extends('layouts.teacher')

@section('style')
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.5')}}" rel="stylesheet"
          type="text/css"/>
    <!--end::Page Vendors Styles-->

    <style>
        .scrollable-table-wrapper {
            overflow-x: auto;
            cursor: grab;
        }
    </style>

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
                            <h3 class="card-label">
                                Ирцийн Мэдээлэл
                            </h3>
                        </div>
                    </div>


                    <div class="card-body">
                        <form action="{{ route('teacher.attendance.search') }}" method="GET">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <label for="class_id">Анги сонгоно уу</label>
                                    <select id="class_id" name="class_id" class="form-control" required>
                                        @foreach($classes as $class)
                                            <option
                                                value="{{ $class->id }}" {{ $request->class_id == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 form-group">
                                    <label for="month">Сар сонгоно уу</label>
                                    <select name="month" class="form-control" id="month">
                                        @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $index => $month)
                                            <option
                                                value="{{ $index + 1 }}" {{ $request->month == $index + 1 ? 'selected' : '' }}>{{ $month }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 form-group">
                                    <label for="year">Жил сонгоно уу</label>
                                    <select name="year" class="form-control" id="year">
                                        @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                                            <option
                                                value="{{ $i }}" {{ $request->year == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-3 form-group d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">Search</button>
                                </div>
                            </div>
                        </form>

                        <!--begin: Datatable-->
                        <div class="scrollable-table-wrapper">
                            <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                                   style="margin-top: 13px !important">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Сурагчид</th>
                                    @foreach ($dates as $date)
                                        <th>{{ \Carbon\Carbon::parse($date)->format('m/d') }}</th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($students as $key=>$student)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $student->userDetails->lastname }} {{ $student->userDetails->firstname }} </td>
                                        @foreach ($dates as $date)
                                            @php
                                                $attendance = $student->attendances->firstWhere('attendance_date', $date);
                                            @endphp
                                            <td>
                                                @if ($attendance)
                                                    @switch($attendance->attendance_type)
                                                        @case(1)
                                                            <span class="svg-icon svg-icon-danger svg-icon-2x">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                     width="24px" height="24px" viewBox="0 0 24 24"
                                                                     version="1.1">
                                                                    <g stroke="none" stroke-width="1" fill="none"
                                                                       fill-rule="evenodd">
                                                                        <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)"
                                                                           fill="#000000">
                                                                            <rect x="0" y="7" width="16" height="2"
                                                                                  rx="1"/>
                                                                            <rect opacity="0.3"
                                                                                  transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000) "
                                                                                  x="0" y="7" width="16" height="2"
                                                                                  rx="1"/>
                                                                        </g>
                                                                    </g>
                                                                </svg>
                                                            </span>
                                                            @break
                                                        @case(2)
                                                            <span class="svg-icon svg-icon-success svg-icon-2x">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                     width="24px" height="24px" viewBox="0 0 24 24"
                                                                     version="1.1">
                                                                    <g stroke="none" stroke-width="1" fill="none"
                                                                       fill-rule="evenodd">
                                                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                                                        <path
                                                                            d="M6.26193932,17.6476484 C5.90425297,18.0684559 5.27315905,18.1196257 4.85235158,17.7619393 C4.43154411,17.404253 4.38037434,16.773159 4.73806068,16.3523516 L13.2380607,6.35235158 C13.6013618,5.92493855 14.2451015,5.87991302 14.6643638,6.25259068 L19.1643638,10.2525907 C19.5771466,10.6195087 19.6143273,11.2515811 19.2474093,11.6643638 C18.8804913,12.0771466 18.2484189,12.1143273 17.8356362,11.7474093 L14.0997854,8.42665306 L6.26193932,17.6476484 Z"
                                                                            fill="#000000" fill-rule="nonzero"
                                                                            transform="translate(11.999995, 12.000002) rotate(-180.000000) translate(-11.999995, -12.000002) "/>
                                                                    </g>
                                                                </svg>
                                                            </span>
                                                            @break
                                                        @case(3)
                                                            <span class="svg-icon svg-icon-warning svg-icon-2x">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                     width="24px" height="24px" viewBox="0 0 24 24"
                                                                     version="1.1">
                                                                    <g stroke="none" stroke-width="1" fill="none"
                                                                       fill-rule="evenodd">
                                                                        <rect x="0" y="0" width="24" height="24"/>
                                                                        <path
                                                                            d="M10.9630156,7.5 L11.0475062,7.5 C11.3043819,7.5 11.5194647,7.69464724 11.5450248,7.95024814 L12,12.5 L15.2480695,14.3560397 C15.403857,14.4450611 15.5,14.6107328 15.5,14.7901613 L15.5,15 C15.5,15.2109164 15.3290185,15.3818979 15.1181021,15.3818979 C15.0841582,15.3818979 15.0503659,15.3773725 15.0176181,15.3684413 L10.3986612,14.1087258 C10.1672824,14.0456225 10.0132986,13.8271186 10.0316926,13.5879956 L10.4644883,7.96165175 C10.4845267,7.70115317 10.7017474,7.5 10.9630156,7.5 Z"
                                                                            fill="#000000"/>
                                                                        <path
                                                                            d="M7.38979581,2.8349582 C8.65216735,2.29743306 10.0413491,2 11.5,2 C17.2989899,2 22,6.70101013 22,12.5 C22,18.2989899 17.2989899,23 11.5,23 C5.70101013,23 1,18.2989899 1,12.5 C1,11.5151324 1.13559454,10.5619345 1.38913364,9.65805651 L3.31481075,10.1982117 C3.10672013,10.940064 3,11.7119264 3,12.5 C3,17.1944204 6.80557963,21 11.5,21 C16.1944204,21 20,17.1944204 20,12.5 C20,7.80557963 16.1944204,4 11.5,4 C10.54876,4 9.62236069,4.15592757 8.74872191,4.45446326 L9.93948308,5.87355717 C10.0088058,5.95617272 10.0495583,6.05898805 10.05566,6.16666224 C10.0712834,6.4423623 9.86044965,6.67852665 9.5847496,6.69415008 L4.71777931,6.96995273 C4.66931162,6.97269931 4.62070229,6.96837279 4.57348157,6.95710938 C4.30487471,6.89303938 4.13906482,6.62335149 4.20313482,6.35474463 L5.33163823,1.62361064 C5.35654118,1.51920756 5.41437908,1.4255891 5.49660017,1.35659741 C5.7081375,1.17909652 6.0235153,1.2066885 6.2010162,1.41822583 L7.38979581,2.8349582 Z"
                                                                            fill="#000000" opacity="0.3"/>
                                                                    </g>
                                                                </svg>
                                                            </span>
                                                            @break
                                                        @case(4)
                                                            <span class="svg-icon svg-icon-info svg-icon-2x">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                     width="24px" height="24px" viewBox="0 0 24 24"
                                                                     version="1.1">
                                                                    <g stroke="none" stroke-width="1" fill="none"
                                                                       fill-rule="evenodd">
                                                                        <rect x="0" y="0" width="24" height="24"/>
                                                                        <path
                                                                            d="M11.2928932,5.63603897 L18.363961,12.7071068 L12,19.0710678 L4.92893219,12 L11.2928932,5.63603897 Z M8.46446609,11.2928932 C8.0739418,11.6834175 8.0739418,12.3165825 8.46446609,12.7071068 C8.85499039,13.0976311 9.48815536,13.0976311 9.87867966,12.7071068 C10.2692039,12.3165825 10.2692039,11.6834175 9.87867966,11.2928932 C9.48815536,10.9023689 8.85499039,10.9023689 8.46446609,11.2928932 Z M11.2928932,8.46446609 C10.9023689,8.85499039 10.9023689,9.48815536 11.2928932,9.87867966 C11.6834175,10.2692039 12.3165825,10.2692039 12.7071068,9.87867966 C13.0976311,9.48815536 13.0976311,8.85499039 12.7071068,8.46446609 C12.3165825,8.0739418 11.6834175,8.0739418 11.2928932,8.46446609 Z M11.2928932,14.1213203 C10.9023689,14.5118446 10.9023689,15.1450096 11.2928932,15.5355339 C11.6834175,15.9260582 12.3165825,15.9260582 12.7071068,15.5355339 C13.0976311,15.1450096 13.0976311,14.5118446 12.7071068,14.1213203 C12.3165825,13.7307961 11.6834175,13.7307961 11.2928932,14.1213203 Z M14.1213203,11.2928932 C13.7307961,11.6834175 13.7307961,12.3165825 14.1213203,12.7071068 C14.5118446,13.0976311 15.1450096,13.0976311 15.5355339,12.7071068 C15.9260582,12.3165825 15.9260582,11.6834175 15.5355339,11.2928932 C15.1450096,10.9023689 14.5118446,10.9023689 14.1213203,11.2928932 Z"
                                                                            fill="#000000"/>
                                                                        <path
                                                                            d="M10.5150629,20.4145579 C8.57369375,21.7007639 5.93228695,21.4886361 4.22182541,19.7781746 C2.51136387,18.0677131 2.2992361,15.4263063 3.58544211,13.4849371 L10.5150629,20.4145579 Z"
                                                                            fill="#000000" opacity="0.3"/>
                                                                        <path
                                                                            d="M12.7778303,4.29254889 C14.7191995,3.00634288 17.3606063,3.21847065 19.0710678,4.92893219 C20.7815294,6.63939373 20.9936571,9.28080053 19.7074511,11.2221697 L12.7778303,4.29254889 Z"
                                                                            fill="#000000" opacity="0.3"/>
                                                                    </g>
                                                                </svg>
                                                            </span>
                                                            @break
                                                        @case(5)
                                                            <span class="svg-icon svg-icon-primary svg-icon-2x">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                     width="24px" height="24px" viewBox="0 0 24 24"
                                                                     version="1.1">
                                                                    <g stroke="none" stroke-width="1" fill="none"
                                                                       fill-rule="evenodd">
                                                                        <rect x="0" y="0" width="24" height="24"/>
                                                                        <path
                                                                            d="M14.486222,18 L12.7974954,21.0565532 C12.530414,21.5399639 11.9220198,21.7153335 11.4386091,21.4482521 C11.2977127,21.3704077 11.1776907,21.2597005 11.0887419,21.1255379 L9.01653358,18 L5,18 C3.34314575,18 2,16.6568542 2,15 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,16.6568542 20.6568542,18 19,18 L14.486222,18 Z"
                                                                            fill="#000000" opacity="0.3"/>
                                                                        <path
                                                                            d="M6,7 L15,7 C15.5522847,7 16,7.44771525 16,8 C16,8.55228475 15.5522847,9 15,9 L6,9 C5.44771525,9 5,8.55228475 5,8 C5,7.44771525 5.44771525,7 6,7 Z M6,11 L11,11 C11.5522847,11 12,11.4477153 12,12 C12,12.5522847 11.5522847,13 11,13 L6,13 C5.44771525,13 5,12.5522847 5,12 C5,11.4477153 5.44771525,11 6,11 Z"
                                                                            fill="#000000" opacity="0.3"/>
                                                                    </g>
                                                                </svg>
                                                            </span>
                                                            @break
                                                        @case(6)
                                                            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Devices\Router2.svg--><svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    width="24px" height="24px" viewBox="0 0 24 24"
                                                                    version="1.1">
                                                                    <g stroke="none" stroke-width="1" fill="none"
                                                                       fill-rule="evenodd">
                                                                        <rect x="0" y="0" width="24" height="24"/>
                                                                        <rect fill="#000000" x="3" y="13" width="18"
                                                                              height="7" rx="2"/>
                                                                        <path
                                                                            d="M17.4029496,9.54910207 L15.8599014,10.8215022 C14.9149052,9.67549895 13.5137472,9 12,9 C10.4912085,9 9.09418404,9.67104182 8.14910121,10.8106159 L6.60963188,9.53388797 C7.93073905,7.94090645 9.88958759,7 12,7 C14.1173586,7 16.0819686,7.94713944 17.4029496,9.54910207 Z M20.4681628,6.9788888 L18.929169,8.25618985 C17.2286725,6.20729644 14.7140097,5 12,5 C9.28974232,5 6.77820732,6.20393339 5.07766256,8.24796852 L3.54017812,6.96885102 C5.61676443,4.47281829 8.68922234,3 12,3 C15.3153667,3 18.3916375,4.47692603 20.4681628,6.9788888 Z"
                                                                            fill="#000000" fill-rule="nonzero"
                                                                            opacity="0.3"/>
                                                                    </g>
                                                                </svg><!--end::Svg Icon-->
                                                            </span>
                                                            @break
                                                    @endswitch
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!--end: Datatable-->
                    </div>

                    <div class="card-footer">
                        <div class="card-body">
                            <div class="scrollable-table-wrapper">
                                <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                                       style="margin-top: 13px !important">

                                    <tbody>
                                        <tr>
                                            <td>
                                                тас:   <span class="svg-icon svg-icon-danger svg-icon-2x">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                         width="24px" height="24px" viewBox="0 0 24 24"
                                                                         version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none"
                                                                           fill-rule="evenodd">
                                                                            <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)"
                                                                               fill="#000000">
                                                                                <rect x="0" y="7" width="16" height="2"
                                                                                      rx="1"/>
                                                                                <rect opacity="0.3"
                                                                                      transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000) "
                                                                                      x="0" y="7" width="16" height="2"
                                                                                      rx="1"/>
                                                                            </g>
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                            </td>

                                            <td>
                                                ирсэн:   <span class="svg-icon svg-icon-success svg-icon-2x">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                         width="24px" height="24px" viewBox="0 0 24 24"
                                                                         version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none"
                                                                           fill-rule="evenodd">
                                                                            <polygon points="0 0 24 0 24 24 0 24"/>
                                                                            <path
                                                                                d="M6.26193932,17.6476484 C5.90425297,18.0684559 5.27315905,18.1196257 4.85235158,17.7619393 C4.43154411,17.404253 4.38037434,16.773159 4.73806068,16.3523516 L13.2380607,6.35235158 C13.6013618,5.92493855 14.2451015,5.87991302 14.6643638,6.25259068 L19.1643638,10.2525907 C19.5771466,10.6195087 19.6143273,11.2515811 19.2474093,11.6643638 C18.8804913,12.0771466 18.2484189,12.1143273 17.8356362,11.7474093 L14.0997854,8.42665306 L6.26193932,17.6476484 Z"
                                                                                fill="#000000" fill-rule="nonzero"
                                                                                transform="translate(11.999995, 12.000002) rotate(-180.000000) translate(-11.999995, -12.000002) "/>
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                            </td>

                                            <td>
                                                хоцорсон:   <span class="svg-icon svg-icon-warning svg-icon-2x">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                         width="24px" height="24px" viewBox="0 0 24 24"
                                                                         version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none"
                                                                           fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24" height="24"/>
                                                                            <path
                                                                                d="M10.9630156,7.5 L11.0475062,7.5 C11.3043819,7.5 11.5194647,7.69464724 11.5450248,7.95024814 L12,12.5 L15.2480695,14.3560397 C15.403857,14.4450611 15.5,14.6107328 15.5,14.7901613 L15.5,15 C15.5,15.2109164 15.3290185,15.3818979 15.1181021,15.3818979 C15.0841582,15.3818979 15.0503659,15.3773725 15.0176181,15.3684413 L10.3986612,14.1087258 C10.1672824,14.0456225 10.0132986,13.8271186 10.0316926,13.5879956 L10.4644883,7.96165175 C10.4845267,7.70115317 10.7017474,7.5 10.9630156,7.5 Z"
                                                                                fill="#000000"/>
                                                                            <path
                                                                                d="M7.38979581,2.8349582 C8.65216735,2.29743306 10.0413491,2 11.5,2 C17.2989899,2 22,6.70101013 22,12.5 C22,18.2989899 17.2989899,23 11.5,23 C5.70101013,23 1,18.2989899 1,12.5 C1,11.5151324 1.13559454,10.5619345 1.38913364,9.65805651 L3.31481075,10.1982117 C3.10672013,10.940064 3,11.7119264 3,12.5 C3,17.1944204 6.80557963,21 11.5,21 C16.1944204,21 20,17.1944204 20,12.5 C20,7.80557963 16.1944204,4 11.5,4 C10.54876,4 9.62236069,4.15592757 8.74872191,4.45446326 L9.93948308,5.87355717 C10.0088058,5.95617272 10.0495583,6.05898805 10.05566,6.16666224 C10.0712834,6.4423623 9.86044965,6.67852665 9.5847496,6.69415008 L4.71777931,6.96995273 C4.66931162,6.97269931 4.62070229,6.96837279 4.57348157,6.95710938 C4.30487471,6.89303938 4.13906482,6.62335149 4.20313482,6.35474463 L5.33163823,1.62361064 C5.35654118,1.51920756 5.41437908,1.4255891 5.49660017,1.35659741 C5.7081375,1.17909652 6.0235153,1.2066885 6.2010162,1.41822583 L7.38979581,2.8349582 Z"
                                                                                fill="#000000" opacity="0.3"/>
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                            </td>

                                            <td>
                                                өвчтэй:   <span class="svg-icon svg-icon-info svg-icon-2x">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                         width="24px" height="24px" viewBox="0 0 24 24"
                                                                         version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none"
                                                                           fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24" height="24"/>
                                                                            <path
                                                                                d="M11.2928932,5.63603897 L18.363961,12.7071068 L12,19.0710678 L4.92893219,12 L11.2928932,5.63603897 Z M8.46446609,11.2928932 C8.0739418,11.6834175 8.0739418,12.3165825 8.46446609,12.7071068 C8.85499039,13.0976311 9.48815536,13.0976311 9.87867966,12.7071068 C10.2692039,12.3165825 10.2692039,11.6834175 9.87867966,11.2928932 C9.48815536,10.9023689 8.85499039,10.9023689 8.46446609,11.2928932 Z M11.2928932,8.46446609 C10.9023689,8.85499039 10.9023689,9.48815536 11.2928932,9.87867966 C11.6834175,10.2692039 12.3165825,10.2692039 12.7071068,9.87867966 C13.0976311,9.48815536 13.0976311,8.85499039 12.7071068,8.46446609 C12.3165825,8.0739418 11.6834175,8.0739418 11.2928932,8.46446609 Z M11.2928932,14.1213203 C10.9023689,14.5118446 10.9023689,15.1450096 11.2928932,15.5355339 C11.6834175,15.9260582 12.3165825,15.9260582 12.7071068,15.5355339 C13.0976311,15.1450096 13.0976311,14.5118446 12.7071068,14.1213203 C12.3165825,13.7307961 11.6834175,13.7307961 11.2928932,14.1213203 Z M14.1213203,11.2928932 C13.7307961,11.6834175 13.7307961,12.3165825 14.1213203,12.7071068 C14.5118446,13.0976311 15.1450096,13.0976311 15.5355339,12.7071068 C15.9260582,12.3165825 15.9260582,11.6834175 15.5355339,11.2928932 C15.1450096,10.9023689 14.5118446,10.9023689 14.1213203,11.2928932 Z"
                                                                                fill="#000000"/>
                                                                            <path
                                                                                d="M10.5150629,20.4145579 C8.57369375,21.7007639 5.93228695,21.4886361 4.22182541,19.7781746 C2.51136387,18.0677131 2.2992361,15.4263063 3.58544211,13.4849371 L10.5150629,20.4145579 Z"
                                                                                fill="#000000" opacity="0.3"/>
                                                                            <path
                                                                                d="M12.7778303,4.29254889 C14.7191995,3.00634288 17.3606063,3.21847065 19.0710678,4.92893219 C20.7815294,6.63939373 20.9936571,9.28080053 19.7074511,11.2221697 L12.7778303,4.29254889 Z"
                                                                                fill="#000000" opacity="0.3"/>
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                            </td>

                                            <td>
                                                чөлөөтэй:   <span class="svg-icon svg-icon-primary svg-icon-2x">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                         width="24px" height="24px" viewBox="0 0 24 24"
                                                                         version="1.1">
                                                                        <g stroke="none" stroke-width="1" fill="none"
                                                                           fill-rule="evenodd">
                                                                            <rect x="0" y="0" width="24" height="24"/>
                                                                            <path
                                                                                d="M14.486222,18 L12.7974954,21.0565532 C12.530414,21.5399639 11.9220198,21.7153335 11.4386091,21.4482521 C11.2977127,21.3704077 11.1776907,21.2597005 11.0887419,21.1255379 L9.01653358,18 L5,18 C3.34314575,18 2,16.6568542 2,15 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,16.6568542 20.6568542,18 19,18 L14.486222,18 Z"
                                                                                fill="#000000" opacity="0.3"/>
                                                                            <path
                                                                                d="M6,7 L15,7 C15.5522847,7 16,7.44771525 16,8 C16,8.55228475 15.5522847,9 15,9 L6,9 C5.44771525,9 5,8.55228475 5,8 C5,7.44771525 5.44771525,7 6,7 Z M6,11 L11,11 C11.5522847,11 12,11.4477153 12,12 C12,12.5522847 11.5522847,13 11,13 L6,13 C5.44771525,13 5,12.5522847 5,12 C5,11.4477153 5.44771525,11 6,11 Z"
                                                                                fill="#000000" opacity="0.3"/>
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
        document.addEventListener('DOMContentLoaded', function () {
            const slider = document.querySelector('.scrollable-table-wrapper');
            let isDown = false;
            let startX;
            let scrollLeft;

            slider.addEventListener('mousedown', (e) => {
                isDown = true;
                slider.style.cursor = 'grabbing';
                startX = e.pageX - slider.offsetLeft;
                scrollLeft = slider.scrollLeft;
            });
            slider.addEventListener('mouseleave', () => {
                isDown = false;
                slider.style.cursor = 'grab';
            });
            slider.addEventListener('mouseup', () => {
                isDown = false;
                slider.style.cursor = 'grab';
            });
            slider.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - slider.offsetLeft;
                const walk = (x - startX) * 3;
                slider.scrollLeft = scrollLeft - walk;
            });
        });
    </script>
@endsection






