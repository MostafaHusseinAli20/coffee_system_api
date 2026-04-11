<?php

namespace App\Http\Controllers\System\Settings;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettinController extends Controller
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
        $settings = Setting::where('coffee_id', auth()->user()->coffee_id)
            ->latest()->paginate(PAGINATION_COUNT);

        if($settings->isEmpty()) {
            return $this->errorResponse('No settings found', 404);
        }

        return $this->successResponse(
            $settings,
            'Settings retrieved successfully',
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        $request->validate([
            'active_theme' => 'nullable|string',
            'active_lang' => 'nullable|string',
            'active_currency' => 'nullable|string',
            'active_timezone' => 'nullable|string',
            'active_direction' => 'nullable|string',
        ]);
        try {
            $setting = Setting::updateOrCreate(
                ['coffee_id' => auth()->user()->coffee_id],
                [
                    'active_theme' => $request->active_theme,
                    'active_lang' => $request->active_lang,
                    'active_currency' => $request->active_currency,
                    'active_timezone' => $request->active_timezone,
                    'active_direction' => $request->active_direction,
                ]
            );
            DB::commit();
            return $this->successResponse(
                'Settings updated successfully',
                200
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
        $setting = Setting::where('coffee_id', auth()->user()->coffee_id)->find($id);
        if (!$setting) {
            return $this->errorResponse('Setting not found', 404);
        }
        return $this->successResponse(
            $setting,
            'Setting retrieved successfully',
            200
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        $request->validate([
            'active_theme' => 'nullable|string',
            'active_lang' => 'nullable|string',
            'active_currency' => 'nullable|string',
            'active_timezone' => 'nullable|string',
            'active_direction' => 'nullable|string',
        ]);
        try {
            $setting = Setting::where('coffee_id', auth()->user()->coffee_id)->find($id);

            if (!$setting) {
                return $this->errorResponse('Setting not found', 404);
            }

            $setting->update([
                'active_theme' => $request->active_theme,
                'active_lang' => $request->active_lang,
                'active_currency' => $request->active_currency,
                'active_timezone' => $request->active_timezone,
                'active_direction' => $request->active_direction,
            ]);
            DB::commit();
            return $this->successResponse(
                'Setting updated successfully',
                200
            );
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $setting = Setting::where('coffee_id', auth()->user()->coffee_id)->find($id);
        if (!$setting) {
            return $this->errorResponse('Setting not found', 404);
        }
        $setting->delete();
        return $this->successResponse(
            'Setting deleted successfully',
            200
        );
    }
}
