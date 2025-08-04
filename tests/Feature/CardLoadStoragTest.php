<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CardLoadStoragTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {

        $user = User::factory()->create();

        $user->assignRole('Card.user');

        $this->assertTrue($user->hasRole('Card.user'));

        $this->actingAs($user);


/*        $response = $this->actingAs($user)
            ->get('/');*/
        //$response->dump();
        //$this->actingAs($user, 'Card.user.view');



        $file = UploadedFile::fake()->create('test.xml',0,'application/xml');

        $response = $this->post('/card', [
            'loadStorageLocation' => $file,
        ]);

        //$response->assertFound();

        $response->assertValid('loadStorageLocation');

        //$response->dump();
      //  Storage::fake('avatars');

        //Storage::disk('avatars')->assertExists($file->hashName());
        //$response->dump();
    }
}
