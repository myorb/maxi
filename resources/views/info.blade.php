@extends('welcome')

@section('title', 'Page Title')

@section('sidebar')
    @parent

    {{ $slot }}
@endsection

@section('content')

@endsection