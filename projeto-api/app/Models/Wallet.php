<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use HasFactory,SoftDeletes;

    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'sale'
    ];

    public function returnWallet(int $idUser){

        return  DB::table('wallets')
                   ->join('users', 'users.id_user', '=', 'wallets.id_user')
                   ->where('wallets.id_user', $idUser)
                   ->get();
                   
    }

    public function returnWalletAll(){

        return DB::table('wallets')->get();

    }

    public function updateWallet(float $walletSale, int $idUser) {

        $wallet = DB::table('wallets')
                ->where('id_user', $idUser)
                ->update(
                    ['sale' => $walletSale]
                );
        
        return $wallet;
    }

}
