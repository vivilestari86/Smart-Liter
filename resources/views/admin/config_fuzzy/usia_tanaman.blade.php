@extends('admin.layouts.app')
@section('title', 'Konfigurasi Fuzzy - ' . ($parameter->name ?? 'Usia Tanaman'))

@section('content')
  @include('admin.config_fuzzy.form')
@endsection
