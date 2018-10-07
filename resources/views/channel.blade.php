@extends('layouts.app')

@section('head')
  <script>
   __bootstrap = {!! $videos->toJson() !!};
  </script>

@endsection

@section('content')

  <channel-display v-bind:videos="videos"></channel-display>

@endsection
