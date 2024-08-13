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
                            <h3 class="card-label">ТӨЛБӨРИЙН ҮЛДЭГДЭЛТЭЙ ОЮУТНУУД</h3>
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
                                <th>Төлбөрийн үлдэгдэл</th>
                                <th>Үйлдэл</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($payments as $key=>$item)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ optional($item->user->class)->name  ?? 'No Available' }}</td>
                                    <td>{{ $item->user->school_id }}</td>
                                    <td>{{ optional($item->user->userDetails)->lastname ?? 'No Available' }} {{ optional($item->user->userDetails)->firstname ?? 'No Available' }}</td>
                                    <td>
                                        {{ optional($item->user->userDetails)->phone_number_1 ?? '' }},
                                        {{ optional($item->user->userDetails)->phone_number_2 ?? '' }},
                                        {{ optional($item->user->userDetails)->phone_number_3 ?? '' }}
                                    </td>
                                    <td>{{$item->user->userDetails->admission_year}}</td>
                                    <td>
                                        @php
                                            $totalPaid = $item->fees->sum('paid_amount');
                                            $remainingAmount = $item->due_amount - $totalPaid;
                                        @endphp
                                        @mongolian_currency($remainingAmount)₮
                                    </td>

                                    <td>
                                        <a href="{{ url('admin/user/show/'.encrypt($item->user->id)) }}"
                                           class="btn btn-primary btn-sm" title="show">
                                            <i class="las la-eye"></i>
                                        </a>

                                        <a href="#" data-toggle="modal" data-target="#payHistoryModal{{$item->id}}"
                                           class="btn btn-info btn-sm">
                                            <i class="las la-book-open"></i>
                                        </a>

                                        <div class="modal fade" id="payHistoryModal{{$item->id}}" tabindex="-1"
                                             role="dialog" aria-labelledby="payHistoryModalLabel{{$item->id}}"
                                             aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="payHistoryModalLabel{{$item->id}}">
                                                            Төлбөрийн түүх</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th>Төлсөн дүн</th>
                                                                <th>Төлбөрийн арга</th>
                                                                <th>Тайлбар</th>
                                                                <th>Төлсөн огноо</th>
                                                                <th>Зураг</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($item->fees as $fee)
                                                                <tr>
                                                                    <td>@mongolian_currency($fee->paid_amount)₮</td>
                                                                    <td>{{$fee->payment_method}}</td>
                                                                    <td>{{$fee->description}}</td>
                                                                    <td>{{$fee->paid_date}}</td>
                                                                    <td>
                                                                        <img src="{{ asset($fee->payment_image) }}" style="width:50px; height:50px;" class="me-4 border img-thumbnail" alt="зураг байхгүй" data-toggle="modal" data-target="#imageModal{{ $loop->index }}">

                                                                        <div class="modal fade" id="imageModal{{ $loop->index }}" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel{{ $loop->index }}" aria-hidden="true">
                                                                            <div class="modal-dialog modal-lg" role="document">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="imageModalLabel{{ $loop->index }}">Гүйлгээний эсвэл төлбөрийн баримт зураг</h5>
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                            <span aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <img src="{{ asset($fee->payment_image) }}" class="img-fluid" alt="Responsive image">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Хаах
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <a href="#" data-toggle="modal" data-target="#issueModal{{$item->user->id}}" class="btn btn-warning btn-sm">
                                            <i class="las la-comment"></i>
                                        </a>

                                        <div class="modal fade" id="issueModal{{$item->user->id}}" tabindex="-1" role="dialog" aria-labelledby="issueModalLabel{{$item->user->id}}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="issueModalLabel{{$item->user->id}}">Асуудалтай оюутан бүртгэх</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('admin.issue-store', ['id' => encrypt($item->user->id) ]) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <input name="issue_type" type="text" value="payment" hidden>

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



