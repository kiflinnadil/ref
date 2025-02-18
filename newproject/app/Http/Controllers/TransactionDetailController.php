<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use App\Models\ProductTransaction;

class TransactionDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'post_code' => 'required|string|max:10',
            'city' => 'required|string|max:100',
            'notes' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'promo_code_id' => 'nullable|exists:promo_codes,id',
            'payment_id' => 'required|exists:payments,id',
        ]);

        $product = Product::findOrFail($request->product_id);

        $promoCode = PromoCode::find($request->promo_code_id);
        $discountAmount = $promoCode ? $promoCode->discount_amount : 0;

        $totalPrice = $product->price * $validated['quantity'] - $discountAmount;

        $transaction = ProductTransaction::create([
            'user_id' => $request->user()->id,
            'product_name' => $product->name,
            'phone_number' => $validated['phone_number'],
            'address' => $validated['address'],
            'post_code' => $validated['post_code'],
            'city' => $validated['city'],
            'notes' => $validated['notes'],
            'quantity' => $validated['quantity'],
            'sub_total_amount' => $product->price * $validated['quantity'],
            'total_amount' => $totalPrice,
            'is_paid' => false,
            'payment_id' => $validated['payment_id'],
            'promo_code_id' => $validated['promo_code_id'],
        ]);

        TransactionDetail::create([
            'product_id' => $product->id,
            'product_transaction_id' => $transaction->id,
            'product_name' => $product->name,
            'quantity' => $validated['quantity'],
            'price' => $product->price,
        ]);

        $product->update([
            'stock' => $product->stock - $validated['quantity'],
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dibuat.');
    }


    /**
     * Display the specified resource.
     */
    public function show(TransactionDetail $transactionDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransactionDetail $transactionDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransactionDetail $transactionDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransactionDetail $transactionDetail)
    {
        //
    }
}
