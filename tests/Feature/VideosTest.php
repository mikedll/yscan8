<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideosTest extends TestCase
{
    use RefreshDatabase;
    
    public function testCanCreateVideo()
    {
        $response = $this->json('POST', '/videos', [
            'video' => 'https://www.youtube.com/watch?v=AEF9ak24z8s'
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'id' => 1
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
            'video' => 'https://www.youtube.com/watch?v=AEF9ak24z8s'
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'id' => 2
            ]);
        
        $response = $this->json('POST', '/videos', [
            'video' => 'https://www.youtube.com/watch?v=AEF9ak24z8s'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'id' => 2
            ]);
    }
    
}
