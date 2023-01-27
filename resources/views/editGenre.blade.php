@extends('master')
@section('title', 'Edit Genre')

@section('content')
<div class="container">
    @foreach ($genre as $g)
    <form action="/genre/update" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $g->id }}"> <br />
        <div class="form-floating">
            <input type="text" class="form-control rounded-top" name="name" id="name" required value="{{ $g->name }}"
                placeholder="Name">
            <label for="name">Genre Name</label>
        </div>
        <button class="w-100 btn btn-lg btn-danger mt-3" type="submit">Edit Genre</button>
    </form>
    @endforeach
</div>
@endsection