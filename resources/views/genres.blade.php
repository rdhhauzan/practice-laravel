@extends('master') @section('title', 'Genre List :') @section('content')
{{-- <a href="/genres/generate-pdf">Download PDF</a>
<a href="/genres/generate-excel">Download Excel</a> --}}
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

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
                    <a href="genre/delete/{{ $genre->id }}">Delete</a>
                    <a href="genre/update/{{ $genre->id }}">Edit</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
