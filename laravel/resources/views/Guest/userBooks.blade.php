@extends('Guest\GuestMaster') @section('title', 'User Books')

@section('content')
<h5>Your Total Books : {{count($countBooks)}} Books</h5>

@if(count($books) > 0)
<h5>Total Spend : {{$countPrices}}</h5>
<table class="table table-bordered table-hover" border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Book Name</th>
            <th>Price</th>
            <th>Description</th>
            <th>Image</th>
            <th>Genre</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach ($books as $book)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $book->bookName }}</td>
            <td>{{ "Rp " . number_format($book->bookPrice, 2, ',', '.') }}</td>
            <td>{{ $book->bookDescription }}</td>
            <td align="center">
                <img src="{{url('/images/'.$book->image)}}" alt="img" style="width:180px; height:100px;">
            </td>
            <td>{{ $book->genreName }}</td>
            <td>@if($book->Status == 'pending')
                <span class="badge bg-warning text-dark">Pending</span>
                @elseif($book->Status == 'delivered')
                <span class="badge bg-secondary">Delivered</span>
                @elseif($book->Status == 'canceled')
                <span class="badge bg-danger">Canceled</span>
                @elseif($book->Status == 'packaging')
                <span class="badge bg-info text-dark">Packaging</span>
                @elseif($book->Status == 'completed')
                <span class="badge bg-primary">Completed</span>
                @endif
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

<body>
    <div class="container">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>