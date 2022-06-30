<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use App\Services\InvitationService;
use Illuminate\Support\Facades\Validator;
use App\Models\Invitation;

class InvitationController extends Controller
{
    /**
     * send an invitation
     * @param Request $request
     * @param InvitationService $invitationService
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(Request $request, InvitationService $invitationService): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'int|required',
                'email' => 'string|required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status'=>'error', 'message'=>$validator->messages()], 400);
            }
            $invitation = $invitationService->createInvitation($request);
            $invitationService->send($invitation);
        } catch (\Exception $e) {
            return response()->json(['status'=>'error', 'message'=>[$e->getMessage()]], 500);
        }

        return response()->json(['status'=>'success'], 201);
    }

    /**
     * cancel an invitation
     * @param Request $request
     * @param InvitationService $invitationService
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel(Request $request, InvitationService $invitationService): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'int|required',
                'user_id' => 'int|required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status'=>'error', 'message'=>$validator->messages()], 400);
            }
            $invitation = Invitation::find($request->id);
            $invitationService->cancel($request, $invitation);
        } catch (\Exception $e) {
            return response()->json(['status'=>'error', 'message'=>[$e->getMessage()]], 500);
        }

        return response()->json(['status'=>'success'], 201);
    }

    /**
     * accept an invitation
     * @param Request $request
     * @param InvitationService $invitationService
     * @return JsonResponse
     */
    public function accept(Request $request, InvitationService $invitationService): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'int|required',
                'invitation_code' => 'string|required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status'=>'error', 'message'=>$validator->messages()], 400);
            }
            $invitation = Invitation::find($request->id);
            $invitationService->accept($request, $invitation);
        } catch (\Exception $e) {
            return response()->json(['status'=>'error', 'message'=>[$e->getMessage()]], 500);
        }

        return response()->json(['status'=>'success'], 201);
    }

    /**
     * decline an invitation
     * @param Request $request
     * @param InvitationService $invitationService
     * @return JsonResponse
     */
    public function decline(Request $request, InvitationService $invitationService): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'int|required',
                'invitation_code' => 'string|required',
            ]);
            if ($validator->fails()) {
                return response()->json(['status'=>'error', 'message'=>$validator->messages()], 400);
            }
            $invitation = Invitation::find($request->id);
            $invitationService->decline($request, $invitation);
        } catch (\Exception $e) {
            return response()->json(['status'=>'error', 'message'=>[$e->getMessage()]], 500);
        }

        return response()->json(['status'=>'success'], 201);
    }
}
