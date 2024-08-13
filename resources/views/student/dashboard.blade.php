@extends('layouts.student')

@section('style')
    <style>

    </style>
@endsection

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Education-->
                <div class="d-flex flex-row">
                    <!--begin::Aside-->
                    <div class="flex-row-auto offcanvas-mobile w-300px w-xl-325px" id="kt_profile_aside">
                        <!--begin::Nav Panel Widget 1-->
                        <div class="card card-custom gutter-b">
                            <!--begin::Body-->
                            <div class="card-body">
                                <!--begin::Wrapper-->
                                <div class="d-flex justify-content-between flex-column pt-4 h-100">
                                    <!--begin::Container-->
                                    <div class="pb-5">
                                        <!--begin::Header-->
                                        <div class="d-flex flex-column flex-center">
                                            <!--begin::Symbol-->
                                            <div class="symbol symbol-120 symbol-circle symbol-success overflow-hidden">
                                    <span class="symbol-label">
                                        @if(Auth::user()->userDetails->image)
                                            <img src="{{asset(Auth::user()->userDetails->image)}}" alt="" style="width: 100% ; height: auto; object-fit: cover">
                                        @elseif(Auth::user()->userDetails->gender == 'male')
                                            <img src="{{asset('admin/assets/media/svg/avatars/004-boy-1.svg')}}" class="h-75 align-self-end" alt="">
                                        @elseif(Auth::user()->userDetails->gender == 'female')
                                            <img src="{{asset('admin/assets/media/svg/avatars/003-girl-1.svg')}}" class="h-75 align-self-end" alt="">
                                        @else
                                            <img src="{{asset('admin/assets/media/svg/humans/custom-12.svg')}}" class="h-75 align-self-end" alt="">
                                        @endif

                                    </span>
                                            </div>
                                            <!--end::Symbol-->
                                            <!--begin::Username-->
                                            <a href="#" class="card-title font-weight-bolder text-dark-75 text-hover-primary font-size-h4 m-0 pt-7 pb-1">
                                                {{Auth::user()->userDetails->lastname}} {{Auth::user()->userDetails->firstname}}
                                            </a>
                                            <!--end::Username-->
                                            <!--begin::Info-->
                                            <div class="font-weight-bold text-dark-50 font-size-sm pb-6">{{Auth::user()->class->department->name}}</div>
                                            <!--end::Info-->
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Body-->
                                        <div class="pt-1">
                                            <!--begin::Text-->
                                            <p class="text-dark-75 font-weight-nirmal font-size-lg m-0 pb-7">✨If you believe yourself anything is possible✨</p>
                                            <!--end::Text-->
                                            <!--begin::Item-->
                                            <div class="d-flex align-items-center pb-9">
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-45 symbol-light mr-4">
                                        <span class="symbol-label">
                                            <span class="svg-icon svg-icon-2x svg-icon-dark-50">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                        <rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5"></rect>
                                                        <rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5"></rect>
                                                        <rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5"></rect>
                                                        <rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5"></rect>
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                                </div>
                                                <!--end::Symbol-->
                                                <!--begin::Text-->
                                                <div class="d-flex flex-column flex-grow-1">
                                                    <a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder">CLASS ID</a>
                                                    <span class="text-muted font-weight-bold">{{Auth::user()->class->name}}</span>
                                                </div>
                                                <!--end::Text-->
                                            </div>
                                            <!--end::Item-->
                                            <!--begin::Item-->
                                            <div class="d-flex align-items-center pb-9">
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-45 symbol-light mr-4">
                                        <span class="symbol-label">
                                            <span class="svg-icon svg-icon-2x svg-icon-dark-50">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                        <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5"></rect>
                                                        <path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3"></path>
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                                </div>
                                                <!--end::Symbol-->
                                                <!--begin::Text-->
                                                <div class="d-flex flex-column flex-grow-1">
                                                    <a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder">STUDENT ID</a>
                                                    <span class="text-muted font-weight-bold">{{Auth::user()->school_id}}</span>
                                                </div>
                                                <!--end::Text-->

                                            </div>
                                            <!--end::Item-->
                                            <!--begin::Item-->
                                            <div class="d-flex align-items-center pb-9">
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-45 symbol-light mr-4">
                                        <span class="symbol-label">
                                            <span class="svg-icon svg-icon-2x svg-icon-dark-50">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Home/Globe.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                        <path d="M13,18.9450712 L13,20 L14,20 C15.1045695,20 16,20.8954305 16,22 L8,22 C8,20.8954305 8.8954305,20 10,20 L11,20 L11,18.9448245 C9.02872877,18.7261967 7.20827378,17.866394 5.79372555,16.5182701 L4.73856106,17.6741866 C4.36621808,18.0820826 3.73370941,18.110904 3.32581341,17.7385611 C2.9179174,17.3662181 2.88909597,16.7337094 3.26143894,16.3258134 L5.04940685,14.367122 C5.46150313,13.9156769 6.17860937,13.9363085 6.56406875,14.4106998 C7.88623094,16.037907 9.86320756,17 12,17 C15.8659932,17 19,13.8659932 19,10 C19,7.73468744 17.9175842,5.65198725 16.1214335,4.34123851 C15.6753081,4.01567657 15.5775721,3.39010038 15.903134,2.94397499 C16.228696,2.49784959 16.8542722,2.4001136 17.3003976,2.72567554 C19.6071362,4.40902808 21,7.08906798 21,10 C21,14.6325537 17.4999505,18.4476269 13,18.9450712 Z" fill="#000000" fill-rule="nonzero"></path>
                                                        <circle fill="#000000" opacity="0.3" cx="12" cy="10" r="6"></circle>
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                                </div>
                                                <!--end::Symbol-->
                                                <!--begin::Text-->
                                                <div class="d-flex flex-column flex-grow-1">
                                                    <a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder">STATUS</a>
                                                    <span class="text-muted font-weight-bold">{{Auth::user()->userDetails->status}}</span>
                                                </div>
                                                <!--end::Text-->
                                            </div>
                                            <!--end::Item-->
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                    <!--eng::Container-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Nav Panel Widget 1-->
                    </div>
                    <!--end::Aside-->
                    <!--begin::Content-->
                    <div class="flex-row-fluid ml-lg-8">
                        <!--begin::Card-->
                        <div class="card card-custom card-stretch">
                            <!--Begin::Header-->
                            <div class="card-header card-header-tabs-line">
                                <div class="card-toolbar">
                                    <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x" role="tablist">
                                        <li class="nav-item mr-3">
                                            <a class="nav-link active" data-toggle="tab" href="#kt_apps_contacts_view_tab_2">
                                    <span class="nav-icon mr-2">
                                        <span class="svg-icon mr-3">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Chat-check.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                    <path d="M4.875,20.75 C4.63541667,20.75 4.39583333,20.6541667 4.20416667,20.4625 L2.2875,18.5458333 C1.90416667,18.1625 1.90416667,17.5875 2.2875,17.2041667 C2.67083333,16.8208333 3.29375,16.8208333 3.62916667,17.2041667 L4.875,18.45 L8.0375,15.2875 C8.42083333,14.9041667 8.99583333,14.9041667 9.37916667,15.2875 C9.7625,15.6708333 9.7625,16.2458333 9.37916667,16.6291667 L5.54583333,20.4625 C5.35416667,20.6541667 5.11458333,20.75 4.875,20.75 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                                    <path d="M2,11.8650466 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.23590829,11 3.04485894,11.3127315 2,11.8650466 Z M6,7 C5.44771525,7 5,7.44771525 5,8 C5,8.55228475 5.44771525,9 6,9 L15,9 C15.5522847,9 16,8.55228475 16,8 C16,7.44771525 15.5522847,7 15,7 L6,7 Z" fill="#000000"></path>
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </span>
                                                <span class="nav-text font-weight-bold">Personal</span>
                                            </a>
                                        </li>
                                        <li class="nav-item mr-3">
                                            <a class="nav-link" data-toggle="tab" href="#kt_apps_contacts_view_tab_3">
                                            <span class="nav-icon mr-2">
                                                <span class="svg-icon mr-3">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Devices/Display1.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"></rect>
                                                            <path d="M11,20 L11,17 C11,16.4477153 11.4477153,16 12,16 C12.5522847,16 13,16.4477153 13,17 L13,20 L15.5,20 C15.7761424,20 16,20.2238576 16,20.5 C16,20.7761424 15.7761424,21 15.5,21 L8.5,21 C8.22385763,21 8,20.7761424 8,20.5 C8,20.2238576 8.22385763,20 8.5,20 L11,20 Z" fill="#000000" opacity="0.3"></path>
                                                            <path d="M3,5 L21,5 C21.5522847,5 22,5.44771525 22,6 L22,16 C22,16.5522847 21.5522847,17 21,17 L3,17 C2.44771525,17 2,16.5522847 2,16 L2,6 C2,5.44771525 2.44771525,5 3,5 Z M4.5,8 C4.22385763,8 4,8.22385763 4,8.5 C4,8.77614237 4.22385763,9 4.5,9 L13.5,9 C13.7761424,9 14,8.77614237 14,8.5 C14,8.22385763 13.7761424,8 13.5,8 L4.5,8 Z M4.5,10 C4.22385763,10 4,10.2238576 4,10.5 C4,10.7761424 4.22385763,11 4.5,11 L7.5,11 C7.77614237,11 8,10.7761424 8,10.5 C8,10.2238576 7.77614237,10 7.5,10 L4.5,10 Z" fill="#000000"></path>
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </span>
                                                <span class="nav-text font-weight-bold">Payment</span>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <!--end::Header-->
                            <!--Begin::Body-->
                            <div class="card-body px-0">
                                <div class="tab-content pt-5">
                                    <!--begin::Tab Content-->
                                    <div class="tab-pane active" id="kt_apps_contacts_view_tab_2" role="tabpanel">

                                        <form action="{{ url('student/profile/info/'.Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <!--begin::Heading-->
                                            <div class="row">
                                                <div class="col-lg-9 col-xl-6 offset-xl-3">
                                                    <h3 class="font-size-h6 mb-5">Student Info:</h3>
                                                </div>
                                            </div>



                                            <!--end::Heading-->
                                            <div class="form-group row">
                                                <label for="image" class="col-xl-3 col-lg-3 text-right col-form-label">Photo</label>
                                                <div class="col-lg-9 col-xl-9">
                                                    <div class="image-input image-input-outline image-input-circle" id="kt_user_avatar">
                                                        <div class="image-input-wrapper" style="background-image: url(admin/assets/media/svg/avatars/007-boy-2.svg)"></div>
                                                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                                            <i class="fa fa-pen icon-sm text-muted"></i>
                                                            <input name="image" type="file">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="lastname" class="col-xl-3 col-lg-3 text-right col-form-label">Овог</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <input id="lastname" class="form-control form-control-lg form-control-solid" type="text" value="{{Auth::user()->userDetails->lastname}}" disabled>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="firstname" class="col-xl-3 col-lg-3 text-right col-form-label">Нэр</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <input id="firstname" class="form-control form-control-lg form-control-solid" type="text" value="{{Auth::user()->userDetails->firstname}}" disabled>
                                                </div>
                                            </div>



                                            <div class="form-group row">
                                                <label for="gender" class="col-xl-3 col-lg-3 text-right col-form-label">Хүйс</label>

                                                <div class="radio-inline">
                                                    <label class="radio radio-lg col-lg-9 col-xl-6">
                                                        <input type="radio" {{ Auth::user()->userDetails->gender == 'male' ? 'checked' : '' }} disabled/>
                                                        <span></span>
                                                        Эр
                                                    </label>

                                                    <label class="radio radio-lg col-lg-9 col-xl-6">
                                                        <input type="radio" {{ Auth::user()->userDetails->gender == 'female' ? 'checked' : '' }} disabled/>
                                                        <span></span>
                                                        Эм
                                                    </label>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="registration_number" class="col-xl-3 col-lg-3 text-right col-form-label">РЕГИСТР</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <input id="registration_number" class="form-control form-control-lg form-control-solid" type="text" value="{{Auth::user()->userDetails->registration_number}}">
                                                    <span class="form-text text-muted">Хэрэв таны хувийн аль нэг мэдээлэл зөрсөн байвал. Сургалтын албанд хандана уу</span>
                                                </div>
                                            </div>


                                            <div class="separator separator-dashed my-10"></div>
                                            <!--begin::Heading-->
                                            <div class="row">
                                                <div class="col-lg-9 col-xl-6 offset-xl-3">
                                                    <h3 class="font-size-h6 mb-5">Contact Info:</h3>
                                                </div>
                                            </div>
                                            <!--end::Heading-->
                                            <div class="form-group row">
                                                <label for="phone_number_1" class="col-xl-3 col-lg-3 text-right col-form-label">Phone 1</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <div class="input-group input-group-lg input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="la la-phone"></i>
                                                            </span>
                                                        </div>
                                                        <input id="phone_number_1" name="phone_number_1" type="text"
                                                               class="form-control form-control-lg form-control-solid" value="{{Auth::user()->userDetails->phone_number_1}}" placeholder="Утасны дугаар" disabled>
                                                    </div>
                                                    <span class="form-text text-muted">We'll never share your phone number with anyone else.</span>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="phone_number_2" class="col-xl-3 col-lg-3 text-right col-form-label">Phone 2</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <div class="input-group input-group-lg input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="la la-phone"></i>
                                                            </span>
                                                        </div>
                                                        <input id="phone_number_2" name="phone_number_2" type="text"
                                                               class="form-control form-control-lg form-control-solid" value="{{Auth::user()->userDetails->phone_number_2}}" placeholder="Утасны дугаар">
                                                    </div>
                                                    <span class="form-text text-muted">We'll never share your phone number with anyone else.</span>
                                                    @error('phone_number_2') <span class="text-danger">{{ $message }}</span> @enderror
                                                    <span></span>
                                                </div>
                                            </div>



                                            <div class="form-group row">
                                                <label for="email" class="col-xl-3 col-lg-3 text-right col-form-label">Email Address</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <div class="input-group input-group-lg input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="la la-at"></i>
                                                            </span>
                                                        </div>
                                                        <input name="email" id="email" type="email" class="form-control form-control-lg form-control-solid"
                                                               value="{{Auth::user()->email}}" placeholder="Email">
                                                    </div>
                                                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="date_of_birth" class="col-xl-3 col-lg-3 text-right col-form-label">Төрсөн өдөр</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <div class="input-group input-group-lg input-group-solid">
                                                        <input name="date_of_birth"  class="form-control" type="date"
                                                               value="{{Auth::user()->userDetails->date_of_birth}}"
                                                               id="date_of_birth"/>
                                                    </div>

                                                    @error('date_of_birth') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label for="admission_year" class="col-xl-3 col-lg-3 text-right col-form-label">Элссэн өдөр</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <div class="input-group input-group-lg input-group-solid">
                                                        <input  class="form-control" type="date"
                                                               value="{{Auth::user()->userDetails->admission_year}}"
                                                               id="admission_year" disabled/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-2">
                                                    </div>
                                                    <div class="col-10">
                                                        <button type="submit" class="btn btn-success mr-2">UPDATE</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>


                                    <!--end::Tab Content-->
                                    <!--begin::Tab Content-->
                                    <div class="tab-pane" id="kt_apps_contacts_view_tab_3" role="tabpanel">
                                        <form class="form">
                                            <!--begin::Heading-->
                                            <div class="row">
                                                <div class="col-lg-9 col-xl-6 offset-xl-3">
                                                    <h3 class="font-size-h6 mb-5">Төлбөрийн мэдээлэл:</h3>
                                                </div>
                                            </div>
                                            <!--end::Heading-->
                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 text-right col-form-label">Үндсэн төлбөр</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <div class="kt-spinner kt-spinner--sm kt-spinner--success kt-spinner--right kt-spinner--input">
                                                        <input class="form-control form-control-lg form-control-solid"
                                                               type="text"
                                                               value="@mongolian_currency(Auth::user()->payment->total_amount)₮" disabled>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 text-right col-form-label">Хямдарлын хувь</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <div class="kt-spinner kt-spinner--sm kt-spinner--success kt-spinner--right kt-spinner--input">
                                                        <input class="form-control form-control-lg form-control-solid"
                                                               type="text"
                                                               value="@mongolian_currency(Auth::user()->payment->discount_percentage)%" disabled>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 text-right col-form-label">Төлөх төлбөр</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <div class="kt-spinner kt-spinner--sm kt-spinner--success kt-spinner--right kt-spinner--input">
                                                        <input class="form-control form-control-lg form-control-solid"
                                                               type="text"
                                                               value="@mongolian_currency(Auth::user()->payment->due_amount)₮" disabled>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 text-right col-form-label">Төлсөн төлбөр</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <div class="kt-spinner kt-spinner--sm kt-spinner--success kt-spinner--right kt-spinner--input">
                                                        <input class="form-control form-control-lg form-control-solid"
                                                               type="text"
                                                               value="@mongolian_currency(Auth::user()->payment->paid_amount)₮" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-xl-3 col-lg-3 text-right col-form-label">Үлдэгдэл төлбөр</label>
                                                <div class="col-lg-9 col-xl-6">
                                                    <div class="kt-spinner kt-spinner--sm kt-spinner--success kt-spinner--right kt-spinner--input">
                                                        <input class="form-control form-control-lg form-control-solid"
                                                               type="text"
                                                               value="@mongolian_currency(Auth::user()->payment->due_amount - Auth::user()->payment->paid_amount)₮" disabled>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="separator separator-dashed my-10"></div>
                                            <!--begin::Heading-->
                                        </form>
                                    </div>
                                    <!--end::Tab Content-->

                                </div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Education-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>

@endsection


@section('script')
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
@endsection
