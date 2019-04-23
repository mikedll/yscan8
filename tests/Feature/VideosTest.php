<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Video;
use App\Youtube as Youtube;

class VideosTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->withoutExceptionHandling();        
    }

    private function stubYt()
    {
        $this->app->singleton(Youtube::class, function() {
            $ytServiceMock = $this->createMock(Youtube::class);
            $ytServiceMock->expects($this->any())
                ->method('parseVidFromURL')
                ->will($this->returnValue('MpeaSNERwQA'));

            $mockVid = new \stdClass();
            $mockVid->snippet = new \stdClass();
            $mockVid->snippet->title = "Let’s play a game: what is the deadly bug here?";
            $mockVid->snippet->channelTitle = "LiveOverflow";
            $mockVid->snippet->channelId = "UClcE-kVhqyiHCcjYwcpfj9w";
            $mockVid->snippet->publishedAt = "2018-01-27T02:47:18.000Z";
            $mockVid->statistics = new \stdClass();
            $mockVid->statistics->likeCount = "7841";
            $mockVid->statistics->dislikeCount = "120";
            $mockVid->statistics->viewCount = "258558";
            
            $ytServiceMock->expects($this->any())
                ->method('getVideoInfo')
                ->will($this->returnValue($mockVid));
            
            return $ytServiceMock;
        });        
    }
    
    public function testCanShowVideo()
    {
        $this->stubYt();
        $video = new Video(['vid' => 'MpeaSNERwQA']);
        $video = $video->refreshStatistics();
        
        $createdId = Video::max('id');
        $response = $this->get('/videos/' . $video->id);
        $response
            ->assertStatus(200)
            ->assertSee('__bootstrap = {"id":' . $createdId);
    }
    
    public function testCanCreateVideo()
    {        
        $this->stubYt();
        $response = $this->json('POST', '/videos', [
            'video' => 'https://www.youtube.com/watch?v=MpeaSNERwQA'
        ]);

        $createdId = Video::max('id');
        $response
            ->assertStatus(201)
            ->assertJson([
                'vid' => 'MpeaSNERwQA',
                'id' => $createdId
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
        $this->stubYt();
        $response = $this->json('POST', '/videos', [
            'video' => 'https://www.youtube.com/watch?v=MpeaSNERwQA'
        ]);

        $createdId = Video::max('id');
        
        $response
            ->assertStatus(201)
            ->assertJson([
                'id' => $createdId
            ]);
        
        
        $response = $this->json('POST', '/videos', [
            'video' => 'https://www.youtube.com/watch?v=MpeaSNERwQA'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'id' => $createdId
            ]);
    }
    
}
