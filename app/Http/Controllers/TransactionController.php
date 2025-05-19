<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use Illuminate\Http\Request;

/**
 * @group Transactions
 *
 * Manage income and expense transactions for wallets.
 */
class TransactionController extends Controller
{
    /**
     * Display a listing of the transaction with filtering.
     * @queryParam wallet_id integer Filter by wallet ID.
     * @queryParam category_id integer Filter by category ID.
     * @queryParam type string Filter by transaction type (e.g. deposit, withdrawal).
     * @response 200 {
     *   "message": "Filtered transaction list",
     *   "data": [
     *     {
     *       "id": 1,
     *       "wallet_id": 1,
     *       "category_id": 2,
     *       "type": "deposit",
     *       "amount": 50.00,
     *       "description": "Paycheck"
     *     }
     *   ]
     * }
     */
    public function index(Resquest $request)
    {
        $query = Transaction::query();

        if ($request->has('wallet_id')) {
            $query->where('wallet_id', $request->input('wallet_id'));
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->has('type')) {
            $query->where('type', $request->input('type'));
        }

        return response()->json([
            'message' => 'Filtered transaction list',
            'data' => $query->get()
        ]);
    }

    /**
     * Store a newly created transaction in storage.
     * 
     * @bodyParam wallet_id integer required The wallet this transaction belongs to.
     * @bodyParam category_id integer optional The category of the transaction.
     * @bodyParam type string required The transaction type (deposit or withdrawal).
     * @bodyParam amount number required The amount of the transaction.
     * @bodyParam description string optional Description of the transaction.
     * @response 201 {
     *   "message": "Transaction created",
     *   "data": {
     *     "id": 4,
     *     "wallet_id": 1,
     *     "type": "withdrawal",
     *     "amount": 30.00,
     *     "description": "Groceries"
     *   }
     * }
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'wallet_id' => 'required|exists:wallets,id',
            'category_id' => 'nullable|exists:categories,id',
            'type' => 'required|string',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $transaction = Transaction::create($validated);

        return response()->json([
            'message' => 'Transaction created',
            'data' => $transaction
        ], 201);
    }

    /**
     * Display the specified transaction.
     * @urlParam id integer required The ID of the transaction.
     * @response 200 {
     *   "message": "Transaction details",
     *   "data": {
     *     "id": 1,
     *     "wallet_id": 1,
     *     "type": "deposit",
     *     "amount": 100.00,
     *     "description": "Bonus"
     *   }
     * }
     */
    public function show(Transaction $transaction)
    {
        return response()->json([
            'message' => 'Transaction details',
            'data' => $transaction
        ]);

    }

    /**
     * Update the specified transaction in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'wallet_id' => 'sometimes|exists:wallets,id',
            'category_id' => 'nullable|exists:categories,id',
            'type' => 'sometimes|string',
            'amount' => 'sometimes|numeric',
            'description' => 'nullable|string',
        ]);

        $transaction->update($validated);

        return response()->json([
            'message' => 'Transaction updated',
            'data' => $transaction->fresh()
        ]);
    }

    /**
     * Remove the specified transaction from storage.
     * @urlParam id integer required The ID of the transaction.
     * @response 200 {
     *   "message": "Transaction deleted",
     *   "data": {
     *     "id": 1,
     *     "wallet_id": 1,
     *     "type": "withdrawal",
     *     "amount": 20.00,
     *     "description": "Lunch"
     *   }
     * }
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return response()->json([
            'message' => 'Transaction deleted',
            'data' => $transaction
        ]);
    }
}
