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
        $user = Auth::user();

        // Check if already purchased
        $alreadyPurchased = Order::where('user_id', $user->id)
            ->where('ebook_id', $ebook->id)
            ->whereIn('status', ['completed', 'paid', 'success'])
            ->exists();

        if ($alreadyPurchased) {
            return redirect()->route('transactions')->with('error', 'Anda sudah memiliki e-book ini!');
        }

        // Validate Profile Completion
        if (empty($user->phone_number) || empty($user->address)) {
            return redirect()->route('profile')->with('status', 'profile-incomplete');
        }

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
            ],
            'callbacks' => [
                'finish' => route('checkout.success')
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
                $data = $response->json();
                $order->update([
                    'snap_token' => $data['token'],
                    'payment_url' => $data['redirect_url']
                ]);

                // Send Email via Queue
                try {
                    \Illuminate\Support\Facades\Mail::to(auth()->user())
                        ->queue(new \App\Mail\PaymentLinkMail($order));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Gagal kirim email pembayaran: ' . $e->getMessage());
                }

                return response()->json([
                    'redirect' => route('transactions'),
                    'payment_url' => $data['redirect_url']
                ]);
            }

            return response()->json(['error' => 'Gagal membuat transaksi: ' . $response->body()], 500);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
