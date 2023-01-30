@extends('Guest\GuestMaster') @section('title', 'Book List :') @section('content')
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<form action="{{ route('search') }}" method="GET">
    <input type="text" name="name">
    <button type="submit">Search</button>
</form>

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
            <td>{{ $book->price }}</td>
            <td>{{ $book->description }}</td>
            <td>{{ $book->name }}</td>
            <td>
                <a href="/guest/book/buy/{{ $book->bookId }}" class="btn btn-primary">Buy Book</a>
                <form action="/guest/wishlist/add/{{ $book->bookId }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-primary my-2">Add to Wishlist</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection