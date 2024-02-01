@extends('layouts.app')
@section('content')
<!-- {{$jobApplications}} -->
<jobapply-component :data="{{$jobApplications}}"></jobapply-component>
@endsection