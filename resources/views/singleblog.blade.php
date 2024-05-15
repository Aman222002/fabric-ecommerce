@extends('layouts.app')
@section('title', 'Blog-Page')
@section('content')
{{-- {{$blogId}} --}}
<single-blog :data={{$blogId}}></single-blog>
@endsection