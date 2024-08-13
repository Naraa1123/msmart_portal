@extends('layouts.teacher')

@section('style')
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.5')}}" rel="stylesheet" type="text/css"/>
    <!--end::Page Vendors Styles-->
@endsection

@section('content')
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon2-favourite text-primary"></i>
                        </span>
                        <h3 class="card-label">Хариуцсан ангиуд</h3>
                    </div>

                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse ($classes as $class)
                            <div class="col-md-2">
                                <div class="class-code">
                                    <h3>
                                        <form method="GET" action="{{ route('teacher.all-class-plan',['id'=>$class->id,'class_name'=>$class->name]) }}">
                                            <button type="submit" class="btn btn-info font-weight-bold font-size-h6 px-10 py-4 mr-2 square-btn">
                                                {{ $class->name }}
                                            </button>
                                        </form>

                                    </h3>
                                </div>
                            </div>
                        @empty
                            <p>No Class Available</p>
                        @endforelse
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{asset('admin/assets/js/pages/crud/datatables/data-sources/merchant.js?v=7.0.5')}}"></script>
    <!--end::Page Scripts-->
@endsection
