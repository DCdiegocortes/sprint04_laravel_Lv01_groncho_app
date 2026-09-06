<?php

namespace App\Livewire;

use App\Models\Swipe;
use App\Models\User;
use Livewire\Component;

class Discover extends Component
{
    public ?User $candidate = null;

    public function mount(): void
    {
        $this->loadNextCandidate();
    }

    public function like(): void
    {
        $this->recordSwipe(true);
    }

    public function nope(): void
    {
        $this->recordSwipe(false);
    }

    private function recordSwipe(bool $liked): void
    {
        if (! $this->candidate) {
            return;
        }

        Swipe::create([
            'swiper_user_id' => auth()->id(),
            'target_user_id' => $this->candidate->id,
            'liked' => $liked,
        ]);

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
