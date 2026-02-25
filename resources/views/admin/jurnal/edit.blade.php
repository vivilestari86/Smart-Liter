@extends('admin.layouts.app')

@section('title', 'Edit Jurnal')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Jurnal</h1>
    <form action="{{ route('admin.jurnal.update', $journal) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.jurnal._form')
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.jurnal.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
