<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuoteRequest;
use App\Models\Quote;
use Illuminate\Support\Facades\Auth;

class PublicQuoteController extends Controller
{
    /**
     * Store a newly created quote request from the contact page.
     */
    public function store(StoreQuoteRequest $request)
    {
        $data = $request->validated();
        
        // Associate user_id if the client is currently logged in
        $data['user_id'] = Auth::check() ? Auth::id() : null;
        $data['status'] = 'Nouveau';

        $quote = Quote::create($data);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Votre demande de devis a été envoyée avec succès. Nous vous répondrons sous 24h.',
                'quote'   => $quote,
            ]);
        }

        return redirect()->route('public.contact')->with('success', 'Votre demande de devis a été envoyée avec succès. Nous vous répondrons sous 24h.');
    }
}
