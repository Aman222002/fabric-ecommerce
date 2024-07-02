@extends('layouts.app')
@section('title', 'Company-Login-Page')
@section('content')
<job-component :email="{{ isset($email) ? json_encode($email) : 'null' }}"
    :password="{{ isset($password) ? json_encode($password) : 'null' }}"></job-component>
@endsection
