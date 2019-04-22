<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Video;
use App\Youtube as Youtube;

class VideosTest extends TestCase
{
    use RefreshDatabase;

    public function testCanShowVideo()
    {
        $video = new Video(['vid' => 'MpeaSNERwQA']);
        $video = $video->refreshStatistics();
        
        $response = $this->get('/videos/' . $video->id);
        $response
            ->assertStatus(200)
            ->assertSee('<video-summary v-bind:video="video"></video-summary>');
    }
    
    public function testCanCreateVideo()
    {
        $this->app->singleton(Youtube::class, function() {
            $ytServiceMock = $this->createMock(Youtube::class);
            $ytServiceMock->expects($this->any())
                ->method('parseVidFromURL')
                ->will($this->returnValue('MpeaSNERwQA'));
            
            return $ytServiceMock;
        });
        
        $response = $this->json('POST', '/videos', [
            'video' => 'https://www.youtube.com/watch?v=MpeaSNERwQA'
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'vid' => 'MpeaSNERwQA',
                'id' => 2
            ]);
    }

    public function testFailsForNonYoutubeVideos() {
        $response = $this->json('POST', '/videos', [
            'video' => 'https://www.google.com/somelink'
        ]);

        $response
            ->assertStatus(422);
        
    }
    
    public function testDoesNotDuplicateVideos()
    {
        $response = $this->json('POST', '/videos', [
            'video' => 'https://www.youtube.com/watch?v=MpeaSNERwQA'
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'id' => 3
            ]);
        
        $response = $this->json('POST', '/videos', [
            'video' => 'https://www.youtube.com/watch?v=MpeaSNERwQA'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'id' => 3
            ]);
    }
    
}
