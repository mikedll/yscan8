@extends('layouts.app')

@section('head')
  <script>
   __bootstrap = {!! $videos->toJson() !!};
  </script>
@endsection
