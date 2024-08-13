@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col md-12">
            @if (session('message'))
                <div class="alert alert-success">{{session('message')}}</div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h4>ENTRANTS
{{--                        <a href="{{ url('admin/entrant/create') }}" class="btn btn-primary btn-sm text-white float-end">Элсэгч нэмэх</a>--}}
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Сонгосон Тэнхим</th>
                            <th>Нэр</th>
                            <th>Email</th>
                            <th>Утас</th>
                            <th>Төлөв</th>
                            <th>Created Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($entrants as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>
                                    @if($item->department)
                                        {{ $item->department->name }}
                                    @else
                                        No Department
                                    @endif
                                </td>
                                <td> {{$item->name}}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{$item->phone }}</td>
                                <td>@if($item->status == 'registered')
                                        <label class="badge btn-success">Бүргүүлсэн</label>
                                    @elseif($item->status == 'temporary_registration')
                                        <label class="badge btn-warning">Түр Бүртгэл</label>
                                    @elseif($item->status == 'called')
                                        <label class="badge btn-primary">Залгасан</label>
                                    @else
                                        <label class="badge btn-warning">Тодорхойгүй утга яаралтай хөгжүүлэгчид хэл</label>
                                    @endif</td>
                                <td>{{$item->created_at }}</td>

                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="statusDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Change Status
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="statusDropdown">
                                            <a class="dropdown-item" href="{{ url('admin/entrant/change-status/'.$item->id.'/registered') }}">Бүргүүлсэн</a>
                                            <a class="dropdown-item" href="{{ url('admin/entrant/change-status/'.$item->id.'/temporary_registration') }}">Түр Бүртгэл</a>
                                            <a class="dropdown-item" href="{{ url('admin/entrant/change-status/'.$item->id.'/called') }}">Залгасан</a>
                                        </div>
                                    </div>

                                    <a href="{{ url('admin/entrant/edit/'.$item->id) }}" class="btn btn-success btn-sm">Edit</a>
                                    <a href="{{ url('admin/entrant/delete/'.$item->id) }}" onclick="return confirm('Are you sure to Delete?')" class="btn btn-danger btn-sm">Delete</a>
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="7">No Entrant Available</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div>
                        {{ $entrants->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection

