<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FollowRequest;
use App\Http\Requests\UnfollowRequest;
use App\Services\FollowService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class FollowController extends Controller
{
    public function __construct(private readonly FollowService $followService)
    {
        //
    }

    public function follow(FollowRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $req = $request->validated();
            $this->followService->follow($req['follow_to']);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Follow action successful!'
            ])->setStatusCode(ResponseAlias::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'issue' => $e->getMessage(),
                'message' => 'Something went wrong!'
            ])->setStatusCode(ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function unfollow(UnfollowRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $req = $request->validated();
            $this->followService->unfollow($req['unfollow_to']);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Unfollow action successful!'
            ])->setStatusCode(ResponseAlias::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'issue' => $e->getMessage(),
                'message' => 'Something went wrong!'
            ])->setStatusCode(ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
