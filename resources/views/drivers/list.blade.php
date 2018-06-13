@extends('layouts.master')

@section('title', 'Dashboard')

@section('custom_css')
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css')}}">
@endsection

@section('content')

<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-account"></i>
    </span>
    Data Pengemudi
  </h3>
  
</div>


@endsection

@section('custom_js')

@endsection
