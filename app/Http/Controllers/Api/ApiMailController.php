<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ProductCreated;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class ApiMailController extends Controller
{
    public function sendMail()
    {
        try {
            $email = 'tin.trananh@ncc.asia';
            $product = Product::factory()->create();

            Mail::to($email)->send(new ProductCreated($product));

            return response()->json([
                'message' => 'Email has been seen',
            ], Response::HTTP_OK);
        } catch (\Throwable $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
