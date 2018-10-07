@extends('layouts.app')

@section('content')

  <div class="row">

    <div class="col" >

      <h3>{{ $video->title }} <a href="https://www.youtube.com/watch?v={!! $video->vid !!}" target="_blank"><i class="fab fa-youtube" title="Visit video" ></i></a></h3>

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

      <br/>

      <strong>Video Owner</strong>: <a href="{{ route('channels.show', ['channel' => $video->channel_id]) }}">{{ $video->owner }}</a>
      <a href="https://www.youtube.com/channel/{!! $video->channel_id !!}" target="_blank"><i class="fab fa-youtube" title="Visit channel"  ></i></a>
      <br/>
      <br/>

      <strong>Views</strong>: {{ number_format($video->views) }}
      <br/>
      <strong>Likes</strong>: {{ number_format($video->likes) }}
      <br/>
      <strong>Dislikes</strong>: {{ number_format($video->dislikes) }}
      <br/>
      <strong>Like-to-dislike ratio</strong>: {{ number_format($video->likes / $video->dislikes, 2) }}
      <br/>
      <strong>Calculation</strong>: log_10({{ number_format($video->views) }}) * {{ number_format($video->likes / $video->dislikes, 2) }}
      <a target="_blank" href="http://www.google.com/search?q={{ urlencode('log_10(' . $video->views . ') * (' . $video->likes . ' / ' . $video->dislikes . ')') }}">See calculation on <i class="fab fa-google" ></i> Google</a>.
      <br/>
      <strong>Score</strong>: {{ $video->score }}
      

      <br/>
      <br/>
      <a href="{{ route('root') }}">Video List</a>
      
    </div>
  </div>    
@endsection
