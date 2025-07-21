@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Ubah Password</h4>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Password Lama</label>
            <input type="password" name="current_password" class="form-control" required>
            @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label>Password Baru</label>
            <input type="password" name="password" class="form-control" required>
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label>Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-danger w-100">
            <i class="fas fa-key"></i> Ubah Password
        </button>
    </form>
</div>
@endsection