@extends('Guest\GuestMaster') @section('title', 'User Wishlists')
@section('content')
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
<h5>Your Total Wishlists : {{count($books)}} Books</h5>
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
            <td>{{ "Rp " . number_format($book->bookPrice, 2, ',', '.') }}</td>
            <td>{{ $book->bookDescription }}</td>
            <td>{{ $book->genreName }}</td>
            <td>
                <a href="/guest/book/buy/{{ $book->bookId }}" class="btn btn btn-primary">Buy Book</a>
                <a href="/guest/wishlist/delete/{{ $book->bookId }}" class="btn btn-danger">Delete Wishlist</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<h3 class="mt-3 text-center">No Wishlist Found!</h3>
@endif
@endsection

<body>
    <div class="container">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>