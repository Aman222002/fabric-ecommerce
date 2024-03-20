@extends('layouts.app')
@section('content')
<view-job  :data="{{ json_encode($jobid) }}" ></view-job>
@endsection