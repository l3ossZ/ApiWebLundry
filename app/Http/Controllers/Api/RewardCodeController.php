<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RewardCodeResource;
use App\Models\RewardCode;
use Illuminate\Http\Request;

class RewardCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $rewardCodes = RewardCode::with(['reward', 'user'])->paginate(10);
        return RewardCodeResource::collection($rewardCodes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RewardCode  $rewardCode
     * @return RewardCodeResource
     */
    public function show(RewardCode $rewardCode)
    {
        return new RewardCodeResource($rewardCode);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RewardCode  $rewardCode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RewardCode $rewardCode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RewardCode  $rewardCode
     * @return \Illuminate\Http\Response
     */
    public function destroy(RewardCode $rewardCode)
    {
        //
    }

    public function search(Request $request) {
        $q = $request->query('q');
        $sort = $request->query('sort') ?? 'asc';
        $rewardCodes = RewardCode::where('code', 'LIKE', "%{$q}%")
            ->orderBy('code', $sort)
            ->paginate(10)->withQueryString();
        return RewardCodeResource::collection($rewardCodes);
    }
}
