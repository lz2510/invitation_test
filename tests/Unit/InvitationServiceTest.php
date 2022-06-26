<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\InvitationService;
use Illuminate\Http\Request;

class InvitationServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_create_invitation(): void
    {
        $invitationService = $this->getMockBuilder(InvitationService::class)
            ->onlyMethods(['create', 'updateStatus'])
            ->getMock();
        $invitationService->expects($this->once())
            ->method('create');
        $invitationService->expects($this->once())
            ->method('updateStatus');
        $request = new Request();
        $invitationService->createInvitation($request);
        $this->assertTrue(true);
    }
}
