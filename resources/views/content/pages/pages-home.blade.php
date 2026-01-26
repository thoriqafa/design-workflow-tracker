@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Home')

@section('content')
  <h4>Home Page {{ auth()->user()->role . ' + ' . auth()->check() }}</h4>
  <p>For more layout options refer <a
      href="{{ config('variables.documentation') ? config('variables.documentation') . '/laravel-introduction.html' : '#' }}"
      target="_blank" rel="noopener noreferrer">documentation</a>.</p>
@endsection
