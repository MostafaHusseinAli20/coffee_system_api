<?php

namespace App\Http\Controllers\System\Coffees;

use App\Http\Controllers\Controller;
use App\Models\Coffee;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoffeeController extends Controller
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

        $coffees = Coffee::get();

        if ($coffees->isEmpty()) {
            return $this->errorResponse('No coffees found', 404);
        }

        return $this->successResponse(
            $coffees,
            'Coffees retrieved successfully',
            200
        );

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'join_date' => 'required|date',
            'address' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'phone' => 'nullable|string|max:20',
            'logo' => 'nullable|image|max:2048',
        ]);
        DB::beginTransaction();
        try {
            $coffee = Coffee::create([
                'name' => $request->name,
                'join_date' => $request->join_date,
                'address' => $request->address,
                'type' => $request->type,
                'website' => $request->website,
                'phone' => $request->phone,
                'logo' => $request->logo,
            ]);
            
            DB::commit();
            return $this->successResponse(
                $coffee,
                'Coffee created successfully',
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
        return $this->successResponse(
            Coffee::where('id', $id)->firstOrFail($id),
            'Coffee retrieved successfully',
            200
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
