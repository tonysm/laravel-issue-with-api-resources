<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Http\Resources\UserCollection;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function testBasicTest()
    {
        factory(User::class)
            ->times(3)
            ->states('withArticles')
            ->create();

        $users = User::paginate();

        $this->assertInstanceOf(LengthAwarePaginator::class, $users);
        $this->assertInstanceOf(Collection::class, $users->getCollection());

        $usersCollection = new UserCollection($users);

        $this->assertInstanceOf(LengthAwarePaginator::class, $usersCollection->resource);
        // Passes.
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $usersCollection->collection);
        // Fails.
        $this->assertInstanceOf(Collection::class, $usersCollection->resource->getCollection());
    }
}
