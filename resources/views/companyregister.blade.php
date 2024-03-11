@extends('layouts.app')
@section('content')
<company-component :data={{json_encode($data)}}></company-component>
@endsection