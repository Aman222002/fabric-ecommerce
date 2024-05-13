@extends('layouts.app')
@section('title', 'Job Apply')
@section('content')

<jobapply-component :data="{{$jobApplications}}"></jobapply-component>
@endsection