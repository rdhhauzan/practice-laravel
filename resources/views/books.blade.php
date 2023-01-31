@extends('master') @section('title', 'Book List :') @section('content')
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
<form action="/books/search" method="GET">
    <input type="text" name="name">
    <button type="submit">Search</button>
</form>
<a href="/books/generate-pdf">Download PDF</a>
<a href="/books/generate-excel">Download Excel</a>

@if(count($books) > 0)
<table class="table table-bordered table-hover" border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Book Name</th>
            <th>Price</th>
            <th>Description</th>
            <th>Genre</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp @foreach ($books as $book)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $book->bookName }}</td>
            <td>{{ "Rp " . number_format($book->price, 2, ',', '.') }}</td>
            <td>{{ $book->description }}</td>
            <td>{{ $book->name }}</td>
            <td>
                <a href="book/delete/{{ $book->bookId }}">Delete</a>
                <a href="book/update/{{ $book->bookId }}">Edit</a>
                <a href="book/generate-pdf/{{ $book->bookId }}">Generate PDF</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<h3 class="mt-3 text-center">No Data Found</h3>
@endif
@endsection