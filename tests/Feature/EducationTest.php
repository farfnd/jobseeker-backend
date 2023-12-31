<?php

namespace Tests\Feature;

use App\Models\Candidate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Education;
use Illuminate\Database\Eloquent\Model;

class EducationTest extends TestCase
{
    use RefreshDatabase;

    protected Model $user;

    protected string $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = Candidate::factory()->create();
        $this->token = $this->user->createToken('testToken')->plainTextToken;
    }

    public function test_index()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/educations');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'candidate_id',
                        'institution_name',
                        'major',
                        'start_year',
                        'end_year',
                        'until_now',
                        'gpa',
                        'flag',
                        "created_at",
                        "updated_at",
                        "deleted_at"
                    ],
                ],
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Education data retrieved successfully.',
            ]);
    }

    public function test_store()
    {
        $educationData = [
            'institution_name' => 'Example University',
            'major' => 'Computer Science',
            'start_year' => 2015,
            'end_year' => 2019,
            'until_now' => false,
            'gpa' => 3.5,
            'flag' => 'flag1',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/educations', $educationData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'candidate_id',
                    'institution_name',
                    'major',
                    'start_year',
                    'end_year',
                    'until_now',
                    'gpa',
                    'flag',
                    "created_at",
                    "updated_at"
                ],
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Education data created successfully.',
            ]);

        $this->assertDatabaseHas('education', $educationData);
        $this->assertDatabaseHas('candidates', [
            'id' => $this->user->id,
            'last_educ' => Education::first()->id,
        ]);
    }

    public function test_show()
    {
        $education = Education::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson("/api/educations/{$education->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'candidate_id',
                    'institution_name',
                    'major',
                    'start_year',
                    'end_year',
                    'until_now',
                    'gpa',
                    'flag',
                    "created_at",
                    "updated_at",
                    "deleted_at"
                ],
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Education data retrieved successfully.',
            ]);
    }

    public function test_update()
    {
        $education = Education::factory()->create();

        $updatedEducationData = [
            'institution_name' => 'Updated University',
            'major' => 'Updated Major',
            'gpa' => 3.88,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->putJson("/api/educations/{$education->id}", $updatedEducationData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'candidate_id',
                    'institution_name',
                    'major',
                    'start_year',
                    'end_year',
                    'until_now',
                    'gpa',
                    'flag',
                    "created_at",
                    "updated_at",
                    "deleted_at"
                ],
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Education data updated successfully.',
            ]);
    }

    public function test_delete()
    {
        $education = Education::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson("/api/educations/{$education->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Education data deleted successfully.',
            ]);

        $this->assertSoftDeleted('education', [
            'id' => $education->id,
        ]);
    }

    public function test_delete_and_update_last_educ()
    {
        $education = Education::factory()->create([
            'candidate_id' => $this->user->id,
        ]);
        $this->user->update(['last_educ' => $education->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson("/api/educations/{$education->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Education data deleted successfully.',
            ]);

        $this->assertSoftDeleted('education', [
            'id' => $education->id,
        ]);
        $this->assertDatabaseHas('candidates', [
            'id' => $this->user->id,
            'last_educ' => null,
        ]);
    }
}
