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
                            <h3 class="card-label">Reported students</h3>
                        </div>
                    </div>

                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                               style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Report</th>
                                <th>Нэр</th>
                                <th>Багш</th>
                                <th>Анги</th>
                                <th>Утасны дугаар</th>
                                <th>Status</th>
                                <th>Үйлдэл</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($reports as $key=>$item)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $item -> name }}</td>
                                    <td>{{$item->student->userDetails->lastname}} {{$item->student->userDetails->firstname}}</td>
                                    <td>
                                       {{$item->teacher->userDetails->firstname}}
                                    </td>
                                    <td>
                                        {{$item->student->class->name}}
                                    </td>
                                    <td>{{$item->student->userDetails->phone_number_1}}</td>
                                    <td>{{$item->status}}
                                    </td>

                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#payHistoryModal{{$item->id}}"
                                           class="btn btn-primary btn-sm" title="show">
                                            <i class="las la-book"></i>
                                        </a>

                                        <div class="modal fade" id="payHistoryModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="issueModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="issueModalLabel">Асуудалтай оюутан бүртгэх</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{route('admin.reported-student-update',['id'=>$item->id])}}" method="POST">
                                                        @method('PUT')
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div>
                                                                <label for="note">Сурагч</label>
                                                                <div class="input-group">
                                                                    <input name="note" class="form-control" type="text"
                                                                           id="note" value="{{$item->student->userDetails->firstname}}" readonly/>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <label for="note">Багш</label>
                                                                <div class="input-group">
                                                                    <input name="note" class="form-control" type="text"
                                                                           id="note" value="{{$item->teacher->userDetails->firstname}}" readonly/>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <label for="note">Шалтгаан</label>
                                                                <div class="input-group">
                                                                    <input name="note" class="form-control" type="text"
                                                                           id="note" value="{{$item->name}}" readonly/>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <label for="note">Тайлбар</label>
                                                                <div class="input-group">
                                                                    <textarea class="form-control" readonly>{{$item->description}}</textarea>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Цуцлах</button>
                                                            <button type="submit" class="btn btn-primary">Холбогдсон</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <a href="{{ url('admin/user/show/'.encrypt($item->student_id)) }}" target="_blank" class="btn btn-success btn-sm" title="show">
                                            <i class="las la-eye"></i>
                                        </a>

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
    <script src="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.5')}}"></script>
@endsection

@section('script')
    <script src="{{asset('admin/assets/js/pages/crud/datatables/data-sources/merchant.js?v=7.0.5')}}"></script>

    <script>
        var KTSelect2 = function () {
            var demos = function () {
                // basic
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

@endsection



