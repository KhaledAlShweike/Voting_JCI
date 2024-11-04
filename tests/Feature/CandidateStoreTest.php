<?php
namespace Tests\Feature;

use App\Models\Categories;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\Category;

class CandidateStoreTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_candidate_with_images_and_video()
    {
        // Create a category for the candidate
        $category = Categories::factory()->create();

        // Mock images and video files
        $images = [
            UploadedFile::fake()->image('image1.jpg', 600, 600),
            UploadedFile::fake()->image('image2.jpg', 600, 600),
        ];
        $video = UploadedFile::fake()->create('video.mp4', 1024, 'video/mp4');

        // Prepare the data for the candidate
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'position' => 'Software Engineer',
            'last_position' => 'Junior Developer',
            'jci_career' => 'JCI Member since 2020',
            'category_id' => $category->id,
            'images' => $images,
            'video' => $video,
        ];

        // Send a POST request to the store endpoint
        $response = $this->postJson('/api/candidates', $data);

        // Assert the response status and structure
        $response->assertStatus(201)
            ->assertJson(['success' => 'Candidate profile created successfully']);

        // Assert database entries
        $this->assertDatabaseHas('candidates', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'position' => 'Software Engineer',
        ]);

        $this->assertDatabaseCount('candidate_images', count($images));
        $this->assertDatabaseCount('candidate_videos', 1);
    }

    /** @test */
    public function it_fails_when_required_fields_are_missing()
    {
        // Attempt to create a candidate with missing required fields
        $response = $this->postJson('/api/candidates', [
            // Missing all required fields
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'first_name', 'last_name', 'position', 'last_position', 'jci_career', 'category_id'
        ]);
    }

    /** @test */
    public function it_fails_when_video_is_over_the_size_limit()
    {
        // Create a category for the candidate
        $category = Categories::factory()->create();

        // Mock an oversized video file
        $oversizedVideo = UploadedFile::fake()->create('video.mp4', 15000, 'video/mp4'); // 15 MB

        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'position' => 'Software Engineer',
            'last_position' => 'Junior Developer',
            'jci_career' => 'JCI Member since 2020',
            'category_id' => $category->id,
            'video' => $oversizedVideo,
        ];

        // Send a POST request to the store endpoint
        $response = $this->postJson('/api/candidates', $data);

        // Assert that it fails due to video size
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['video']);
    }
}
