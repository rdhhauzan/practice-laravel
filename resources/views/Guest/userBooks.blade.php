@extends('Guest\GuestMaster') @section('title', 'User Books')

@section('content')
<h5>Your Total Books : {{count($books)}} Books</h5>

@php $sum = 0 @endphp
@foreach($books as $book)
@php
$sum += $book->bookPrice
@endphp
@endforeach
<h5>Total Spend : {{$sum}}</h5>
<table class="table table-bordered table-hover" border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Book Name</th>
            <th>Price</th>
            <th>Description</th>
            <th>Genre</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp @foreach ($books as $book)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $book->bookName }}</td>
            <td>{{ $book->bookPrice }}</td>
            <td>{{ $book->bookDescription }}</td>
            <td>{{ $book->genreName }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection

<body>
    <div class="container">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>