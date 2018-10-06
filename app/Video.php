<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public function calculateScore()
    {
        $this->score = log($this->views, 10) * ($this->likes / $this->dislikes);
    }
}
