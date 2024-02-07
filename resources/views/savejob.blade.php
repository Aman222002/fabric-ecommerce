@extends('layouts.app')
@section('content')

<savejob-component :data="{{$savedJobs}}"></savejob-component>
@endsection