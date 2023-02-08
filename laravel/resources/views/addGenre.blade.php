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
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button class="w-100 btn btn-lg btn-danger mt-3" type="submit">Add Genre</button>
    </form>
</div>
@endsection