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
            'link' => 'https://www.youtube.com/watch?v=AEF9ak24z8s'
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'id' => 1
            ]);
    }

    public function testDoesNotDuplicateVideos()
    {
        $response = $this->json('POST', '/videos', [
            'link' => 'https://www.youtube.com/watch?v=AEF9ak24z8s'
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'id' => 1
            ]);
        
        $response = $this->json('POST', '/videos', [
            'link' => 'https://www.youtube.com/watch?v=AEF9ak24z8s'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'id' => 1
            ]);
    }
    
}
