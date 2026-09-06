<?php

namespace App\Services;

use App\Models\MatchModel;
use App\Models\Swipe;

class MatchService
{
    public function registerLikeAndDetectMatch(int $swiperId, int $targetId): ?MatchModel
    {
        $mutualLike = Swipe::where('swiper_user_id', $targetId)
            ->where('target_user_id', $swiperId)
            ->where('liked', true)
            ->exists();

        if (! $mutualLike) {
            return null;
        }

        $userOneId = min($swiperId, $targetId);
        $userTwoId = max($swiperId, $targetId);

        return MatchModel::firstOrCreate([
            'user_one_id' => $userOneId,
            'user_two_id' => $userTwoId,
        ]);
    }
}
