<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session; // ADD THIS

class ReviewController extends Controller
{
    /**
     * Display reviews for a product
     */
    public function index(Product $product)
    {
        $reviews = $product->reviews()
                          ->where('is_approved', true)
                          ->latest()
                          ->paginate(10);

        return response()->json([
            'success' => true,
            'reviews' => $reviews,
            'average_rating' => $product->average_rating,
            'total_reviews' => $product->reviews()->count()
        ]);
    }

    /**
     * Store a new review
     */
   public function store(Request $request, Product $product)
{
    // Validate request
    $validator = Validator::make($request->all(), [
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string|min:5|max:1000',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'save_info' => 'nullable|in:on,off,1,0,true,false' // Updated validation rule
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput()
            ->withFragment('review-form');
    }

    // Convert save_info to boolean
    $saveInfo = in_array($request->save_info, ['on', '1', 'true'], true);

    // Check if user already reviewed this product
    $existingReview = Review::where('product_id', $product->id)
        ->where('email', $request->email)
        ->first();

    if ($existingReview) {
        return redirect()->back()
            ->with('error', 'You have already reviewed this product.')
            ->withInput()
            ->withFragment('review-form');
    }

    try {
        // Create review
        $review = new Review();
        $review->product_id = $product->id;
        $review->user_id = auth()->check() ? auth()->id() : null;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->user_name = $request->name;
        $review->email = $request->email;
        $review->is_approved = false;
        $review->save();

        // Save info in session if requested
        if ($saveInfo) {
            Session::put('reviewer_name', $request->name);
            Session::put('reviewer_email', $request->email);
        } else {
            Session::forget(['reviewer_name', 'reviewer_email']);
        }

        return redirect()->back()
            ->with('success', 'Thank you for your review! It will be visible after admin approval.')
            ->withFragment('review-form');

    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'An error occurred while submitting your review: ' . $e->getMessage())
            ->withInput()
            ->withFragment('review-form');
    }
}

    /**
     * Update a review
     */
    public function update(Request $request, Review $review)
    {
        // Check if user can update this review
        if (auth()->check()) {
            if ($review->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }
        } else {
            // For guest reviews, verify email
            if ($review->email !== $request->email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }
        }

        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->is_approved = false; // Require re-approval after edit
        $review->save();

        return response()->json([
            'success' => true,
            'message' => 'Review updated successfully. It will be visible after admin approval.',
            'review' => $review
        ]);
    }

    /**
     * Delete a review
     */
    public function destroy(Request $request, Review $review)
    {
        // Check if user can delete this review
        if (auth()->check()) {
            if ($review->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }
        } else {
            // For guest reviews, verify email
            if ($review->email !== $request->email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }
        }

        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Review deleted successfully'
        ]);
    }

    /**
     * Admin: Approve review
     */
    public function approve(Review $review)
    {
        // You'll need to implement proper authorization
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $review->is_approved = true;
        $review->approved_at = now();
        $review->approved_by = auth()->id();
        $review->save();

        return response()->json([
            'success' => true,
            'message' => 'Review approved successfully'
        ]);
    }

    /**
     * Admin: Reject review
     */
    public function reject(Review $review)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $review->is_approved = false;
        $review->rejected_at = now();
        $review->rejected_by = auth()->id();
        $review->save();

        return response()->json([
            'success' => true,
            'message' => 'Review rejected successfully'
        ]);
    }
}