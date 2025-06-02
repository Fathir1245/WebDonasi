<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $withdrawals = Withdrawal::with(['campaign'])
            ->whereHas('campaign', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->latest()
            ->paginate(10);

        return view('withdrawals.index', compact('withdrawals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Campaign $campaign)
    {
        // Check if user owns the campaign
        if ($campaign->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if campaign has available funds
        if ($campaign->available_for_withdrawal <= 0) {
            return redirect()->route('campaigns.show', $campaign)
                ->with('error', 'Tidak ada dana yang tersedia untuk dicairkan.');
        }

        return view('withdrawals.create', compact('campaign'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Campaign $campaign)
    {
        // Check if user owns the campaign
        if ($campaign->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:1',
                'max:' . $campaign->available_for_withdrawal
            ],
            'reason' => 'nullable|string|max:1000'
        ]);

        Withdrawal::create([
            'campaign_id' => $campaign->id,
            'amount' => $request->amount,
            'reason' => $request->reason,
            'status' => 'pending',
            'requested_at' => now()
        ]);

        return redirect()->route('withdrawals.index')
            ->with('success', 'Permintaan pencairan dana berhasil diajukan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Withdrawal $withdrawal)
    {
        // Check if user owns the campaign
        if ($withdrawal->campaign->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('withdrawals.show', compact('withdrawal'));
    }

    /**
     * Update the specified resource in storage (for admin approval).
     */
    public function update(Request $request, Withdrawal $withdrawal)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'reason' => 'nullable|string|max:1000'
        ]);

        $withdrawal->update([
            'status' => $request->status,
            'reason' => $request->reason,
            'approved_at' => $request->status === 'approved' ? now() : null
        ]);

        return redirect()->back()
            ->with('success', 'Status pencairan dana berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Withdrawal $withdrawal)
    {
        // Check if user owns the campaign and withdrawal is still pending
        if ($withdrawal->campaign->user_id !== auth()->id() || !$withdrawal->isPending()) {
            abort(403, 'Unauthorized action.');
        }

        $withdrawal->delete();

        return redirect()->route('withdrawals.index')
            ->with('success', 'Permintaan pencairan dana berhasil dibatalkan.');
    }
}
