<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Author;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_authors_list(): void
    {
        $authors = Author::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.authors.index'));

        $response->assertOk()->assertSee($authors[0]->first_name);
    }

    /**
     * @test
     */
    public function it_stores_the_author(): void
    {
        $data = Author::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.authors.store'), $data);

        $this->assertDatabaseHas('authors', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_author(): void
    {
        $author = Author::factory()->create();

        $user = User::factory()->create();

        $data = [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'contact_no' => $this->faker->text(255),
            'address' => $this->faker->address(),
            'status' => $this->faker->numberBetween(0, 1),
            'user_id' => $user->id,
        ];

        $response = $this->putJson(route('api.authors.update', $author), $data);

        $data['id'] = $author->id;

        $this->assertDatabaseHas('authors', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_author(): void
    {
        $author = Author::factory()->create();

        $response = $this->deleteJson(route('api.authors.destroy', $author));

        $this->assertSoftDeleted($author);

        $response->assertNoContent();
    }
}
