<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $size = $request->size ?? 5;

        $products = Product::where("merchant_id", $request->merchant_id)->paginate($size);

        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "product_name" => "required|string|max:255",
            "product_description" => "required|string",
            "price" => "required|decimal:2,10",
            "quantity" => "required|int",
        ]);

        $product = new Product([
            "product_name" => $request->product_name,
            "product_description" => $request->product_description,
            "price" => $request->price,
            "quantity" => $request->quantity,
            "merchant_id" => $request->merchant_id
        ]);

        if ($product->save()) {
            return response()->json([
                'status' => 'Success',
                'message' => 'Successfully save',
                "data" => $product
            ]);
        }

        throw new Exception("Failed to add record", Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $merchant_id, string $uuid)
    {
        $product = Product::with("merchant")->where([
            "uuid" => $uuid,
            "merchant_id" => $request->merchant_id
        ])->first();

        if ($product) {
            return response()->json([
                'status' => 'Success',
                'message' => 'Successfully fetch',
                "data" => $product,
            ]);
        }

        throw new Exception("No record found", Response::HTTP_NOT_FOUND);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $merchant_id, string $uuid)
    {
        $request->validate([
            "product_name" => "required|string|max:255",
            "product_description" => "required|string",
            "price" => "required|decimal:2,10",
            "quantity" => "required|int",
        ]);

        $product = Product::where([
            "uuid" => $uuid,
            "merchant_id" => $request->merchant_id
        ])->first();

        if (!$product) {
            throw new Exception("Unable to update data", Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $product->update([
            "product_name" => $request->product_name,
            "product_description" => $request->product_description,
            "price" => $request->price,
            "quantity" => $request->quantity,
        ]);

        if ($product->save()) {
            return response()->json([
                'status' => 'Success',
                'message' => 'Successfully updated',
                "data" => $product
            ]);
        }

        throw new Exception("Failed to update data", Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $merchant_id, string $uuid)
    {
        $product = Product::where([
            "uuid" => $uuid,
            "merchant_id" => $request->merchant_id
        ])->first();

        if ($product && $product->delete()) {
            return response()->json([
                'status' => 'Success',
                'message' => 'Product has been deleted',
            ]);
        }

        throw new Exception("Unable to delete data", Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
