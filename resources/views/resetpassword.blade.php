@extends('layouts.app')
@section('content')
<resetpassword-component :data="{{json_encode($data) }}"></resetpassword-component>
@endsection