@extends('layouts.app')
@section('content')

<jobapply-component :data="{{$jobApplications}}"></jobapply-component>
@endsection