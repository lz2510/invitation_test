<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use App\Services\InvitationService;
use Illuminate\Support\Facades\Validator;

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

        return response()->json(['status'=>'success']);
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
            $invitationService->cancel($request);
        } catch (\Exception $e) {
            return response()->json(['status'=>'error', 'message'=>[$e->getMessage()]], 500);
        }

        return response()->json(['status'=>'success']);
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
            $invitationService->accept($request);
        } catch (\Exception $e) {
            return response()->json(['status'=>'error', 'message'=>[$e->getMessage()]], 500);
        }

        return response()->json(['status'=>'success']);
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
            $invitationService->decline($request);
        } catch (\Exception $e) {
            return response()->json(['status'=>'error', 'message'=>[$e->getMessage()]], 500);
        }

        return response()->json(['status'=>'success']);
    }
}
