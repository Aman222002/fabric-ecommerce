@extends('layouts.app')
@section('title', 'Job-Apply')
@section('content')

<jobapply-component :data="{{$jobApplications}}" :save="{{$savedJobs}}"></jobapply-component>
@endsection
