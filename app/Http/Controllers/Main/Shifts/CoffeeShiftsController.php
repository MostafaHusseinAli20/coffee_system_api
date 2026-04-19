<?php

namespace App\Http\Controllers\Main\Shifts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Main\Shifts\ShiftsRequest;
use App\Http\Resources\Main\ShiftsResource;
use App\Models\Shif;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\DB;

class CoffeeShiftsController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->role == 'developer') {
            $shifts = Shif::latest()->paginate(PAGINATION_COUNT);
        } else {
            $shifts = Shif::where('coffee_id', auth()->user()->coffee_id)
                ->latest()
                ->paginate(PAGINATION_COUNT);
        }
        if($shifts->isEmpty()) {
            return $this->errorResponse('No shifts found', 404);
        }

        $response = ShiftsResource::collection($shifts);

        return $this->successResponse(
            $response,
            'Shifts retrieved successfully',
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShiftsRequest $request)
    {
        DB::beginTransaction();
        try {
            if(auth()->user()->role == 'developer') {
                $shift = Shif::create([
                    'coffee_id' => $request->coffee_id,
                    'user_id' => $request->user_id,
                    'total_amount' => $request->total_amount,
                    'status' => $request->status,
                    'from' => $request->from,
                    'to' => $request->to,
                    'opened_by' => $request->opened_by,
                    'closed_by' => $request->closed_by,
                    'notes' => $request->notes,
                ]);
            } else {
                $shift = Shif::create([
                    'coffee_id' => auth()->user()->coffee_id,
                    'user_id' => auth()->id(),
                    'total_amount' => $request->total_amount,
                    'status' => $request->status,
                    'from' => $request->from,
                    'to' => $request->to,
                    'opened_by' => auth()->id(),
                    'closed_by' => null,
                    'notes' => $request->notes,
                ]);
            }

            if(!$shift) {
                return $this->errorResponse('Shift not created', 500);
            }

            DB::commit();
            return $this->successResponse(
                'Shift created successfully',
                201
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to create shift', 500, $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(auth()->user()->role == 'developer') {
            $shift = Shif::find($id);
        } else {
            $shift = Shif::where('coffee_id', auth()->user()->coffee_id)
                ->where('id', $id)
                ->first();
        }

        if (!$shift) {
            return $this->errorResponse('Shift not found', 404);
        }

        $response = new ShiftsResource($shift);

        return $this->successResponse(
            $response,
            'Shift retrieved successfully',
            200
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ShiftsRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            if(auth()->user()->role == 'developer') {
                $shift = Shif::find($id);
                $shift->update($request->validated());
            } else {
                $shift = Shif::where('coffee_id', auth()->user()->coffee_id)
                    ->where('id', $id)
                    ->first();

                if (!$shift) {
                    return $this->errorResponse('Shift not found', 404);
                }

                $shift->update($request->validated());
            }

            if(!$shift) {
                return $this->errorResponse('Shift not updated', 500);
            }

            DB::commit();
            return $this->successResponse(
                'Shift updated successfully',
                200
            );
    }
        catch (\Exception $e) {
            DB::rollBack();
             return $this->errorResponse('Failed to update shift', 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(auth()->user()->role == 'developer') {
            $shift = Shif::find($id);
        } else {
            $shift = Shif::where('coffee_id', auth()->user()->coffee_id)
                ->where('id', $id)
                ->first();
        }

        if (!$shift) {
            return $this->errorResponse('Shift not found', 404);
        }

        $shift->delete();
        return $this->successResponse(
            'Shift deleted successfully',
            200
        );
    }
}
