<?php

namespace App\Http\Controllers\System\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\System\Users\UserRequest;
use App\Http\Resources\System\Users\UserResource;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
        $users = User::where('coffee_id', auth()->user()->coffee_id)->latest()->paginate(PAGINATION_COUNT);

        return $this->successResponse(
            UserResource::collection($users),
            'Users retrieved successfully'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        DB::beginTransaction();
        try {
            // before create user please check if this added user is role him developer
            if (auth()->user()->role == 'developer' || auth()->user()->role == 'owner') {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => $request->role,
                    'salary' => $request->salary,
                    'is_cashier' => $request->is_cashier,
                    'his_job' => $request->his_job,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'coffee_id' => auth()->user()->coffee_id,
                    'added_by' => auth()->id(),
                ]);
                DB::commit();
                return $this->successResponse(
                    'User created successfully',
                    201
                );
            } else {
                return $this->errorResponse('Unauthorized', 403);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse(
                'Failed to create user: ' .
                $e->getMessage(),
                500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::where(
            'coffee_id',
            auth()->user()->coffee_id
        )->find($id);

        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }

        return $this->successResponse(
            new UserResource($user),
            'User retrieved successfully'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            $user = User::where(
                'coffee_id',
                auth()->user()->coffee_id
            )->find($id);

            if (!$user) {
                return $this->errorResponse('User not found', 404);
            }

            if (auth()->user()->role == 'developer' || auth()->user()->role == 'owner') {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'role' => $request->role,
                    'salary' => $request->salary,
                    'is_cashier' => $request->is_cashier,
                    'his_job' => $request->his_job,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'coffee_id' => auth()->user()->coffee_id,
                    'updated_by' => auth()->id(),
                ]);
                if($request->password){
                    $user->update([
                        'password' => Hash::make($request->password),
                    ]);
                }
                DB::commit();
                return $this->successResponse(
                    'User updated successfully',
                    200
                );
            } else {
                return $this->errorResponse('Unauthorized', 403);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse(
                'Failed to update user: ' .
                $e->getMessage(),
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            if(auth()->user()->role == 'developer' || auth()->user()->role == 'owner') {
                $user = User::where(
                    'coffee_id',
                    auth()->user()->coffee_id
                )->find($id);

                if (!$user) {
                    return $this->errorResponse('User not found', 404);
                }

                $user->delete();

                DB::commit();
                return $this->successResponse(
                    'User deleted successfully',
                    200
                );
            } else {
                return $this->errorResponse('Unauthorized', 403);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse(
                'Failed to delete user: ' .
                $e->getMessage(),
                500
            );
        }
    }
}
