<!DOCTYPE html>
<html>

<head>
    <title>Hi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
        @page {
            margin: 0;
            size: letter;
        }
    </style>
</head>

<body>
    <table class="table table-bordered">
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
            @php
            $no = 1;
            @endphp
            @foreach ($books as $book)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $book->bookName }}</td>
                <td>{{ $book->price }}</td>
                <td>{{ $book->description }}</td>
                <td>{{ $book->genreName }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @foreach($books as $book)
    <div style="text-align: center;">
        <img src="{{ public_path('/images/'.$book->image) }}" alt="img" style="width: 90%; height: 40%">
    </div>
    @endforeach
</body>

</html>