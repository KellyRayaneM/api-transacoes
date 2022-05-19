<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;


class Transaction extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'id_user_out',
        'id_user_in',
        'value'
    ];

    public function insertTransactionDeposit(float $value ,int $idUser){
      
        $transaction = DB::table('transactions')->insert([
            'id_user_in' => $idUser,
            'value' => $value
        ]);

        return  $transaction;

    }

    public function insertTransactionWithdraw(float $value ,int $idUser){
      
        $transaction = DB::table('transactions')->insert([
            'id_user_out' => $idUser,
            'value' => $value
        ]);

        return  $transaction;

    }

    public function insertTransactionTransfer(array $transfer){
      
        $transaction = DB::table('transactions')->insert([
            'id_user_in' => $transfer['id_user_in'],
            'id_user_out' => $transfer['id_user_out'],
            'value' => $transfer['value']
        ]);

        return  $transaction;

    }

    public function returnTranstionAll(){

        return  DB::table('transactions')->get();

    }
    public function returnTranstionById(int $idUser){

       return  DB::table('transactions')
       ->where('id_user_in', $idUser)
       ->orWhere('id_user_out', $idUser)
       ->get();

    }
    
}
