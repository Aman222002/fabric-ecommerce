@extends('layouts.app')
@section('title', 'Login-Page')
@section('content')
<login-component   :email="{{ isset($email) ? json_encode($email) : 'null' }}"
    :password="{{ isset($password) ? json_encode($password) : 'null' }}"></login-component>
@endsection