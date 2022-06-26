<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Invitation;
use Illuminate\Support\Facades\Log;
use App\Models\InvitationStatus;

class InvitationService
{
    /**
     * create an invitation
     * @param Request $request
     * @return Invitation
     */
    public function createInvitation(Request $request): Invitation
    {
        $data = [];
        $data['user_id'] = $request->user_id;
        $data['email'] = $request->email;
        $data['invitation_code'] = $this->generateCode($request);
        $data['invitation_content'] = $this->getContent();
        $data['status'] = "created";

        $invitation = $this->create($data);

        $this->updateStatus($invitation);

        return $invitation;
    }

    /**
     * create a new record
     * @param array $data
     * @return Invitation
     */
    public function create(array $data): Invitation
    {
        $invitation = Invitation::create($data);
        return $invitation;
    }

    /**
     * generate invitation code
     * @param Request $request
     * @return string
     */
    public function generateCode(Request $request): string
    {
        return uniqid();
    }

    /**
     * get invitation content
     * @return string
     */
    public function getContent(): string
    {
        return "You've been invited to use Loudly";
    }

    /**
     * send invitation
     * @param Invitation $invitation
     * @return bool
     */
    public function send(Invitation $invitation): bool
    {
        //Log::info($invitation->invitation_content);

        $invitation->update(['status'=>'sent']);
        $this->updateStatus($invitation);

        return true;
    }

    /**
     * update invitation status
     * @param Invitation $invitation
     * @return bool
     */
    public function updateStatus(Invitation $invitation): bool
    {
        $invitationStatus = new InvitationStatus();
        $invitationStatus->invitation_id = $invitation->id;
        $invitationStatus->status = $invitation->status;

        $invitationStatus->save();

        return true;
    }

    /**
     * @param Request $request
     * @return void
     */
    public function cancel(Request $request): void
    {
        $invitation = Invitation::find($request->id);
        if (empty($invitation)) {
            throw new \Exception("invitaion {$request->id} doesn't exist.");
        }
        if ($invitation->user_id != $request->user_id) {
            throw new \Exception("invitaion user doesn't match.");
        }
        $invitation->status = 'cancelled';

        $invitation->save();
    }

    /**
     * accept an invitation
     * @param Request $request
     * @return void
     * @throws \Exception
     */
    public function accept(Request $request): void
    {
        $invitation = Invitation::find($request->id);
        if (empty($invitation)) {
            throw new \Exception("invitaion {$request->id} doesn't exist.");
        }
        if ($invitation->invitation_code != $request->invitation_code) {
            throw new \Exception("invitaion code doesn't match.");
        }
        $invitation->status = 'accepted';

        $invitation->save();
    }

    /**
     * decline an invitation
     * @param Request $request
     * @return void
     * @throws \Exception
     */
    public function decline(Request $request): void
    {
        $invitation = Invitation::find($request->id);
        if (empty($invitation)) {
            throw new \Exception("invitaion {$request->id} doesn't exist.");
        }
        if ($invitation->invitation_code != $request->invitation_code) {
            throw new \Exception("invitaion code doesn't match.");
        }
        $invitation->status = 'declined';

        $invitation->save();
    }
}
