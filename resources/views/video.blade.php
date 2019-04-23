@extends('layouts.app')

@section('head')
  <script>
   __bootstrap = {!! $video->toJson() !!};
  </script>
@endsection
