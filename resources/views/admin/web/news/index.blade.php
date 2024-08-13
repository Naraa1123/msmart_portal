@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col md-12">
            @if (session('message'))
                <div class="alert alert-success">{{session('message')}}</div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h4>NEWS
                        <a href="{{ url('admin/web/news/create') }}" class="btn btn-primary btn-sm text-white float-end">Мэдээ нэмэх</a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Гарчиг</th>
                            <th>Төлөв</th>
                            <th>Created Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($news as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td> {{$item->title}}</td>
                                <td>@if($item->status == '0')
                                        <label class="badge btn-success">public</label>
                                    @elseif($item->status == '1')
                                        <label class="badge btn-warning">private</label>
                                    @else
                                        <label class="badge btn-warning">Тодорхойгүй утга яаралтай хөгжүүлэгчид хэл</label>
                                    @endif</td>
                                <td>{{$item->created_at }}</td>

                                <td>
                                    <a href="{{ url('admin/web/news/edit/'.$item->id) }}" class="btn btn-success btn-sm">Edit</a>
                                    <a href="{{ url('admin/web/news/delete/'.$item->id) }}" onclick="return confirm('Are you sure to Delete?')" class="btn btn-danger btn-sm">Delete</a>
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="7">No News Available</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div>
                        {{ $news->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
