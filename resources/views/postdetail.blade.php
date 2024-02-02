@extends('layouts.app')
@section('content')
<job-detail :data="{{$job}}" ></job-detail>
@endsection