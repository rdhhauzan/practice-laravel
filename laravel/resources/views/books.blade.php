@extends('master') @section('title', 'Book List') @section('content')
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
<form action="/books/search" method="GET">
    <div class="input-group mb-3 w-25">
        <input type="text" name="name" placeholder="Enter Book name..." class="form-control">
        <button type="submit" class="btn btn-outline-secondary">Search</button>
    </div>
</form>
<div class="my-3">
    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Add Book
    </button>
    <a href="/books/generate-pdf" class="btn btn-outline-primary">Generate PDF</a>
    <a href="/books/generate-excel" class="btn btn-outline-primary">Generate Excel</a>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Book</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/book" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-floating my-3">
                        <input type="text" class="form-control rounded-top" name="name" id="name" required
                            value="{{ old('name') }}" placeholder="Name">
                        <label for="name">Book Name</label>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating my-3">
                        <input type="number" class="form-control " name="price" id="price" required
                            value="{{ old('price') }}" placeholder="10000">
                        <label for="price">Book Price</label>
                        @error('price')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating my-3">
                        <input type="text" class="form-control rounded-bottom" name="description" id="description"
                            required value="{{ old('description') }}" placeholder="description">
                        <label for="description">Description</label>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating my-3">
                        <input type="file" class="form-control rounded-bottom" name="image" id="image" required
                            value="{{ old('image') }}" placeholder="image">
                        <label for="image">Image</label>
                        @error('image')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating my-3">
                        <select class="form-select" id="floatingSelect" aria-label="Floating label select example"
                            name="genreId">
                            <option selected disabled>--- SELECT GENRE ---</option>
                            @foreach ($genres as $genre)
                            <option value="{{ $genre->id }}" {{ $genre->id == old('genreId') ? 'selected' : '' }}>
                                {{ $genre->name }}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Genre</label>
                        @error('genreId')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="w-100 btn btn-lg btn-danger my-3" type="submit">Add Book</button>
                </form>
            </div>
        </div>
    </div>
</div>
@if(count($books) > 0)
<table class="table table-bordered table-hover data-table" border="1">
    <tr>
        <th><a style="text-decoration:none; color: inherit;"
                href="{{ url()->current() }}?column=id&direction={{ request()->direction == 'asc' ? 'desc' : 'asc' }}">No
                @if(request()->input('column') == 'id' && request()->input('direction') == 'asc')
                <i class="fas fa-arrow-up"></i>
                @else
                <i class="fas fa-arrow-down"></i>
                @endif
            </a>
        </th>
        <th><a style="text-decoration:none; color: inherit;"
                href="{{ url()->current() }}?column=bookName&direction={{ request()->direction == 'asc' ? 'desc' : 'asc' }}">Book
                Name
                @if(request()->input('column') == 'bookName' && request()->input('direction') == 'asc')
                <i class="fas fa-arrow-up"></i>
                @else
                <i class="fas fa-arrow-down"></i>
                @endif
            </a></th>
        <th><a style="text-decoration:none; color: inherit;"
                href="{{ url()->current() }}?column=price&direction={{ request()->direction == 'asc' ? 'desc' : 'asc' }}">Book
                Price
                @if(request()->input('column') == 'price' && request()->input('direction') == 'asc')
                <i class="fas fa-arrow-up"></i>
                @else
                <i class="fas fa-arrow-down"></i>
                @endif
            </a></th>
        <th>Description</th>
        <th><a style="text-decoration:none; color: inherit;"
                href="{{ url()->current() }}?column=name&direction={{ request()->direction == 'asc' ? 'desc' : 'asc' }}">Genre
                @if(request()->input('column') == 'name' && request()->input('direction') == 'asc')
                <i class="fas fa-arrow-up"></i>
                @else
                <i class="fas fa-arrow-down"></i>
                @endif
            </a>
        </th>
        <th>Image</th>
        <th>Action</th>
    </tr>
    <tbody>
        @php $no = 1; @endphp @foreach ($books as $book)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $book->bookName }}</td>
            <td>{{ "Rp " . number_format($book->price, 2, ',', '.') }}</td>
            <td>{{ $book->description }}</td>
            <td>{{ $book->name }}</td>
            <td align="center">
                <img src="{{url('/images/'.$book->image)}}" alt="img" style="width:180px; height:100px;">
            </td>
            <td>
                <a href="book/generate-pdf/{{ $book->bookId }}" class="btn btn-outline-primary">Generate PDF</a>
                <a href="book/update/{{ $book->bookId }}" class="btn btn-outline-warning">Edit</a>
                <a href="book/delete/{{ $book->bookId }}" class="btn btn-outline-danger">Delete</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

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