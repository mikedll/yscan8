<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Some Videos</title>
    <link rel="stylesheet" type="text/css" href="/css/app.css"/>
    
  </head>
  <body>

    <div class="container">

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

          The source code of this webapp is <a href="https://github.com/mikedll/yscan8" target="_blank">here on <i class="fab fa-github" ></i> Github</a>.
          
        </div>
      </div>
      
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
      
      <form action="/videos" method='POST'>
        @csrf
        <br/>
        <div class="form-group">
          <input type="text" name="video" class="form-control" placeholder="New Video Link" />
        </div>
        
      </form>
      
      <div>
        <table class="table">
          <thead>
            <tr>
              <th>Views</th>
              <th>Likes</th>
              <th>Dislikes</th>
              <th>
                  Score
                <i class="fas fa-question-circle" title="Equation: (log(base10,views) * likes/dislikes)"></i>
              </th>
              <th>Video Title</th>
              <th>Owner</th>
              <th>Published</th>
            </tr>
          </thead>
            @foreach($videos as $video)
              <tr>
                <td>{{ General::brief_num($video->views, 1) }}</td>
                <td>{{ General::brief_num($video->likes, 1) }}</td>
                <td>{{ General::brief_num($video->dislikes, 1) }}</td>
                <td>{{ number_format($video->score, 2) }}</td>
                <td><a href="https://www.youtube.com/watch?v={!! $video->vid !!}" target="_blank">{{ $video->title }}</a></td>
                <td><a href="https://www.youtube.com/channel/{!! $video->channel_id !!}" target="_blank">{{ $video->owner }}</a></td>
                <td>{{ $video->published_at->format('M Y') }}</td>
              </tr>
            @endforeach
        </table>          
      </div>

      <div class="row justify-content-center">
            {{ $videos->links() }}
      </div>
      
    </div>

  </body>
</html>
