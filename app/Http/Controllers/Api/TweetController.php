<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTweetRequest;
use App\Models\Tweet;
use App\Services\TweetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TweetController extends Controller
{
    public function __construct(private readonly TweetService $tweetService)
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $tweets = $this->tweetService->getUserTweets(auth()->id());

            return response()->json([
                'success' => true,
                'data' => $tweets
            ])->setStatusCode(ResponseAlias::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'issue' => $e->getMessage(),
                'message' => 'Something went wrong!'
            ])->setStatusCode(ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display a listing of the resource timeline.
     */
    public function timeline(): JsonResponse
    {
        try {
            $tweets = $this->tweetService->getUserTimeline(auth()->id());

            return response()->json([
                'success' => true,
                'data' => $tweets
            ])->setStatusCode(ResponseAlias::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'issue' => $e->getMessage(),
                'message' => 'Something went wrong!'
            ])->setStatusCode(ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTweetRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $req = $request->validated();
            $req['user_id'] = auth()->id();
            $tweet = $this->tweetService->storeTweet($req);

            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $tweet,
                'message' => 'Tweet successful!'
            ])->setStatusCode(ResponseAlias::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'issue' => $e->getMessage(),
                'message' => 'Something went wrong!'
            ])->setStatusCode(ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tweet $tweet): JsonResponse
    {
        try {
            $tweet = $this->tweetService->getTweetDetails($tweet);

            return response()->json([
                'success' => true,
                'data' => $tweet
            ])->setStatusCode(ResponseAlias::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'issue' => $e->getMessage(),
                'message' => 'Something went wrong!'
            ])->setStatusCode(ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTweetRequest $request, Tweet $tweet): JsonResponse
    {
        DB::beginTransaction();
        try {
            $req = $request->validated();
            $tweet->update($req);

            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $tweet,
                'message' => 'Tweet updated!'
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tweet $tweet): JsonResponse
    {
        DB::beginTransaction();
        try {
            $tweet->delete();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Tweet deleted!'
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
