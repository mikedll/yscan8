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

        <div>
          <table class="table">
            @foreach($videos as $video)
              <tr>
                <td><a href="https://www.youtube.com/watch?v={!! $video->vid !!}" target="_blank">{!! $video->title !!}</a></td>
              </tr>
            @endforeach
          </table>

          <div>
            <form action="/videos" method='POST'>
              @csrf
              https://www.youtube.com/watch?v=ud-F0QM2z5E
              <br/>
              <input type="text" name="video" placeholder="New Video Link" />
            </form>
          </div>
          
        </div>
      </div>

    </body>
</html>
