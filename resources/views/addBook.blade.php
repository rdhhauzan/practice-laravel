@extends('master')
@section('title', 'Add Book')

@section('content')
<div class="container">
    <form action="/book" method="post">
        @csrf

        <div class="form-floating">
            <input type="text" class="form-control rounded-top" name="name" id="name" required value="{{ old('name') }}"
                placeholder="Name">
            <label for="name">Book Name</label>
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-floating">
            <input type="number" class="form-control " name="price" id="price" required value="{{ old('price') }}"
                placeholder="10000">
            <label for="price">Book Price</label>
            @error('price')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-floating">
            <input type="text" class="form-control rounded-bottom" name="description" id="description" required
                value="{{ old('description') }}" placeholder="description">
            <label for="description">Description</label>
            @error('description')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-floating">
            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="genreId">
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

        <button class="w-100 btn btn-lg btn-danger mt-3" type="submit">Add Book</button>
        @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul class="mt-3">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </form>
</div>
@endsection