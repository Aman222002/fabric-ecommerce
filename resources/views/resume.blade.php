@extends('layouts.app')
@section('title', 'Resume Page')
@section('content')
<resume-component></resume-component>
@endsection
@section('scripts')
@parent
<script
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize"
    async defer></script>
<script src="/js/mapInput.js"></script>
@stop