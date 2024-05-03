<?php

namespace App\Http\Middleware;

use App\Models\Merchant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateMerchantUuidMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $merchantId = null;
        if ($request->user()->isAdmin()) {
            $merchantId = $request->merchant_uuid;
        }
        else if ($request->user()->isMerchant()) {
            $merchantId = $request->user()->merchantUser->merchant->uuid;
        }

        $merchant = Merchant::where("uuid", $merchantId)->first();

        if ($merchant) {
            $request->merge(["merchant_id" => $merchant->id]);
            return $next($request);
        }

        return response()->json(['status' => "Not Found", "message" => "Merchant not found"], Response::HTTP_NOT_FOUND);
    }
}
