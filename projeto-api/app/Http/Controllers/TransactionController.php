<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction as Transaction;

class TransactionController extends Controller
{

    protected $transaction;

     function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;

    }  
    
    public function index()
    {
        return response()->json($this->transaction->returnTranstionAll());
    }
  
    public function show(int $id)
    {
        return response()->json($this->transaction->returnTranstionById($id));
    }

}
