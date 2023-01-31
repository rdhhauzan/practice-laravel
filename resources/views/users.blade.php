@extends('master') @section('title', 'User List :') @section('content')
{{-- <a href="/users/generate-pdf">Download PDF</a>
<a href="/users/generate-excel">Download Excel</a> --}}
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if(count($users) > 0)
<table class="table table-bordered table-hover" border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp @foreach ($users as $user)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>
            <td>
                <a href="user/delete/{{ $user->id }}">Delete</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<h3 class="mt-3 text-center">No Data Found!</h3>
@endif
@endsection