<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function show(Order $order)
    {
        // Check if user is owner or admin
        if (Auth::id() !== $order->user_id && !Auth::user()->is_admin) {
            abort(403);
        }

        $order->load(['user', 'ebook', 'transaction']);
        
        $pdf = Pdf::loadView('invoice-pdf', compact('order'));
        
        return $pdf->stream('Invoice-' . $order->invoice_number . '.pdf');
    }
}
