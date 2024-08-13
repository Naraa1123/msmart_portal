@extends('layouts.admin')

@section('style')
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="admin/assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.5" rel="stylesheet" type="text/css"/>
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
                            <h3 class="card-label">Сурагчид</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                               style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>School ID</th>
                                <th>Овог</th>
                                <th>Нэр</th>
                                <th>Утас</th>
                                <th>status</th>
                                <th>Диплом</th>
                                <th>Диплом авсан өдөр</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($students as $key=>$item)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $item->school_id }}</td>
                                    <td>{{ $item->userDetails->lastname }}</td>
                                    <td>{{ $item->userDetails->firstname }}</td>
                                    <td>{{ $item->userDetails->phone_number_1 }}</td>

                                    <td class="datatable-cell-sorted datatable-cell" data-field="Status" aria-label="1">
                                        @if($item->userDetails->status  == 'studying')
                                            <span style="width: 112px;">
                                                <span
                                                    class="label font-weight-bold label-lg  label-light-info label-inline">суралцаж_байгаа</span>
                                        </span>

                                        @elseif($item->userDetails->status  == 'dropped_out')
                                                <span style="width: 112px;">
                                                <span
                                                    class="label font-weight-bold label-lg  label-light-danger label-inline">хаясан</span>
                                        </span>
                                        @elseif($item->userDetails->status  == 'took_leave')
                                            <span style="width: 112px;">
                                                <span
                                                    class="label font-weight-bold label-lg  label-light-warning label-inline">чөлөө</span>
                                        </span>
                                        @elseif($item->userDetails->status  == 'graduated')
                                            <span style="width: 112px;">
                                                <span
                                                    class="label font-weight-bold label-lg  label-light-info label-inline">төгссөн</span>
                                        </span>
                                        @else
                                            <span style="width: 110px;">
                                                <span
                                                    class="label font-weight-bold label-lg  label-light-warning label-inline">wtf Чинхүү-д хэл</span></span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->userDetails->has_diploma=='received')
                                            Диплом авсан
                                        @else
                                            Диплом аваагүй
                                        @endif
                                    </td>
                                    <td>
                                        {{$item->userDetails->diploma_received_date}}
                                    </td>
                                    <td>
                                        @if($item->userDetails->status=='graduated')
                                            <a href="#" data-toggle="modal" data-target="#diplomaModal{{$item->id}}"
                                               class="btn btn-warning">
                                                Диплом
                                            </a>
                                        @endif
                                        <a href="#" data-toggle="modal" data-target="#payModal{{$item->id}}"
                                           class="btn btn-primary">
                                            Дүн харах
                                        </a>
                                    </td>
                                    <div class="modal fade" id="payModal{{$item->id}}" tabindex="-1" role="dialog"
                                         aria-labelledby="payModalLabel{{$item->id}}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title"
                                                        id="payModalLabel"
                                                        style="font-weight: bold;">{{$item->userDetails->firstname}}</h3>
                                                </div>
                                                <div class="modal-body">
                                                    @forelse($item->subjectGrades as $grade)
                                                        <div class="row">
                                                            <div class="col-xl-6">
                                                                <div class="form-group">
                                                                    <label for="paid_amount">Хичээл</label>
                                                                    <div class="input-group">
                                                                        <input placeholder="төлсөн дүн бичнэ үү"
                                                                               name="paid_amount"
                                                                               class="form-control"
                                                                               type="text"
                                                                               value="{{$grade->subject->name}}"
                                                                               readonly/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <div class="form-group">
                                                                    <label for="paid_amount">Дүн</label>
                                                                    <div class="input-group">
                                                                        <input placeholder="төлсөн дүн бичнэ үү"
                                                                               name="paid_amount"
                                                                               class="form-control"
                                                                               type="text" value="{{$grade->grade}}%"
                                                                               readonly/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <h3>Дүн гараагүй байна</h3>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="diplomaModal{{$item->id}}" tabindex="-1" role="dialog"
                                         aria-labelledby="payModalLabel{{$item->id}}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title"
                                                        id="payModalLabel"
                                                        style="font-weight: bold;">{{$item->userDetails->firstname}}</h3>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST"
                                                          action="{{ route('admin.update-diploma', ['id' => $item->id]) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <label for="has_diploma">Диплом</label>
                                                        <div class="input-group">
                                                            <select name="has_diploma" class="form-control">
                                                                <option
                                                                    value="received" {{ $item->userDetails->has_diploma === 'received' ? 'selected' : '' }}>
                                                                    Диплом авсан
                                                                </option>
                                                                <option
                                                                    value="not_received" {{ $item->userDetails->has_diploma === 'not_received' ? 'selected' : '' }}>
                                                                    Диплом аваагүй
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <label for="diploma_name" class="mt-4">Дипломын сэдэв</label>
                                                        <div class="input-group">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="diploma_name" id="diploma_name"
                                                                value="{{$item->userDetails->diploma_name}}" required>
                                                            </div>
                                                        </div>
                                                        <label for="diploma_received_date" class="mt-4">Дипломын олгосон өдөр</label>
                                                        <div class="input-group">
                                                            <div class="input-group">
                                                                <input type="date" class="form-control" name="diploma_received_date" id="diploma_received_date"
                                                                       value="{{$item->userDetails->diploma_received_date}}" required>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary mt-4">Хадгалах</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
    <script src="admin/assets/js/pages/crud/datatables/data-sources/merchant.js?v=7.0.5"></script>
    <!--end::Page Scripts-->
@endsection
