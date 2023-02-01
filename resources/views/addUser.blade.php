@extends('master')
@section('title', 'Add User')

@section('content')
<div class="container">
    <form action="/user" method="post">
        @csrf

        <div class="form-floating my-3">
            <input type="text" class="form-control rounded-top" name="name" id="name" required value="{{ old('name') }}"
                placeholder="Name">
            <label for="name">Name</label>
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-floating my-3">
            <input type="text" class="form-control " name="email" id="email" required value="{{ old('email') }}"
                placeholder="10000">
            <label for="email">Email</label>
            @error('email')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-floating my-3">
            <input type="password" class="form-control rounded-bottom" name="password" id="password" required
                value="{{ old('password') }}" placeholder="password">
            <label for="password">password</label>
            @error('password')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-floating my-3">
            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="role">
                <option selected disabled>--- SELECT ROLE ---</option>
                <option value="admin">Admin</option>
                <option value="guest">Guest</option>
            </select>
            <label for="floatingSelect">Role</label>
            @error('role')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button class="w-100 btn btn-lg btn-danger mt-3" type="submit">Add user</button>
    </form>
</div>
@endsection