<?php

namespace Tests\Unit;

use App\Models\Invitation;
use PHPUnit\Framework\TestCase;
use App\Services\InvitationService;
use Illuminate\Http\Request;

class InvitationServiceTest extends TestCase
{
    /**
     * test create invitation
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

    /**
     * test cancel an invitation
     * @return void
     */
    public function test_cancel(): void
    {
        $invitationService = $this->getMockBuilder(InvitationService::class)
            ->onlyMethods(['save'])
            ->getMock();
        $invitationService->expects($this->once())
            ->method('save');
        $request = new Request();
        $request->user_id = 10;
        $invitation = new Invitation();
        $invitation->user_id = 10;
        $invitationService->cancel($request, $invitation);
    }

    /**
     * test cancel an invitation
     * @return void
     */
    public function test_cancel_not_match(): void
    {
        $invitationService = $this->getMockBuilder(InvitationService::class)
            ->onlyMethods(['save'])
            ->getMock();
        $request = new Request();
        $request->user_id = 10;
        $invitation = new Invitation();
        $invitation->user_id = 20;
        $this->expectException('exception');
        $invitationService->cancel($request, $invitation);
    }

    /**
     * test cancel an invitation
     * @return void
     */
    public function test_cancel_check_status_accepted(): void
    {
        $invitationService = $this->getMockBuilder(InvitationService::class)
            ->onlyMethods(['save'])
            ->getMock();
        $request = new Request();
        $request->user_id = 10;
        $invitation = new Invitation();
        $invitation->user_id = 10;
        $invitation->status = 'accepted';
        $this->expectException('exception');
        $invitationService->cancel($request, $invitation);
    }

    /**
     * test cancel an invitation
     * @return void
     */
    public function test_cancel_check_status_declined(): void
    {
        $invitationService = $this->getMockBuilder(InvitationService::class)
            ->onlyMethods(['save'])
            ->getMock();
        $request = new Request();
        $request->user_id = 10;
        $invitation = new Invitation();
        $invitation->user_id = 10;
        $invitation->status = 'declined';
        $this->expectException('exception');
        $invitationService->cancel($request, $invitation);
    }

    /**
     * test accept an invitation
     * @return void
     */
    public function test_accept(): void
    {
        $invitationService = $this->getMockBuilder(InvitationService::class)
            ->onlyMethods(['save'])
            ->getMock();
        $invitationService->expects($this->once())
            ->method('save');
        $request = new Request();
        $request->invitation_code = 'testcode1';
        $invitation = new Invitation();
        $invitation->invitation_code = 'testcode1';
        $invitationService->accept($request, $invitation);
    }

    /**
     * test accept an invitation
     * @return void
     */
    public function test_accept_check_status(): void
    {
        $invitationService = $this->getMockBuilder(InvitationService::class)
            ->onlyMethods(['save'])
            ->getMock();
        $request = new Request();
        $request->invitation_code = 'testcode1';
        $invitation = new Invitation();
        $invitation->invitation_code = 'testcode1';
        $invitation->status = 'cancelled';
        $this->expectException('exception');
        $invitationService->accept($request, $invitation);
    }

    /**
     * test accept an invitation
     * @return void
     */
    public function test_accept_check_match(): void
    {
        $invitationService = $this->getMockBuilder(InvitationService::class)
            ->onlyMethods(['save'])
            ->getMock();
        $request = new Request();
        $request->invitation_code = 'testcode1';
        $invitation = new Invitation();
        $invitation->invitation_code = 'testcode2';
        $this->expectException('exception');
        $invitationService->accept($request, $invitation);
    }

    /**
     * test decline an invitation
     * @return void
     */
    public function test_decline(): void
    {
        $invitationService = $this->getMockBuilder(InvitationService::class)
            ->onlyMethods(['save'])
            ->getMock();
        $invitationService->expects($this->once())
            ->method('save');
        $request = new Request();
        $request->invitation_code = 'testcode1';
        $invitation = new Invitation();
        $invitation->invitation_code = 'testcode1';
        $invitationService->decline($request, $invitation);
    }

    /**
     * test decline an invitation
     * @return void
     */
    public function test_decline_check_status(): void
    {
        $invitationService = $this->getMockBuilder(InvitationService::class)
            ->onlyMethods(['save'])
            ->getMock();
        $request = new Request();
        $request->invitation_code = 'testcode1';
        $invitation = new Invitation();
        $invitation->invitation_code = 'testcode1';
        $invitation->status = 'cancelled';
        $this->expectException('exception');
        $invitationService->decline($request, $invitation);
    }

    /**
     * test decline an invitation
     * @return void
     */
    public function test_decline_check_match(): void
    {
        $invitationService = $this->getMockBuilder(InvitationService::class)
            ->onlyMethods(['save'])
            ->getMock();
        $request = new Request();
        $request->invitation_code = 'testcode1';
        $invitation = new Invitation();
        $invitation->invitation_code = 'testcode2';
        $this->expectException('exception');
        $invitationService->decline($request, $invitation);
    }
}
