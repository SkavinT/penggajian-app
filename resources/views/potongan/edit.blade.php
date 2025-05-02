@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Potongan</h1>
    <form action="{{ route('potongan.update', $potongan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama_potongan">Nama Potongan</label>
            <input type="text" name="nama_potongan" id="nama_potongan" class="form-control" value="{{ $potongan->nama_potongan }}" required>
        </div>

        <div class="form-group">
            <label for="jumlah_potongan">Jumlah Potongan</label>
            <input type="number" name="jumlah_potongan" id="jumlah_potongan" class="form-control" value="{{ $potongan->jumlah_potongan }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('potongan.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection