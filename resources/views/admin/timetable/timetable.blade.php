@extends('layouts.admin')

@section('content')

    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">
                        Timetable CLASS NAME: {{$class->name}}
                    </h3>
                </div>

                <form class="form" action="{{ route('admin.timetable.store', ['classId' => $class->id]) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <input type="hidden" name="class_id" value="{{ $class->id }}">

                        <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                               style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>Week</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Room number</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($weeks as $week)
                                <tr>
                                    <th>{{$week->name}}</th>
                                    <td>
                                        @if (!$week->skipped)
                                            <input type="time"
                                                   value="{{ $timetables[$week->id]->start_time ?? '' }}"
                                                   name="start_time[{{ $week->id }}]"
                                                   min="09:00"
                                                   max="22:00"
                                                   class="form-control">
                                        @endif
                                    </td>
                                    <td>
                                        @if (!$week->skipped)
                                            <input type="time"
                                                   value="{{ $timetables[$week->id]->end_time ?? '' }}"
                                                   name="end_time[{{ $week->id }}]"
                                                   min="09:00"
                                                   max="22:00"
                                                   class="form-control">
                                        @endif
                                    </td>
                                    <td>
                                        @if (!$week->skipped)
                                            <input type="text"
                                                   value="{{ $timetables[$week->id]->room_number ?? '' }}"
                                                   name="room_number[{{ $week->id }}]"
                                                   class="form-control">
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.timetable.destroy', ['class_id' => $class->id, 'week_id' => $week->id]) }}"
                                           onclick="return confirm('Are you sure to Delete?')"
                                           class="btn btn-sm btn-clean btn-icon" title="delete">
                                            <i class="la la-trash"></i>
                                        </a>
                                    </td>

                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <!--end: Datatable-->
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

    @if(session('message'))
        <script>
            window.addEventListener('load', function() {
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('message') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            window.addEventListener('load', function() {
                Swal.fire({
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif
@endsection
