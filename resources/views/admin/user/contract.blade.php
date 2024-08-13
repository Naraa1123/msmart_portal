@extends('layouts.admin')

@section('style')
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{asset('admin/assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.5')}}" rel="stylesheet" type="text/css"/>
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
                            <h3 class="card-label">{{$user->userDetails->lastname}} {{$user->userDetails->firstname}} хэрэглэгчийн file data</h3>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{url('admin/user/contract/'.$user->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-10">
                                    <label>Гэрээ хавсаргана уу</label>
                                    <div class="custom-file">
                                        <input name="contract[]" multiple
                                               type="file"
                                               class="custom-file-input form-control"
                                               id="contract" value="{{old('contract')}}"/>
                                        <label class="custom-file-label" for="contract">Гэрээнүүд хавсаргана уу /олон байх боломжтой/</label>
                                    </div>
                                    @error('contract')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-2 d-flex align-items-center">
                                    <button type="submit" class="btn btn-success mr-2">SAVE</button>
                                </div>
                            </div>
                        </form>
                    </div>


                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                               style="margin-top: 13px !important">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>File</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($user->userContracts as $key=>$item)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>
                                        <a href="{{ asset($item->file) }}"
                                           download>{{ basename($item->file) }}
                                        </a>
                                    </td>
                                    <td>{{ $item->created_at}}</td>

                                    <td>
                                        <a href="{{ url('admin/user/contract/delete/'.$item->id) }}"
                                           onclick="return confirm('Are you sure to Delete?')"
                                           class="btn btn-sm btn-clean btn-icon" title="delete">
                                            <i class="la la-trash"></i>
                                        </a>
                                    </td>

                                </tr>
                            @empty
                                <td>No Data Available</td>
                            @endforelse
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
