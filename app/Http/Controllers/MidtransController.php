<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Transaction;

class MidtransController extends Controller
{
    public function webhook(Request $request)
    {
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        
        if ($hashed == $request->signature_key) {
            $order = Order::where('invoice_number', $request->order_id)
                          ->orWhere('id', $request->order_id)
                          ->first();
            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                $order->update(['status' => 'paid']);
                Transaction::create([
                    'order_id' => $order->id,
                    'amount' => $request->gross_amount,
                    'payment_method' => $request->payment_type,
                    'status' => 'success',
                    'transaction_id' => $request->transaction_id
                ]);

                // Send success email via Queue
                try {
                    \Illuminate\Support\Facades\Mail::to($order->user)
                        ->queue(new \App\Mail\PaymentSuccessMail($order));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Gagal kirim email sukses pembayaran: ' . $e->getMessage());
                }
            } elseif (in_array($request->transaction_status, ['cancel', 'deny', 'expire'])) {
                $order->update(['status' => 'failed']);
            }
            return response()->json(['message' => 'Success']);
        }
        return response()->json(['message' => 'Invalid signature'], 403);
    }
}
