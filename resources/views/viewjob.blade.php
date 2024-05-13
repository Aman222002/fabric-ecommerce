@extends('layouts.app')
@section('title', 'View Job Page')
@section('content')
<view-job  :data="{{ ($jobid) }}" ></view-job>
@endsection