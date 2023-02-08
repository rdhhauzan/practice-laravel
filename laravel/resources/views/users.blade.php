@extends('master') @section('title', 'User List :') @section('content')
{{-- <a href="/users/generate-pdf">Download PDF</a>
<a href="/users/generate-excel">Download Excel</a> --}}
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="my-3">
    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Add User
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Book</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/user" method="post">
                    @csrf

                    <div class="form-floating my-3">
                        <input type="text" class="form-control rounded-top" name="name" id="name" required
                            value="{{ old('name') }}" placeholder="Name">
                        <label for="name">Name</label>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating my-3">
                        <input type="text" class="form-control " name="email" id="email" required
                            value="{{ old('email') }}" placeholder="10000">
                        <label for="email">Email</label>
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating my-3">
                        <input type="password" class="form-control rounded-bottom" name="password" id="password"
                            required value="{{ old('password') }}" placeholder="password">
                        <label for="password">password</label>
                        @error('password')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-floating my-3">
                        <select class="form-select" id="floatingSelect" aria-label="Floating label select example"
                            name="role">
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
        </div>
    </div>
</div>

@if(count($users) > 0)
<table class="table table-bordered table-hover" border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp @foreach ($users as $user)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>
            <td>
                <a href="user/delete/{{ $user->id }}" class="btn btn-outline-danger">Delete</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<h3 class="mt-3 text-center">No Data Found!</h3>
@endif
@endsection