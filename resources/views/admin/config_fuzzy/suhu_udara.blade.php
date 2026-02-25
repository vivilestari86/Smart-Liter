@extends('admin.layouts.app')
@section('title', 'Konfigurasi Fuzzy - ' . ($parameter->name ?? 'Suhu Udara'))

@section('content')
  @include('admin.config_fuzzy.form')
@endsection
