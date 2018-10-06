<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Some Videos</title>
        <link rel="stylesheet" type="text/css" href="/css/app.css"/>
        
    </head>
    <body>

      <div class="container" >
        
        <h3>This is an app supposedly about YouTube video popularity.</h3>
        
        
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
              </tr>
            </thead>
            @foreach($videos as $video)
              <tr>
                <td>{!! General::brief_num($video->views, 1) !!}</td>
                <td>{!! General::brief_num($video->likes, 1) !!}</td>
                <td>{!! General::brief_num($video->dislikes, 1) !!}</td>
                <td>{!! number_format($video->score, 2) !!}</td>
                <td><a href="https://www.youtube.com/watch?v={!! $video->vid !!}" target="_blank">{!! $video->title !!}</a></td>
              </tr>
            @endforeach
          </table>
          
        </div>
      </div>

    </body>
</html>
