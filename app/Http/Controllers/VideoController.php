<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
                                    'title' => 'required'
                                    ]);

        $matched = preg_match('/http(s)?:\/\/www\.youtube\.com\/watch\?v=([A-Za-z0-9]{11})/',
                              'https://www.youtube.com/watch?v=Vyt5uAFVCOc',
                              $matches);

      
        if($matched === 0) {
            return redirect('/videos');
        }

        $data['vid'] = $matches[2];
        
        // API call here...
        $apiResult = [
                      'title' => ("A video of " . $data['vid']),
                      'likes' => 50,
                      'dislikes' => 2,
                      'views' => 250000
                      ];
        
        $data['title'] = $apiResult['title'];
        $data['likes'] = $apiResult['likes'];
        $data['dislikes'] = $apiResult['dislikes'];
        $data['views'] = $apiResult['views'];

        if($data['dislikes'] === 0) $data['dislikes'] = 1;
        if($data['likes'] === 0) $data['likes'] = 1;
        
        $data['score'] = log($data['views'], 10) * ($data['likes'] / $data['dislikes']);
        
        Log::debug("Something. A score is: " . $data['score']);
        
        $video = tap(new App\Video($data))->save();
        
        return redirect('/videos');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

}
