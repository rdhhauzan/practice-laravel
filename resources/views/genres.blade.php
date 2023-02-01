@extends('master') @section('title', 'Genre List :') @section('content')
{{-- <a href="/genres/generate-pdf">Download PDF</a>
<a href="/genres/generate-excel">Download Excel</a> --}}
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if(count($genres) > 0)
<table class="table table-bordered table-hover" border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Genre Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp @foreach ($genres as $genre)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $genre->name }}</td>
            <td>
                <a href="genre/update/{{ $genre->id }}" class="btn btn-outline-warning">Edit</a>
                <a href="genre/delete/{{ $genre->id }}" class="btn btn-outline-danger">Delete</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<h3 class="mt-3 text-center">No Data Found!</h3>
@endif
@endsection