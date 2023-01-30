@extends('master')
@section('title', 'Edit Book')

@section('content')
<div class="container">
    @foreach ($book as $p)
    <form action="/book/update" method="post">
        @csrf

        <input type="hidden" name="id" value="{{ $p->id }}"> <br />
        <div class="form-floating">
            <input type="text" class="form-control rounded-top" name="name" id="name" required value="{{ $p->name }}"
                placeholder="Name">
            <label for="name">Book Name</label>
        </div>
        <div class="form-floating">
            <input type="number" class="form-control " name="price" id="price" required value="{{ $p->price }}"
                placeholder="10000">
            <label for="price">Book Price</label>
        </div>
        <div class="form-floating">
            <input type="text" class="form-control rounded-bottom" name="description" id="description" required
                value="{{ $p->description }}" placeholder="description">
            <label for="description">Description</label>
        </div>
        <div class="form-floating">
            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="genreId">
                <option selected disabled>--- SELECT GENRE ---</option>
                @foreach ($genres as $genre)
                <option value="{{ $genre->id }}" @if (old('genreId')==$genre->id || $genre->id == $p->genreId) selected
                    @endif>
                    {{ $genre->name }}</option>
                @endforeach
            </select>
            <label for="floatingSelect">Genre</label>
        </div>

        <button class="w-100 btn btn-lg btn-danger mt-3" type="submit">Add Book</button>
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
    @endforeach
</div>
@endsection