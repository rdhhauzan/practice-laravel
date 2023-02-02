@extends('Guest\GuestMaster') @section('title', 'Book List') @section('content')
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<form action="{{ route('search') }}" method="GET">
    <div class="input-group mb-3 w-25">
        <input type="text" name="name" placeholder="Enter Book name..." class="form-control">
        <button type="submit" class="btn btn-outline-secondary">Search</button>
    </div>
</form>

@if(count($books) > 0)
<div class="row gx-3 justify-content-center mt-4">
    @foreach($books as $book)
    <div class="col-lg-2 col-md-12">
        <div class="card mb-3" style="max-width: 300px;">
            <img src="{{url('/images/'.$book->image)}}  " class="card-img-top" alt="Product Image">
            <div class="card-body">
                <h5 class="card-title">{{ $book->bookName }}</h5>
                <p class="card-text">{{ $book->description }}</p>
                <p class="card-text"><small class="text-muted">{{ $book->name }}</small></p>
                <p class="card-text">
                    <span class="text-primary" style="font-weight: bold;">{{ "Rp " . number_format($book->price, 2, ',',
                        '.') }}</span>
                </p>
                <a href="/guest/book/buy/{{ $book->bookId }}" class="btn btn-sm btn-outline-danger">Buy</a>
                <form action="/guest/wishlist/add/{{ $book->bookId }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary btn-sm mt-3">Add to Wishlist</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
<nav aria-label="Page navigation example">
    <ul class="pagination d-flex justify-content-center">
        <li class="page-item {{ ($books->currentPage() == 1) ? ' disabled' : '' }}">
            <a href="{{ $books->url(1) }}" class="page-link">First</a>
        </li>
        <li class="page-item {{ ($books->currentPage() == 1) ? ' disabled' : ''}}">
            <a href="{{ $books->previousPageUrl() }}" class="page-link">Previous</a>
        </li>
        @for($i = 1; $i <= $books->lastPage(); $i++)
            <li class="page-item {{ ($books->currentPage() == $i) ? ' active' : '' }}">
                <a class="page-link" href="{{ $books->url($i) }}">{{ $i }}</a>
            </li>
            @endfor
            <li class="page-item {{ ($books->currentPage() == $books->lastPage()) ? ' disabled' : '' }}">
                <a class="page-link" href="{{ $books->nextPageUrl() }}">Next</a>
            </li>
            <li class="page-item {{ ($books->currentPage() == $books->lastPage()) ? ' disabled' : '' }}">
                <a class="page-link" href="{{ $books->url($books->lastPage()) }}">Last</a>
            </li>
    </ul>
</nav>
@else
<h3 class="mt-3 text-center">No Data Found</h3>
@endif
@endsection