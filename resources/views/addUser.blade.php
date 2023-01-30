@extends('master')
@section('title', 'Add User')

@section('content')
<div class="container">
    <form action="/user" method="post">
        @csrf

        <div class="form-floating">
            <input type="text" class="form-control rounded-top" name="name" id="name" required value="{{ old('name') }}"
                placeholder="Name">
            <label for="name">Name</label>
        </div>
        <div class="form-floating">
            <input type="text" class="form-control " name="email" id="email" required value="{{ old('email') }}"
                placeholder="10000">
            <label for="email">Email</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control rounded-bottom" name="password" id="password" required
                value="{{ old('password') }}" placeholder="password">
            <label for="password">password</label>
        </div>
        <div class="form-floating">
            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="role">
                <option selected disabled>--- SELECT ROLE ---</option>
                <option value="admin">Admin</option>
                <option value="guest">Guest</option>
            </select>
            <label for="floatingSelect">Role</label>
        </div>
        <button class="w-100 btn btn-lg btn-danger mt-3" type="submit">Add user</button>
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
    {{-- {{ logger($genres) }} --}}
</div>
@endsection