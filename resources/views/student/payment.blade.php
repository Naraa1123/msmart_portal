@extends('layouts.student')

@section('content')
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!-- begin::Card-->
            <div class="card card-custom overflow-hidden">
                <div class="card-body p-0">
                    <!-- begin: Invoice-->
                    <!-- begin: Invoice header-->
                    <div class="row justify-content-center bgi-size-cover bgi-no-repeat py-8 px-8 py-md-27 px-md-0"
                         style="background-image: url(admin/assets/media/bg/bg-6.jpg);">
                        <div class="col-md-9">
                            <div class="d-flex justify-content-between pb-10 pb-md-20 flex-column flex-md-row">
                                <h1 class="display-4 text-white font-weight-boldest mb-10">M SMART ACADEMY</h1>
                            </div>
                            <div class="border-bottom w-100 opacity-20"></div>
                            <div class="d-flex justify-content-between text-white pt-6">
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolde mb-2r">Элссэн он</span>
                                    <span class="opacity-70">{{$user->userDetails->admission_year}}</span>
                                </div>
                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">Оюутны код</span>
                                    <span class="opacity-70">{{$user->school_id}}</span>
                                </div>

                                <div class="d-flex flex-column flex-root">
                                    <span class="font-weight-bolder mb-2">Оюутны овог нэр</span>
                                    <span
                                        class="opacity-70">{{$user->userDetails->lastname}} {{$user->userDetails->firstname}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end: Invoice header-->
                    <!-- begin: Invoice body-->
                    <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                        <div class="col-md-9">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="pl-0 font-weight-bold text-muted text-uppercase">Description</th>
                                        <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">VALUE
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="font-weight-boldest font-size-lg">
                                        <td class="pl-0 pt-7">Үндсэн төлбөр</td>
                                        <td class="text-danger pr-0 pt-7 text-right">
                                            @mongolian_currency($user->payment->total_amount)₮
                                        </td>
                                    </tr>
                                    <tr class="font-weight-boldest border-bottom-0 font-size-lg">
                                        <td class="border-top-0 pl-0 py-4">Хямдралын хувь</td>
                                        <td class="text-danger border-top-0 pr-0 py-4 text-right">{{ $user->payment->discount_percentage}}
                                            %
                                        </td>
                                    </tr>
                                    <tr class="font-weight-boldest border-bottom-0 font-size-lg">
                                        <td class="border-top-0 pl-0 py-4">Төлөх төлбөр</td>
                                        <td class="text-danger border-top-0 pr-0 py-4 text-right">
                                            @mongolian_currency($user->payment->due_amount)₮
                                        </td>
                                    </tr>

                                    <tr class="font-weight-boldest border-bottom-0 font-size-lg">
                                        <td class="border-top-0 pl-0 py-4">Нийт төлсөн төлбөр</td>
                                        <td class="text-danger border-top-0 pr-0 py-4 text-right">
                                            @php
                                                $totalPaid = $user->payment->fees->sum('paid_amount');
                                            @endphp
                                            @mongolian_currency($totalPaid)₮
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end: Invoice body-->
                    <!-- begin: Invoice footer-->
                    <div class="row justify-content-center bg-gray-100 py-8 px-8 py-md-10 px-md-0">
                        <div class="col-md-9">
                            <div class="d-flex justify-content-between flex-column flex-md-row font-size-lg">
                                <div class="d-flex flex-column mb-10 mb-md-0">
                                    <div class="font-weight-bolder font-size-lg mb-3">Төлбөр төлөх (ШИЛЖҮҮЛЭГ)</div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="mr-15 font-weight-bold">Дансны нэр:</span>
                                        <span class="text-right">M Smart Coding</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="mr-15 font-weight-bold">Дансны дугаар:</span>
                                        <span class="text-right">5070955032</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="mr-15 font-weight-bold">Утга:</span>
                                        <span class="text-right">Оюутны нэр кодоо бичнэ үү</span>
                                    </div>
                                </div>
                                <div class="d-flex flex-column text-md-right">
                                    <span class="font-size-lg font-weight-bolder mb-1">Үлдэгдэл төлбөр</span>
                                    <span class="font-size-h2 font-weight-boldest text-danger mb-1">
                                        @php
                                            $remainingAmount = $user->payment->due_amount - $totalPaid;
                                        @endphp
                                        @mongolian_currency($remainingAmount)₮
                                    </span>
                                    <span>Баримт авах боломжтой</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end: Invoice footer-->

                    <!-- begin: Invoice action-->
                    <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                        <div class="col-md-9">

                            <div class="d-flex justify-content-between">
                                <button type="button" data-toggle="modal"
                                        data-target="#paymentModal"
                                        class="btn btn-primary btn-lg btn-block">QPAY - ЭЭР ТӨЛӨХ
                                </button>
                            </div>

                            <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog"
                                 aria-labelledby="paymentModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="paymentModalLabel">Төлбөрөө хуваан төлөх
                                                боломжтой</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <form action="{{route('api.invoice.create')}}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <label for="amount">Төлбөр: </label>
                                                <div class="input-group">
                                                    <input placeholder="Мөнгөн дүн бичнэ үү" name="amount"
                                                           class="form-control"
                                                           type="number"
                                                           min="100"
                                                           max="{{$remainingAmount}}"
                                                           id="amount"
                                                           required/>

                                                    <input name="user_id" type="text" hidden value="{{ $user->id }}">
                                                </div>
                                            </div>


                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    БУЦАХ
                                                </button>
                                                <button type="submit" class="btn btn-primary">ТӨЛӨХ</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- end: Invoice action-->
                    <!-- end: Invoice-->

                </div>
            </div>
            <!-- end::Card-->
        </div>
        <!--end::Container-->
    </div>
@endsection
