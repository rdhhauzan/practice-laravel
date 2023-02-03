@extends('master')
@section('title', 'Edit Order')

@section('content')
<div class="container">
    @foreach($userbook as $u)
    <form action="/order/update" method="POST">
        @csrf
        <input type="hidden" name="userId" value="{{$u->userId}}">
        <input type="hidden" name="bookId" value="{{$u->bookId}}">

        <div class="form-floating">
            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="status">
                <option selected disabled>--- SELECT STATUS ---</option>
                <option value="pending" @if ($u->status == 'pending') selected
                    @endif>
                    Pending</option>
                <option value="delivered" @if ($u->status == 'delivered') selected
                    @endif>
                    Delivered</option>
                <option value="canceled" @if ($u->status == 'canceled') selected
                    @endif>
                    Canceled</option>
                <option value="packaging" @if ($u->status == 'packaging') selected
                    @endif>
                    Packaging</option>
                <option value="completed" @if ($u->status == 'completed') selected
                    @endif>
                    Completed</option>
            </select>
            <label for="floatingSelect">Status</label>
            @error('status')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button class="w-100 btn btn-lg btn-danger mt-3" type="submit">Edit Order</button>
    </form>
    @endforeach
</div>
@endsection