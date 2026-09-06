<?php

namespace App\Livewire;

use App\Models\Swipe;
use App\Models\User;
use App\Services\MatchService;
use Livewire\Component;

class Discover extends Component
{
    public ?User $candidate = null;

    public ?string $justMatched = null;

    public function mount(): void
    {
        $this->loadNextCandidate();
    }

    public function like(MatchService $matches): void
    {
        $this->recordSwipe(true, $matches);
    }

    public function nope(): void
    {
        $this->recordSwipe(false);
    }

    private function recordSwipe(bool $liked, ?MatchService $matches = null): void
    {
        if (! $this->candidate) {
            return;
        }

        $this->justMatched = null;

        Swipe::create([
            'swiper_user_id' => auth()->id(),
            'target_user_id' => $this->candidate->id,
            'liked' => $liked,
        ]);

        if ($liked && $matches && $matches->registerLikeAndDetectMatch(auth()->id(), $this->candidate->id)) {
            $this->justMatched = $this->candidate->name;
        }

        $this->loadNextCandidate();
    }

    private function loadNextCandidate(): void
    {
        $swipedIds = Swipe::where('swiper_user_id', auth()->id())->pluck('target_user_id');

        $this->candidate = User::whereHas('universe')
            ->where('id', '!=', auth()->id())
            ->whereNotIn('id', $swipedIds)
            ->inRandomOrder()
            ->first();
    }

    public function render()
    {
        return view('livewire.discover');
    }
}
