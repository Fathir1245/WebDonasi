<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created comment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'campaign_id' => $campaign->id,
            'content' => $validated['content'],
        ]);

        return redirect()->route('campaigns.show', $campaign);
    }

    /**
     * Remove the specified comment from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Comment $comment)
    {
        // Check if the user is authorized to delete this comment
        if (Auth::id() !== $comment->user_id && !Auth::user()->is_admin) {
            return redirect()->back();
        }

        $campaign = $comment->campaign;
        $comment->delete();

        return redirect()->route('campaigns.show', $campaign);
    }
}
