@extends('layouts.app')
@section('content')
{{-- {{$blogId}} --}}
<single-blog :data={{$blogId}}></single-blog>
@endsection