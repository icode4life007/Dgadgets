<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with('product');

        // Filter by status
        if ($request->filter == 'pending') {
            $query->where('is_approved', false)
                  ->whereNull('rejected_at');
        } elseif ($request->filter == 'approved') {
            $query->where('is_approved', true);
        } elseif ($request->filter == 'rejected') {
            $query->whereNotNull('rejected_at');
        }

        // Search functionality
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('user_name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('comment', 'LIKE', "%{$search}%")
                  ->orWhereHas('product', function($productQuery) use ($search) {
                      $productQuery->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        $reviews = $query->latest()->paginate(15);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function show(Review $review)
    {
        $review->load('product');
        return view('admin.reviews.show', compact('review'));
    }

    public function approve(Review $review)
    {
        $review->update([
            'is_approved' => true,
            'approved_at' => now(),
            'approved_by' => auth()->id(),
            'rejected_at' => null,
            'rejected_by' => null
        ]);

        return redirect()->back()->with('success', 'Review approved successfully.');
    }

    public function reject(Review $review)
    {
        $review->update([
            'is_approved' => false,
            'rejected_at' => now(),
            'rejected_by' => auth()->id(),
            'approved_at' => null,
            'approved_by' => null
        ]);

        return redirect()->back()->with('success', 'Review rejected successfully.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully.');
    }
}