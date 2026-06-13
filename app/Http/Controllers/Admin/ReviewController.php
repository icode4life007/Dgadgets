<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with('product')->latest();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('user_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('comment', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && !empty($request->status)) {
            switch($request->status) {
                case 'pending':
                    $query->where('is_approved', false)->whereNull('rejected_at');
                    break;
                case 'approved':
                    $query->where('is_approved', true);
                    break;
                case 'rejected':
                    $query->whereNotNull('rejected_at');
                    break;
            }
        }

        if ($request->has('rating') && !empty($request->rating)) {
            $query->where('rating', $request->rating);
        }

        $reviews = $query->paginate(20);
        
        $stats = [
            'total' => Review::count(),
            'pending' => Review::where('is_approved', false)->whereNull('rejected_at')->count(),
            'approved' => Review::where('is_approved', true)->count(),
            'rejected' => Review::whereNotNull('rejected_at')->count(),
        ];

        return view('admin.reviews.index', compact('reviews', 'stats'));
    }

    public function show(Review $review)
    {
        $review->load(['product', 'user', 'approver', 'rejecter']);
        return view('admin.reviews.show', compact('review'));
    }

    public function approve(Review $review)
    {
        $review->is_approved = true;
        $review->approved_at = now();
        $review->approved_by = auth()->id();
        $review->rejected_at = null;
        $review->rejected_by = null;
        $review->save();

        return redirect()->back()->with('success', 'Review approved successfully.');
    }

    public function update(Request $request, Review $review)
{
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string|min:5|max:2000',
        'status' => 'required|in:pending,approved,rejected'
    ]);

    // Update review content
    $review->rating = $request->rating;
    $review->comment = $request->comment;

    // Update status based on selection
    switch($request->status) {
        case 'approved':
            $review->is_approved = true;
            $review->approved_at = now();
            $review->approved_by = auth()->id();
            $review->rejected_at = null;
            $review->rejected_by = null;
            break;
        case 'rejected':
            $review->is_approved = false;
            $review->rejected_at = now();
            $review->rejected_by = auth()->id();
            $review->approved_at = null;
            $review->approved_by = null;
            break;
        case 'pending':
            $review->is_approved = false;
            $review->approved_at = null;
            $review->approved_by = null;
            $review->rejected_at = null;
            $review->rejected_by = null;
            break;
    }

    $review->save();

    return redirect()->route('admin.reviews.show', $review)
        ->with('success', 'Review updated successfully.');
}

    public function reject(Review $review)
    {
        $review->is_approved = false;
        $review->rejected_at = now();
        $review->rejected_by = auth()->id();
        $review->approved_at = null;
        $review->approved_by = null;
        $review->save();

        return redirect()->back()->with('success', 'Review rejected successfully.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        
        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully.');
    }
}