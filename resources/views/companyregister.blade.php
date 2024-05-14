@extends('layouts.app')
@section('title', 'Company-Register')
@section('content')
<company-component :data={{json_encode($data)}}></company-component>
@endsection