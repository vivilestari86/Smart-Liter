@extends('admin.layouts.app')
@section('title', 'Konfigurasi Fuzzy - ' . ($parameter->name ?? 'Kelembapan Tanah'))

@section('content')
  @include('admin.config_fuzzy.form')
@endsection
