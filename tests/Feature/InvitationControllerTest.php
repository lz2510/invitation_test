<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\InvitationSeeder;
use App\Models\Invitation;

class InvitationControllerTest extends TestCase
{
    use RefreshDatabase;
    //use DatabaseMigrations;
    /**
     * test send
     * @return void
     */
    public function test_send(): void
    {
        $data = ["user_id"=>1,"email"=>"user@sample.com"];
        $response = $this->post('api/invitations/send', $data);

        $response->assertStatus(201);
    }

    /**
     * test send
     * @return void
     */
    public function test_send_miss_param(): void
    {
        $data = ["email"=>"user@sample.com"];
        $response = $this->post('api/invitations/send', $data);
        $response->assertStatus(400);

        $data = ["user_id"=>1];
        $response = $this->post('api/invitations/send', $data);
        $response->assertStatus(400);
    }

    /**
     * test cancel
     * @return void
     */
    public function test_cancel(): void
    {
        $this->seed(InvitationSeeder::class);
        $row = Invitation::where("id", 1)->first();
        $data = ["id"=>$row->id, "user_id"=>$row->user_id];
        $response = $this->put('api/invitations/:id/cancel', $data);

        $response->assertStatus(201);
    }

    /**
     * test cancel
     * @return void
     */
    public function test_cancel_miss_param(): void
    {
        $this->seed(InvitationSeeder::class);
        $row = Invitation::where("id", 1)->first();
        $data = ["id"=>$row->id];
        $response = $this->put('api/invitations/:id/cancel', $data);
        $response->assertStatus(400);

        $data = ["user_id"=>$row->user_id];
        $response = $this->put('api/invitations/:id/cancel', $data);
        $response->assertStatus(400);
    }

    /**
     * test cancel
     * @return void
     */
    public function test_cancel_not_exist(): void
    {
        $this->seed(InvitationSeeder::class);
        $row = Invitation::where("id", 1)->first();
        $data = ["id"=>99999, "user_id"=>$row->user_id];
        $response = $this->put('api/invitations/:id/cancel', $data);

        $response->assertStatus(500);
    }

    /**
     * test cancel
     * @return void
     */
    public function test_cancel_not_match(): void
    {
        $this->seed(InvitationSeeder::class);
        $row = Invitation::where("id", 1)->first();
        $data = ["id"=>$row->user_id, "user_id"=>99999];
        $response = $this->put('api/invitations/:id/cancel', $data);

        $response->assertStatus(500);
    }

    /**
     * test accept
     * @return void
     */
    public function test_accept(): void
    {
        $this->seed(InvitationSeeder::class);
        $row = Invitation::where("id", 1)->first();

        $data = ["id"=>$row->id, "invitation_code"=>$row->invitation_code];
        $response = $this->put('api/invitations/:id/accept', $data);

        $response->assertStatus(201);
    }

    /**
     * test accept
     * @return void
     */
    public function test_accept_miss_param(): void
    {
        $this->seed(InvitationSeeder::class);
        $row = Invitation::where("id", 1)->first();
        $data = ["id"=>$row->id];
        $response = $this->put('api/invitations/:id/accept', $data);
        $response->assertStatus(400);

        $data = ["invitation_code"=>$row->invitation_code];
        $response = $this->put('api/invitations/:id/accept', $data);
        $response->assertStatus(400);
    }

    /**
     * test accept
     * @return void
     */
    public function test_accept_not_match(): void
    {
        $this->seed(InvitationSeeder::class);
        $row = Invitation::where("id", 1)->first();
        $data = ["id"=>$row->id, "invitation_code"=>"test_code"];
        $response = $this->put('api/invitations/:id/accept', $data);

        $response->assertStatus(500);
    }


    /**
     * test decline
     * @return void
     */
    public function test_decline(): void
    {
        $this->seed(InvitationSeeder::class);
        $row = Invitation::where("id", 1)->first();

        $data = ["id"=>$row->id, "invitation_code"=>$row->invitation_code];
        $response = $this->put('api/invitations/:id/decline', $data);

        $response->assertStatus(201);
    }

    /**
     * test decline
     * @return void
     */
    public function test_decline_miss_param(): void
    {
        $this->seed(InvitationSeeder::class);
        $row = Invitation::where("id", 1)->first();
        $data = ["id"=>$row->id];
        $response = $this->put('api/invitations/:id/decline', $data);
        $response->assertStatus(400);

        $data = ["invitation_code"=>$row->invitation_code];
        $response = $this->put('api/invitations/:id/decline', $data);
        $response->assertStatus(400);
    }

    /**
     * test decline
     * @return void
     */
    public function test_decline_not_match(): void
    {
        $this->seed(InvitationSeeder::class);
        $row = Invitation::where("id", 1)->first();
        $data = ["id"=>$row->id, "invitation_code"=>"test_code"];
        $response = $this->put('api/invitations/:id/decline', $data);

        $response->assertStatus(500);
    }
}
