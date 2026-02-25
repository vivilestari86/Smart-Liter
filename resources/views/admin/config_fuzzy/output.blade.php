@extends('admin.layouts.app')
@section('title', 'Konfigurasi Fuzzy - ' . ($parameter->name ?? 'Output'))

@section('content')
  @include('admin.config_fuzzy.form')
@endsection
