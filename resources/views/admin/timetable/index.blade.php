@extends('layouts.admin')

@section('style')
    <style>
        .custom-card-spacing {
            margin-bottom: 30px;
        }
        .card-title{
            margin:0!important;
        }

        h3{
            margin:0!important;
        }

        .card-label{
            padding:8px!important;
        }

        @media(max-width: 1550px)
        {
            .card-title{
                margin-top:10px!important;
                width: 100%;
            }
            .card-label{
                width: 100%!important;
                margin:0!important;
            }
            .card-toolbar{
                width: 100%!important;
            }
            .timeBtn{
                width: 100%;
            }

        }
    </style>
@endsection

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <!-- Search Section -->
                <div class="row my-4">
                    <div class="col-md-12">
                        <input type="text" id="searchInput" class="form-control" placeholder="Search by class name...">
                    </div>
                </div>

                @php
                    $currentDepartment = null;
                @endphp

                <div id="classesContainer">
                    @foreach ($classes as $class)
                        @if ($currentDepartment != $class->department->name)
                            @if ($currentDepartment != null)
                </div>
            </div>
        </div>
        @endif

        @php
            $currentDepartment = $class->department->name;
        @endphp

        <div class="card card-custom my-3 department-card">
            <div class="card-header text-white">
                <div class="card-title">
                                        <span class="card-icon">
                                            <i class="flaticon2-favourite text-primary"></i>
                                        </span>
                    <h3 class="card-label">{{ $class->department->name }}</h3>
                </div>
            </div>
            <div class="card-body bg-light-dark">
                <div class="row">
                    @endif

                    <div class="col-lg-3 col-md-4 col-sm-6 custom-card-spacing mb-3 class-card"
                         data-class-name="{{ strtolower($class->name) }}">
                        <div class="card card-custom card-stretch h-100">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label btn btn-light-success font-weight-bold">{{ $class->name }}</h3>
                                </div>
                                <div class="card-toolbar">
                                    <a href="{{ url('admin/timetable/'.encrypt($class->id)) }}"
                                       class="btn btn-primary font-weight-bolder timeBtn">
                                        <i class="la la-edit"></i> Хуваарь
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                @foreach ($class->classTimetables as $timetable)
                                    <div class="d-flex align-items-center mb-10">
                                        <div class="symbol symbol-40 symbol-light-primary mr-5">
                                                <span class="symbol-label">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                         height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none"
                                                           fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <path
                                                                d="M12,21 C7.02943725,21 3,16.9705627 3,12 C3,7.02943725 7.02943725,3 12,3 C16.9705627,3 21,7.02943725 21,12 C21,16.9705627 16.9705627,21 12,21 Z M12,18 C15.3137085,18 18,15.3137085 18,12 C18,8.6862915 15.3137085,6 12,6 C8.6862915,6 6,8.6862915 6,12 C6,15.3137085 8.6862915,18 12,18 Z"
                                                                fill="#000000"/>
                                                            <path
                                                                d="M12,16 C14.209139,16 16,14.209139 16,12 C16,9.790861 14.209139,8 12,8 C9.790861,8 8,9.790861 8,12 C8,14.209139 9.790861,16 12,16 Z"
                                                                fill="#000000" opacity="0.3"/>
                                                        </g>
                                                    </svg>
                                                </span>
                                        </div>
                                        <div class="d-flex flex-column font-weight-bold">
                                            <a class="text-dark text-hover-primary mb-1 font-size-lg">{{ $timetable->week->name }}</a>
                                            <span
                                                class="text-muted">{{ $timetable->start_time }}~{{ $timetable->end_time }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    @endforeach

                </div>
            </div>
        </div>
    </div>


@endsection


@section('script')
    @if(session('message'))
        <script>
            window.addEventListener('load', function () {
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
            window.addEventListener('load', function () {
                Swal.fire({
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    <script>
        document.getElementById('searchInput').addEventListener('keyup', function () {
            let filter = this.value.toLowerCase();
            let classCards = document.querySelectorAll('.class-card');
            let departmentCards = document.querySelectorAll('.department-card');

            classCards.forEach(card => {
                if (card.getAttribute('data-class-name').includes(filter)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });

            departmentCards.forEach(departmentCard => {
                let visibleClasses = departmentCard.querySelectorAll('.class-card:not([style*="display: none"])');
                if (visibleClasses.length > 0) {
                    departmentCard.style.display = '';
                } else {
                    departmentCard.style.display = 'none';
                }
            });
        });
    </script>
@endsection
