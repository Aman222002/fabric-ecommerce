@extends('layouts.default')
@section('title', 'BuyPlan-Page')
@section('content')
<buy-component :data={{$plan}}></buy-component>
@endsection