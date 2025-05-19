<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreWalletRequest;
use App\Http\Requests\UpdateWalletRequest;
use App\Models\Wallet;
use Illuminate\Http\Request;

/**
 * @group Wallets
 * 
 * APIs for managing financial wallets (CRUD).
 * This group includes endpoints to list, create, view, update, and delete wallets.
 */

class WalletController extends Controller
{
    /**
     * Display a listing of wallets with optional filters.
     * @queryParam type string Filter by wallet type (e.g. cash, bank, crypto).
     * @queryParam currency string Filter by currency code (e.g. USD, EUR).
     * @queryParam min_balance number Minimum wallet balance.
     * @queryParam max_balance number Maximum wallet balance.
     *
     * @response 200 {
     *   "message": "Filtered wallet list",
     *   "data": [
     *     { "id": 1, "name": "Cash Wallet", "balance": 100.00, "currency": "USD", "type": "cash" }
     *   ]
     * }
     */
    public function index(Request $request)
    {
        $query = Wallet::query();

        if ($request->has('type')) {
            $query->where('type', $request->input('type'));
        }
    
        if ($request->has('currency')) {
            $query->where('currency', $request->input('currency'));
        }
    
        if ($request->has('min_balance')) {
            $query->where('balance', '>=', $request->input('min_balance'));
        }
    
        if ($request->has('max_balance')) {
            $query->where('balance', '<=', $request->input('max_balance'));
        }
    
        return response()->json([
            'message' => 'Filtered wallet list',
            'data' => $query->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created wallet in storage.
     * @bodyParam name string required The wallet name.
     * @bodyParam balance number required The current balance.
     * @bodyParam currency string required The currency code (e.g. USD).
     * @bodyParam type string required The wallet type (e.g. cash, crypto).
     * @response 201 {
     *   "id": 3,
     *   "name": "Crypto Wallet",
     *   "balance": 1200.00,
     *   "currency": "USD",
     *   "type": "crypto",
     * }
     */
    public function store(StoreWalletRequest $request)
    {
        $validated=$request->validate([
            'name'=>'required|string',
            'balance'=>'required|numeric',
            'currency' => 'required|string|max:3',
            'type' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $wallet = Wallet::create($validated);
        return response()->json([
            'message'=>'Wallet created succesfully',
            'data'=>$wallet->load('category'),
        ],201);
    }

    /**
     * Display the specified wallet.
     * @urlParam id integer required The ID of the wallet.
     * @response 200 {
     *   "id": 1,
     *   "name": "Cash Wallet",
     *   "balance": 100.00,
     *   "currency": "USD",
     *   "type": "cash",
     *   "notes": null
     * }
     */
    public function show(Wallet $wallet)
    { 
        return response()->json([
            'message'=>'Wallet details',
            'data' =>$wallet
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wallet $wallet)
    {
        //
    }

    /**
     * Update the specified wallet in storage.
     * @urlParam id integer required The ID of the wallet.
     * @bodyParam name string optional The wallet name.
     * @bodyParam balance number optional The current balance.
     * @bodyParam currency string optional The currency code.
     * @bodyParam type string optional The wallet type.
     */
    public function update(UpdateWalletRequest $request, Wallet $wallet)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string',
            'balance' => 'sometimes|numeric',
            'currency' => 'sometimes|string|max:3',
            'type' => 'sometimes|string',
        ]);

        $wallet->update($validated);

        return response()->json([
            'message'=>'Wallet updated successfully',
            'data'=>$wallet->fresh()
        ]);
    }

    /**
     * Remove the specified wallet from storage.
     *  @urlParam id integer required The ID of the wallet.
    * @response 204 "No content"
     */

    public function destroy(Wallet $wallet)
    {
        $wallet->delete();
        return response()->json([
            'message' => 'Wallet deleted successfully',
            'data' => $wallet
        ]);    
    }

    /**
     * Wallet overview page (web view).
     *
     * Displays a table of all wallets with optional filtering by category.
     * This is a Blade-based frontend page, not an API endpoint.
     *
     * @queryParam category_id integer Filter wallets by category ID. Example: 2
     *
     * @return \Illuminate\View\View
     */
    public function indexView(Request $request)
    {
        $query = Wallet::query();

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $wallets = $query->with('category')->get();
        $categories = \App\Models\Category::all();

    return view('wallets.index', compact('wallets', 'categories'));
    }
    
}
