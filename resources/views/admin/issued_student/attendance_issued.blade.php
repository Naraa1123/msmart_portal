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
                            <h3 class="card-label">ИРЦИЙН АСУУДАЛТАЙ ОЮУТНУУД</h3>
                        </div>
                    </div>

                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                               style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Анги</th>
                                <th>USER ID</th>
                                <th>Овог Нэр</th>
                                <th>Утасны дугаарууд</th>
                                <th>Элссэн жил</th>
                                <th>Тас</th>
                                <th>Хоцорсон</th>
                                <th>Чөлөө</th>
                                <th>Үйлдэл</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $key=>$item)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ optional($item->class)->name  ?? 'No Available' }}</td>
                                    <td>{{ $item->school_id }}</td>
                                    <td>{{ optional($item->userDetails)->lastname ?? 'No Available' }} {{ optional($item->userDetails)->firstname ?? 'No Available' }}</td>
                                    <td>
                                        {{ optional($item->userDetails)->phone_number_1 ?? '' }},
                                        {{ optional($item->userDetails)->phone_number_2 ?? '' }},
                                        {{ optional($item->userDetails)->phone_number_3 ?? '' }}
                                    </td>
                                    <td>{{$item->userDetails->admission_year}}</td>
                                    <td>{{$item->attendance_type_1_count}}</td>
                                    <td>{{$item->attendance_type_3_count}}</td>
                                    <td>{{$item->attendance_type_5_count}}</td>

                                    <td>
                                        <a href="{{ url('admin/user/show/'.encrypt($item->id)) }}"
                                           class="btn btn-primary btn-sm" title="show">
                                            <i class="las la-eye"></i>
                                        </a>

                                        <a href="#" data-toggle="modal" data-target="#issueModal{{$item->id}}" class="btn btn-warning btn-sm">
                                            <i class="las la-comment"></i>
                                        </a>

                                        <div class="modal fade" id="issueModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="issueModalLabel{{$item->id}}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="issueModalLabel{{$item->id}}">Асуудалтай оюутан бүртгэх</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('admin.issue-store', ['id' => encrypt($item->id) ]) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <input name="issue_type" type="text" value="attendance" hidden>

                                                            <label for="note">Тэмдэглэл бичих хэсэг: </label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend"><span class="input-group-text">~</span></div>
                                                                <input placeholder="тэмдэглэл бичнэ үү" name="note" class="form-control"
                                                                       type="text"
                                                                       id="note"/>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Цуцлах</button>
                                                            <button type="submit" class="btn btn-primary">Бүртгэх</button>
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



