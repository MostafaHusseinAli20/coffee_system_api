<?php

namespace App\Http\Controllers\System\Coffees;

use App\Http\Controllers\Controller;
use App\Http\Resources\System\Coffees\CoffeeResource;
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

        $coffees = Coffee::latest()->paginate(PAGINATION_COUNT);

        if ($coffees->isEmpty()) {
            return $this->errorResponse('No coffees found', 404);
        }

        $response = CoffeeResource::collection($coffees);
        // Transform the collection of Coffee models into a collection of CoffeeResource
        // CoffeeResource::collection($coffees)->response()->getData(true); => ['data' => $response['data], ]
        // Set the HTTP status code to 200 (OK)
        return $this->successResponse(
            $response,
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
            'type' => 'required|in:coffee,resturant',
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
                'created_by' => auth()->id(),
            ]);
            
            DB::commit();
            return $this->successResponse(
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
        $coffee = Coffee::find($id);
        if(!$coffee) {
            return $this->errorResponse('Coffee not found', 404);
        }
        return $this->successResponse(
            new CoffeeResource($coffee),
            'Coffee retrieved successfully',
            200
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'join_date' => 'sometimes|required|date',
            'address' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|in:coffee,resturant',
            'website' => 'nullable|url|max:255',
            'phone' => 'nullable|string|max:20',
            'logo' => 'nullable|image|max:2048',
        ]);
        DB::beginTransaction();
        try {
            $coffee = Coffee::find($id);
            $coffee->update([
                'name' => $request->name ?? $coffee->name,
                'join_date' => $request->join_date ?? $coffee->join_date,
                'address' => $request->address ?? $coffee->address,
                'type' => $request->type ?? $coffee->type,
                'website' => $request->website ?? $coffee->website,
                'phone' => $request->phone ?? $coffee->phone,
                'logo' => $request->logo ?? $coffee->logo,
                'updated_by' => auth()->id(),
            ]);
            DB::commit();
            return $this->successResponse(
                'Coffee updated successfully',
                200
            );
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
        DB::beginTransaction();
        try {
            $coffee = Coffee::find($id);
            $coffee->delete();
            DB::commit();
            return $this->successResponse(
                'Coffee deleted successfully',
                200
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
