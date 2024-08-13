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
                            <h3 class="card-label">Мэдэгдэл явуулсан оюутнууд</h3>
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
                                <th>USERID</th>
                                <th>Овог Нэр</th>
                                <th>Утасны дугаарууд</th>
                                <th>Асуудлын төрөл</th>
                                <th>Тэмдэглэл</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($issued_students as $key=>$item)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <th>{{$item->user->class->name}}</th>
                                    <th>{{$item->user->school_id}}</th>
                                    <th>{{$item->user->userDetails->lastname}} {{$item->user->userDetails->firstname}}</th>
                                    <th> {{ optional($item->user->userDetails)->phone_number_1 ?? '' }},
                                        {{ optional($item->user->userDetails)->phone_number_2 ?? '' }},
                                        {{ optional($item->user->userDetails)->phone_number_3 ?? '' }}</th>
                                    <td class="datatable-cell-sorted datatable-cell" data-field="Status" aria-label="1">
                                        @if($item->issue_type == 'payment')
                                            <span style="width: 112px;">
                                                <span
                                                    class="label font-weight-bold label-lg  label-light-warning label-inline">төлбөр</span>
                                            </span>
                                        @elseif($item->issue_type == 'attendance')
                                            <span style="width: 112px;">
                                                <span
                                                    class="label font-weight-bold label-lg  label-light-danger label-inline">ирц</span>
                                            </span>
                                        @else
                                            <span style="width: 112px;">
                                                <span
                                                    class="label font-weight-bold label-lg  label-light-success label-inline">wtf chinku д хэл</span>
                                        </span>
                                        @endif
                                    </td>

                                    <td>{{ $item->note }}</td>
                                    <td>{{ $item->created_at }}</td>

                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#surveyModal{{$item->id}}"
                                           class="btn btn-sm btn-clean btn-icon" title="тэмдэглэл">
                                            <i class="la la-plus"></i>
                                        </a>

                                        <div class="modal fade" id="surveyModal{{$item->id}}" tabindex="-1" role="dialog"
                                             aria-labelledby="surveyModalLabel{{$item->id}}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="surveyModalLabel">Уулзалтын тэмдэглэл хөтлөх</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <form action="{{route('admin.issued.student.archive')}}" method="POST">
                                                        @csrf
                                                        <input type="hidden" value="{{$item->user_id}}" name="user_id">
                                                        <input type="hidden" value="{{$item->issue_type}}" name="issue_type">
                                                        <div class="modal-body">
                                                            <label for="name">Уулзалтын тэмдэглэл: </label>
                                                            <div class="input-group">
                                                                <textarea placeholder="Уулзалтын тэмдэглэл бичнэ үү" name="meeting_note"
                                                                          class="form-control"
                                                                          type="text"
                                                                          id="name"
                                                                          required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Cancel
                                                            </button>
                                                            <button type="submit" class="btn btn-primary">SUBMIT
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <a href="{{ route('admin.issue-delete', ['id' => encrypt($item->id)]) }}"
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
@endsection



