<?php

namespace App\Http\Controllers\System\Subscriptions;

use App\Http\Controllers\Controller;
use App\Http\Requests\System\Subscriptions\SubscriptionRequest;
use App\Http\Resources\System\Subscriptions\SubscriptionResource;
use App\Models\Subscription;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    use ApiResponseTrait;

    // public function __construct()
    // {
    //     // Apply middleware to restrict access to developers only
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->role == 'developer') {
            $subscriptions = Subscription::latest()->paginate(PAGINATION_COUNT);
        } else {
            $subscriptions = Subscription::where('coffee_id', auth()->user()->coffee_id)
                ->latest()
                ->paginate(PAGINATION_COUNT);
        }
        
        if($subscriptions->isEmpty()) {
            return $this->errorResponse('No subscriptions found', 404);
        }

        $response = SubscriptionResource::collection($subscriptions);

        return $this->successResponse(
            $response,
            'Subscriptions retrieved successfully',
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubscriptionRequest $request)
    {
        DB::beginTransaction();
        try {
            if(auth()->user()->role == 'developer') {
                $subscription = Subscription::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'price' => $request->price,
                    'duration' => $request->duration,
                    'coffee_id' => $request->coffee_id,
                    'enrollments_count' => $request->enrollments_count,
                    'is_active' => $request->is_active,
                ]);
            }else{
                return $this->errorResponse('Unauthorized', 403);
            }

            if(!$subscription) {
                return $this->errorResponse('Subscription not created', 500);
            }

            DB::commit();
            return $this->successResponse(
                'Subscription created successfully',
                201
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(auth()->user()->role == 'developer') {
            $subscription = Subscription::find($id);
        } else {
            $subscription = Subscription::where('coffee_id', auth()->user()->coffee_id)
                ->where('id', $id)
                ->first();
        }

        if (!$subscription) {
            return $this->errorResponse('Subscription not found', 404);
        }

        $response = new SubscriptionResource($subscription);

        return $this->successResponse(
            $response,
            'Subscription retrieved successfully',
            200
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubscriptionRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            if(auth()->user()->role == 'developer') {
                $subscription = Subscription::find($id);
                $subscription->update([
                    'name' => $request->name,
                    'description' => $request->description,
                    'price' => $request->price,
                    'duration' => $request->duration,
                    'coffee_id' => $request->coffee_id,
                    'enrollments_count' => $request->enrollments_count,
                    'is_active' => $request->is_active,
                ]);
            }else{
                return $this->errorResponse('Unauthorized', 403);
            }
            DB::commit();
            if ($subscription) {
                return $this->successResponse(
                    'Subscription updated successfully',
                    200
                );
            } else {
                return $this->errorResponse('Subscription not found', 404);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(auth()->user()->role == 'developer') {
            $subscription = Subscription::find($id);
            $subscription->delete();
        }else{
            return $this->errorResponse('Unauthorized', 403);
        }
        if ($subscription) {
            return $this->successResponse(
                'Subscription deleted successfully',
                200
            );
        } else {
            return $this->errorResponse('Subscription not found', 404);
        }
    }
}
