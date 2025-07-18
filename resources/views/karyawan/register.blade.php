@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-danger text-white text-center">
                    <h4 class="mb-0"><i class="bi bi-person-plus"></i> Register Karyawan</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('karyawan.register.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label"><i class="bi bi-person"></i> Nama</label>
                            <input type="text" name="name" class="form-control" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><i class="bi bi-envelope"></i> Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><i class="bi bi-lock"></i> Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><i class="bi bi-lock-fill"></i> Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-person-plus"></i> Register
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection