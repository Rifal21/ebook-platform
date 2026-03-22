<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ebook;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Exception;

class CheckoutController extends Controller
{
    public function show(Ebook $ebook)
    {
        return view('checkout', compact('ebook'));
    }

    public function process(Request $request, Ebook $ebook)
    {
        $request->validate([
            'terms' => 'required|accepted'
        ], [
            'terms.required' => 'Anda harus menyetujui syarat & ketentuan sebelum melanjutkan.',
            'terms.accepted' => 'Anda harus menyetujui syarat & ketentuan sebelum melanjutkan.'
        ]);

        $serverKey = env('MIDTRANS_SERVER_KEY');
        $isProduction = env('MIDTRANS_IS_PRODUCTION', false);

        $order = Order::create([
            'invoice_number' => 'INV-' . date('ymd') . '-' . strtoupper(Str::random(5)),
            'user_id' => Auth::id(),
            'ebook_id' => $ebook->id,
            'total_amount' => $ebook->price,
            'status' => 'pending'
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => $order->invoice_number,
                'gross_amount' => $ebook->price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'item_details' => [
                [
                    'id' => $ebook->id,
                    'price' => $ebook->price,
                    'quantity' => 1,
                    'name' => substr($ebook->title, 0, 50)
                ]
            ]
        ];

        try {
            $url = $isProduction 
                ? 'https://app.midtrans.com/snap/v1/transactions' 
                : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . base64_encode($serverKey . ':'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->post($url, $params);

            if ($response->successful()) {
                return response()->json(['snapToken' => $response->json('token')]);
            }

            return response()->json(['error' => 'Gagal membuat transaksi: ' . $response->body()], 500);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
