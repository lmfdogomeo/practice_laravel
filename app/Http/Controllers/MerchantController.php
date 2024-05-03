<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $size = $request->size ?? 5;

        $merchants = Merchant::paginate($size);

        return response()->json($merchants);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "company_name" => "required|string|max:255",
            "company_tax_id" => "required|string|max:100|unique:merchants,company_tax_id",
            "contact_number" => "required|string|max:50",
            "address" => "required|string|max:255",
        ]);

        $merchant = new Merchant([
            "company_name" => $request->company_name,
            "company_tax_id" => $request->company_tax_id,
            "contact_number" => $request->contact_number,
            "address" => $request->address,
        ]);

        if ($merchant->save()) {
            return response()->json([
                'status' => 'Success',
                'message' => 'Successfully save',
                "data" => $merchant
            ]);
        }

        throw new Exception("Failed to add record", Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $merchant = Merchant::where([
            "uuid" => $uuid
        ])->first();

        if ($merchant) {
            return response()->json([
                'status' => 'Success',
                'message' => 'Successfully fetch',
                "data" => $merchant
            ]);
        }

        throw new Exception("No record found", Response::HTTP_NOT_FOUND);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uuid)
    {
        $request->validate([
            "company_name" => "required|string|max:255",
            // "company_tax_id" => "required|string|max:100|unique:merchants,company_tax_id",
            "contact_number" => "required|string|max:50",
            "address" => "required|string|max:255",
        ]);

        $merchant = Merchant::where([
            "uuid" => $uuid
        ])->first();

        if (!$merchant) {
            throw new Exception("Unable to update data", Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $merchant->update([
            "company_name" => $request->company_name,
            // "company_tax_id" => $request->company_tax_id,
            "contact_number" => $request->contact_number,
            "address" => $request->address,
        ]);

        if ($merchant->save()) {
            return response()->json([
                'status' => 'Success',
                'message' => 'Successfully updated',
                "data" => $merchant
            ]);
        }

        throw new Exception("Failed to update data", Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $merchant = Merchant::where([
            "uuid" => $uuid
        ])->first();

        if ($merchant && $merchant->delete()) {
            return response()->json([
                'status' => 'Success',
                'message' => 'Record has been deleted',
            ]);
        }

        throw new Exception("Unable to delete data", Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
