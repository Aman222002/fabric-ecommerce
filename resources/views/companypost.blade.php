
@extends('layouts.app')
@section('title', 'Find-Job')
@section('content')
    @if($data)
        <company-post :data="{{ json_encode($data) }}"></company-post>
    @else
        <company-post></company-post>
    @endif
  
@endsection