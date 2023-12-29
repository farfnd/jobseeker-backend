<?php

namespace Tests\Feature;

use App\Models\Candidate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Experience;
use Illuminate\Database\Eloquent\Model;

class ExperienceTest extends TestCase
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
        ])->getJson('/api/experiences');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'company_name',
                        'company_address',
                        'position',
                        'job_desc',
                        'start_year',
                        'end_year',
                        'until_now',
                        'flag',
                        "created_at",
                        "updated_at",
                        "deleted_at"
                    ],
                ],
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Experience data retrieved successfully.',
            ]);
    }

    public function test_store()
    {
        $experienceData = [
            'company_name' => 'PT Maju',
            'company_address' => 'Jl. Maju Mundur No. 1',
            'position' => 'Staf Administrasi',
            'job_desc' => 'Membuat laporan keuangan, melakukan rekapitulasi penjualan rutin',
            'start_year' => 2015,
            'end_year' => 2019,
            'until_now' => false,
            'flag' => '1',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/experiences', $experienceData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'company_name',
                    'company_address',
                    'position',
                    'job_desc',
                    'start_year',
                    'end_year',
                    'until_now',
                    'flag',
                    "created_at",
                    "updated_at"
                ],
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Experience data created successfully.',
            ]);
    }

    public function test_show()
    {
        $experience = Experience::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson("/api/experiences/{$experience->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'company_name',
                    'company_address',
                    'position',
                    'job_desc',
                    'start_year',
                    'end_year',
                    'until_now',
                    'flag',
                    "created_at",
                    "updated_at",
                    "deleted_at"
                ],
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Experience data retrieved successfully.',
            ]);
    }

    public function test_update()
    {
        $experience = Experience::factory()->create();

        $updatedExperienceData = [
            'company_name' => 'PT Sinar Abadi',
            'company_address' => 'Jl. Kenangan Denpasar',
            'position' => 'Staf Gudang',
            'job_desc' => 'Melakukan bongkar muat barang, melakukan pemantauan stok barang',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->putJson("/api/experiences/{$experience->id}", $updatedExperienceData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'company_name',
                    'company_address',
                    'position',
                    'job_desc',
                    'start_year',
                    'end_year',
                    'until_now',
                    'flag',
                    "created_at",
                    "updated_at",
                    "deleted_at"
                ],
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Experience data updated successfully.',
            ]);
    }

    public function test_delete()
    {
        $experience = Experience::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson("/api/experiences/{$experience->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Experience data deleted successfully.',
            ]);
    }
}
