@extends('layouts.app')

@section('head')
  <script>
   __bootstrap = {!! $video->toJson() !!};
  </script>
@endsection

@section('content')
  <video-summary v-bind:video="video"></video-summary>
@endsection
