<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DonationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Campaign $campaign)
    {
        return view('donations.create', compact('campaign'));
    }

    public function store(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'message' => 'nullable|string|max:255',
            'payment_method' => 'required|in:credit_card,bank_transfer,e-wallet',
        ]);

        // Generate a unique transaction ID
        $transactionId = 'TRX-' . Str::upper(Str::random(8));

        $donation = Donation::create([
            'amount' => $validated['amount'],
            'message' => $validated['message'],
            'user_id' => Auth::id(),
            'campaign_id' => $campaign->id,
            'status' => 'pending',
            'payment_method' => $validated['payment_method'],
            'transaction_id' => $transactionId
        ]);

        // In a real application, you would integrate with a payment gateway here
        // For this example, we'll simulate a successful payment
        $this->processPayment($donation);

        return redirect()->route('campaigns.show', $campaign)
            ->with('success', 'Thank you for your donation!');
    }

    private function processPayment(Donation $donation)
    {
        // Simulate payment processing
        // In a real application, this would involve a payment gateway
        
        // Update donation status to completed
        $donation->update(['status' => 'completed']);
        
        // Update campaign's current amount
        $campaign = $donation->campaign;
        $campaign->current_amount += $donation->amount;
        $campaign->save();
    }
}
