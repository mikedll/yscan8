<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Exception;
use Alaouy\Youtube\Facades\Youtube;
use App\Video;

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
        $videoId = null;        
        try {
            $videoId = Youtube::parseVidFromURL($request->input('video'));
        } catch(Exception $e) {
            if ($e->getMessage() === 'The supplied URL does not look like a Youtube URL') {
                $request->session()->flash('error', "It looks like you didn't enter a YouTube URL.");
                return redirect('/videos');
            }
            else
                throw $e;
        }

        $data['vid'] = $videoId;        
        $video = Youtube::getVideoInfo($data['vid']);
        
        // API call here...
        $apiResult = [
                      'title' => ("A video of " . $data['vid']),
                      'likes' => 50,
                      'dislikes' => 2,
                      'views' => 250000
                      ];
        
        $data['title'] = $video->snippet->title;
        $data['likes'] = $video->statistics->likeCount;
        $data['dislikes'] = $video->statistics->dislikeCount;
        $data['views'] = $video->statistics->viewCount;

        if($data['dislikes'] === 0) $data['dislikes'] = 1;
        if($data['likes'] === 0) $data['likes'] = 1;

        $newVideo = new Video($data);
        $newVideo->calculateScore();
        $newVideo->save();
        
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
