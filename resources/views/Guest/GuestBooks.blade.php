@extends('Guest\GuestMaster') @section('title', 'Book List :') @section('content')
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<form action="{{ route('search') }}" method="GET">
    <input type="text" name="name" placeholder="Enter Book name...">
    <button type="submit">Search</button>
</form>

@if(count($books) > 0)
<table class="table table-bordered table-hover mt-3" border="1">
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
@else
<h3 class="mt-3 text-center">No Data Found</h3>
@endif
@endsection