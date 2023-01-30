@extends('master')
@section('title', 'Add Genre')

@section('content')
<div class="container">
    <form action="/genre" method="post">
        @csrf
        <div class="form-floating">
            <input type="text" class="form-control rounded-top" name="name" id="name" required value="{{ old('name') }}"
                placeholder="Name">
            <label for="name">Genre Name</label>
        </div>
        <button class="w-100 btn btn-lg btn-danger mt-3" type="submit">Add Genre</button>
    </form>
    @if ($errors->any())
    <div class="alert alert-danger mt-3">
        <ul class="mt-3">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
@endsection