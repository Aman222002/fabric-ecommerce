@extends('layouts.app')
@section('title', 'Save Job Page')
@section('content')

<savejob-component :data="{{$savedJobs}}"></savejob-component>
@endsection