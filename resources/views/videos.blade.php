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

        <div>
          <table class="table">
            @foreach(array_keys($videos) as $vid)
              <tr>
                <td><a href="https://www.youtube.com/watch?v={{ $vid }}" target="_blank">{{ $videos[$vid] }}</a></td>
              </tr>
            @endforeach
          </table>
        </div>
      </div>

    </body>
</html>
