<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Video;

class ChannelController extends Controller
{
    public function show($channel_id)
    {
        $videos = Video::where('channel_id', $channel_id)->orderBy('score', 'desc')->get();
        return view('channel', ['videos' => $videos]);
    }
       
}
