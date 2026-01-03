<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function callback(Request $request)
    {
        $reference = $request->query('reference');
        
        if (!$reference) {
            return redirect()->route('home')->with('error', 'No payment reference found.');
        }

        // Verify Transaction
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'Authorization' => 'Bearer ' . env('PAYSTACK_SECRET_KEY'),
        ])->get("https://api.paystack.co/transaction/verify/{$reference}");

        if ($response->successful()) {
            $data = $response->json()['data'];

            if ($data['status'] === 'success') {
                $metadata = $data['metadata'];
                $userId = $metadata['user_id'];
                $eventId = $metadata['ctf_event_id'];
                $amountPaid = $data['amount'] / 100; // Convert back to main currency unit

                // Grant Access
                \App\Models\EventAccess::firstOrCreate(
                    [
                        'transaction_reference' => $reference,
                    ],
                    [
                        'user_id' => $userId,
                        'ctf_event_id' => $eventId,
                        'amount_paid' => $amountPaid,
                        'status' => 'success',
                    ]
                );

                return redirect()->route('challenges.board', $eventId)->with('success', 'Payment successful! Access granted.');
            }
        }

    }
}
