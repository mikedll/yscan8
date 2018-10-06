<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Alaouy\Youtube\Facades\Youtube;
use Illuminate\Support\Facades\Log;

class Video extends Model
{
    protected $fillable = [
        'vid',        
        'title',
        'likes',
        'dislikes',
        'views',
        'score'
    ];

    public function refreshStatistics()
    {
        $videoInfo = Youtube::getVideoInfo($this->vid);
        if($videoInfo === false) {
            return;
        }
        $this->title = $videoInfo->snippet->title;
        $this->likes = $videoInfo->statistics->likeCount;
        $this->dislikes = $videoInfo->statistics->dislikeCount;
        $this->views = $videoInfo->statistics->viewCount;
        $this->calculateScore();
        return $this->save();
    }
    public function calculateScore()
    {
        if($this->dislikes === 0) $this->dislikes = 1;
        if($this->likes === 0) $this->likes = 1;

        $this->score = log($this->views, 10) * ($this->likes / $this->dislikes);
    }
}
