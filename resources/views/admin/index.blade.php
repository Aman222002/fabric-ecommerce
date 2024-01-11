@extends('layouts.app')
@section('content')
        <dashboard-component :users="{!! $users !!}"></dashboard-component>
@endsection