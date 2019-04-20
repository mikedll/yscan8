@extends('layouts.app')

@section('head')
  <script>
   __bootstrap = {!! $videos->toJson() !!};
  </script>
@endsection

@section('content')
  
  <div class="row" >
    <div class="col" >
      <h3>YouTube Video Fervor Calculator</h3>    

      <p>
          This website calculates something called "fervor" of a
          YouTube video. Fervor is arbitrarily defined here as a
          notion of how good a YouTube video is, independent of how
          popular it may be. Some videos may be good videos even
          though hardly anyone has heard about them.
      </p>
      <p>
          This app does this by reducing the importance of a video's
          view count and escalating the importance of its likes and
          dislikes.        
      </p>
    </div>
  </div>

  <div class="row" >
    <div class="col" >
          @if(session()->has('message'))
            <div class="alert alert-info">
              {!! session('message') !!}
            </div>
          @endif

          @if(session()->has('error'))
            <div class="alert alert-danger">
              {!! session('error') !!}
            </div>
          @endif
          
    </div>
  </div>

  <video-form v-bind:location="location" v-bind:$="jQuery"></video-form>
  <video-list v-bind:results="results"></video-list>

@endsection
