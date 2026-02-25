@extends('admin.layouts.app')

@section('title', 'Tambah Jurnal')

@section('content')
<div class="journal-form-page">
    <div class="journal-form-header">
        <h1>Tambah Jurnal</h1>
        <p>Lengkapi detail jurnal yang akan ditampilkan di halaman user.</p>
    </div>

    <form class="journal-form-card" action="{{ route('admin.jurnal.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="journal-form-grid">
            <div class="journal-form-main">
                @include('admin.jurnal._form')
            </div>
        </div>

        <div class="journal-form-actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.jurnal.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .journal-form-page {
        max-width: 980px;
        margin: 0 auto;
    }

    .journal-form-header {
        margin-bottom: 18px;
    }

    .journal-form-header h1 {
        margin: 0 0 6px;
        font-size: 24px;
        font-weight: 800;
        color: #0b2c12;
    }

    .journal-form-header p {
        margin: 0;
        color: #466154;
        font-weight: 600;
        font-size: 14px;
    }

    .journal-form-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid rgba(0,0,0,.08);
        box-shadow: 0 12px 24px rgba(0,0,0,.06);
    }

    .form-group,
    .mb-3 {
        margin-bottom: 14px;
    }

    label {
        display: block;
        margin-bottom: 6px;
        font-weight: 700;
        color: #1f3b2a;
        font-size: 13px;
    }

    .form-control,
    .form-select,
    input[type="file"] {
        width: 100%;
        border-radius: 12px;
        border: 1px solid rgba(0,0,0,.12);
        padding: 10px 12px;
        font-size: 14px;
        background: #fff;
        transition: border-color .15s ease, box-shadow .15s ease;
    }

    .form-control:focus,
    .form-select:focus {
        outline: none;
        border-color: #3a8f58;
        box-shadow: 0 0 0 3px rgba(58,143,88,.15);
    }

    .journal-form-actions {
        display: flex;
        gap: 10px;
        margin-top: 18px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 18px;
        border-radius: 12px;
        font-weight: 800;
        border: 0;
        cursor: pointer;
        text-decoration: none;
        font-size: 13px;
    }

    .btn-primary {
        background: #1e9a60;
        color: #fff;
        box-shadow: 0 10px 18px rgba(30,154,96,.18);
    }

    .btn-secondary {
        background: #e9f0ec;
        color: #1f3b2a;
    }

    .text-danger {
        color: #c0392b;
        font-size: 12px;
        margin-top: 4px;
    }

    @media (max-width: 720px) {
        .journal-form-page {
            padding: 0 4px;
        }

        .journal-form-actions {
            flex-direction: column;
        }
    }
</style>
@endpush
