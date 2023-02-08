@extends('master') @section('title', 'Genre List :') @section('content')
{{-- <a href="/genres/generate-pdf">Download PDF</a>
<a href="/genres/generate-excel">Download Excel</a> --}}
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
<div class="my-3">
    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Add Genre
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Book</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/genre" method="post">
                    @csrf
                    <div class="form-floating">
                        <input type="text" class="form-control rounded-top" name="name" id="name" required
                            value="{{ old('name') }}" placeholder="Name">
                        <label for="name">Genre Name</label>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button class="w-100 btn btn-lg btn-danger mt-3" type="submit">Add Genre</button>
                </form>
            </div>
        </div>
    </div>
</div>
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