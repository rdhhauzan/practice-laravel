@extends('master') @section('title', 'Orders')

@section('content')
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
@if(count($orders) > 0)
<table class="table table-bordered table-hover" border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>User Email</th>
            <th>Book Name</th>
            <th>Price</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp @foreach ($orders as $order)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{$order->email}}</td>
            <td>{{ $order->bookName }}</td>
            <td>{{ "Rp " . number_format($order->bookPrice, 2, ',', '.') }}</td>
            <td>
                @if($order->Status == 'pending')
                <span class="badge bg-warning text-dark">Pending</span>
                @elseif($order->Status == 'delivered')
                <span class="badge bg-secondary">Delivered</span>
                @elseif($order->Status == 'canceled')
                <span class="badge bg-danger">Canceled</span>
                @elseif($order->Status == 'packaging')
                <span class="badge bg-info text-dark">Packaging</span>
                @elseif($order->Status == 'completed')
                <span class="badge bg-primary">Completed</span>
                @endif
            </td>
            <td>
                <a href="/order/edit/{{$order->userId}}/{{$order->bookId}}" class="btn btn-outline-warning">Edit
                    Order</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<nav aria-label="Page navigation example">
    <ul class="pagination d-flex justify-content-center">
        <li class="page-item {{ ($orders->currentPage() == 1) ? ' disabled' : '' }}">
            <a href="{{ $orders->url(1) }}" class="page-link">First</a>
        </li>
        <li class="page-item {{ ($orders->currentPage() == 1) ? ' disabled' : ''}}">
            <a href="{{ $orders->previousPageUrl() }}" class="page-link">Previous</a>
        </li>
        @for($i = 1; $i <= $orders->lastPage(); $i++)
            <li class="page-item {{ ($orders->currentPage() == $i) ? ' active' : '' }}">
                <a class="page-link" href="{{ $orders->url($i) }}">{{ $i }}</a>
            </li>
            @endfor
            <li class="page-item {{ ($orders->currentPage() == $orders->lastPage()) ? ' disabled' : '' }}">
                <a class="page-link" href="{{ $orders->nextPageUrl() }}">Next</a>
            </li>
            <li class="page-item {{ ($orders->currentPage() == $orders->lastPage()) ? ' disabled' : '' }}">
                <a class="page-link" href="{{ $orders->url($orders->lastPage()) }}">Last</a>
            </li>
    </ul>
</nav>
@else
<h3 class="mt-3 text-center">No Data Found</h3>
@endif
@endsection