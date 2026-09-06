<?php

namespace App\Http\Controllers;

use App\Models\MatchModel;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MatchController extends Controller
{
    /**
     * List the authenticated user's matches.
     */
    public function index(Request $request): View
    {
        $matches = MatchModel::forUser($request->user()->id)
            ->with(['userOne.universe', 'userTwo.universe'])
            ->latest()
            ->get();

        return view('matches.index', ['matches' => $matches]);
    }
}
