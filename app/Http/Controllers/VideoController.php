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
        $videos = Video::orderBy('score', 'desc')->paginate(12);
        return view('videos', ['videos' => $videos]);
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

        $video = Video::where('vid', '=', $videoId)->first();
        if($video !== null) {
            $request->session()->flash('message', 'Video is already in the database. Refreshed its statistics.');
        } else {
            $video = new Video(['vid' => $videoId]);
        }

        $video = $video->refreshStatistics();

        if($video === null) {
            $request->session()->flash('error', 'Unable to save video.');
        }
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
