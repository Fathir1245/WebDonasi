<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CampaignController extends Controller
{
    public function __construct()
    {
        // Require authentication for all campaign routes except index and show
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $query = Campaign::where('status', 'active')
            ->with(['category', 'user']);

        // Filter by category if provided
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $campaigns = $query->orderBy('created_at', 'desc')->paginate(9);
        
        // Get categories with campaign count for filter
        $categories = Category::withCount(['campaigns' => function ($query) {
            $query->where('status', 'active');
        }])->orderBy('name')->get();
        
        return view('campaigns.index', compact('campaigns', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('campaigns.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'target_amount' => 'required|numeric|min:1',
            'deadline' => 'required|date|after:today',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->file('image')->store('campaigns', 'public');
        
        $campaign = Campaign::create([
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'description' => $validated['description'],
            'target_amount' => $validated['target_amount'],
            'current_amount' => 0,
            'deadline' => $validated['deadline'],
            'image' => $imagePath,
            'user_id' => Auth::id(),
            'status' => 'active'
        ]);

        return redirect()->route('campaigns.show', $campaign)
            ->with('success', 'Campaign created successfully!');
    }

    public function show(Campaign $campaign)
    {
        $campaign->load(['category', 'user', 'donations.user', 'comments.user']);
        return view('campaigns.show', compact('campaign'));
    }

    public function edit(Campaign $campaign)
    {
        $this->authorize('update', $campaign);
        
        $categories = Category::orderBy('name')->get();
        return view('campaigns.edit', compact('campaign', 'categories'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $this->authorize('update', $campaign);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'target_amount' => 'required|numeric|min:1',
            'deadline' => 'required|date|after:today',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'description' => $validated['description'],
            'target_amount' => $validated['target_amount'],
            'deadline' => $validated['deadline'],
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            if ($campaign->image) {
                Storage::disk('public')->delete($campaign->image);
            }
            
            $imagePath = $request->file('image')->store('campaigns', 'public');
            $data['image'] = $imagePath;
        }

        $campaign->update($data);

        return redirect()->route('campaigns.show', $campaign)
            ->with('success', 'Campaign updated successfully!');
    }

    public function destroy(Campaign $campaign)
    {
        $this->authorize('delete', $campaign);
        
        // Delete the campaign image
        if ($campaign->image) {
            Storage::disk('public')->delete($campaign->image);
        }
        
        $campaign->delete();

        return redirect()->route('campaigns.index')
            ->with('success', 'Campaign deleted successfully!');
    }
}
