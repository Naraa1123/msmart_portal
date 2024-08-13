@extends('layouts.admin')

@section('style')
    <style>
        .btn.btn-info {
            color: #ffffff;
            background-color: #8950FC;
            border-color: #8950FC;
            width: 200px;
        }

        .btn.btn-success {
            color: #ffffff;
            background-color: #8950FC;
            border-color: #8950FC;
            width: 200px;
        }

        .btn.btn-warning{
            color: #ffffff;
            background-color: #8950FC;
            border-color: #8950FC;
            width: 200px;
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
                    @foreach($classPlans as $department => $classes)
                        @if(count($classes) > 0)
                            <div class="card-header">
                                <div class="card-title">
                                <span class="card-icon">
                                    <i class="flaticon2-favourite text-primary"></i>
                                </span>
                                    <h3 class="card-label">{{ $classes[0]->department->name }}</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($classes as $item)
                                        <div class="d-flex flex-wrap">
                                            <div class="class-code">
                                                <h3>
                                                    @php
                                                        $check='studying';
                                                        $classDateStr = substr($item->name, 2);
                                                        $year = substr($classDateStr, 0, 2);
                                                        $month = substr($classDateStr, 2, 2);
                                                        $day = substr($classDateStr, 4, 2);

                                                        $year = '20' . $year;

                                                        $classDate = new DateTime("$year-$month-$day");

                                                        $currentDate = new DateTime();
                                                    @endphp
                                                    @if($item->status == 1)
                                                        @php $check='graduated'; @endphp
                                                    @elseif($classDate>$currentDate)
                                                        @php $check='not started'; @endphp
                                                    @else
                                                        @php $check='studying'; @endphp
                                                    @endif

                                                    @if($check=='studying')
                                                        <a class="btn btn-info font-weight-bold font-size-h6 px-10 py-4 mr-2 square-btn"
                                                           href="{{ url('admin/subject-grade/show/' . encrypt($item->id)) }}">{{ $item->name }}</a>
                                                    @elseif($check=='graduated')
                                                        <a class="btn btn-success font-weight-bold font-size-h6 px-10 py-4 mr-2 square-btn"
                                                           href="{{ url('admin/subject-grade/show/' . encrypt($item->id)) }}">{{ $item->name }}</a>
                                                    @else
                                                        <a class="btn btn-warning font-weight-bold font-size-h6 px-10 py-4 mr-2 square-btn"
                                                           href="{{ url('admin/subject-grade/show/' . encrypt($item->id)) }}">{{ $item->name }}</a>
                                                    @endif


                                                </h3>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>

@endsection
