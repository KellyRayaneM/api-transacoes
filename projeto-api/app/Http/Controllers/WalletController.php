<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet as Wallet;
use App\Models\User as User;
use App\Models\Transaction as Transaction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client; 
use GuzzleHttp\Handler\CurlFactory;

class WalletController extends Controller
{
    
    protected $wallet;

     function __construct(Wallet $wallet, User $user, Transaction $transaction)
    {
        $this->wallet = $wallet;
        $this->user = $user;
        $this->transaction = $transaction;

    } 
    
    
    public function index()
    {
        return response()->json($this->wallet->returnWalletAll());
    }

    public function show(int $id)
    {

        $walletDados = $this->wallet->returnWallet($id)->all();
       
        if(empty($walletDados)) return response()->json('User não encontrado', 404);

        return response()->json($walletDados);
    }

    public function withdraw(Request $request)
    {
       
        $dadosRequest = $request->all();

        $this->validate($request, ['id_user' => 'required|integer',
                                    'sale' => 'required|numeric|min:0.01',
                                    'password' => 'required']);
       
        $userId = $this->user->returnById($dadosRequest['id_user']);
     
        if (!$userId->all()) return response()->json('User não encontrado', 404);

        if ($userId[0]->password !=$request->password) return response()->json('Senha não confere.', 401);

        $walletDados = $this->wallet->returnWallet($request->id_user)->all();
          
        if ($dadosRequest['sale'] >= $walletDados[0]->sale) return response()->json('Saldo insufuciente', 401);
        
        try{
          
            $walletDados[0]->sale -= $dadosRequest['sale'];

            DB::beginTransaction();

            $this->wallet->updateWallet($walletDados[0]->sale, $walletDados[0]->id_user);
            $this->transaction->insertTransactionWithdraw($dadosRequest['sale'], $walletDados[0]->id_user); 

            DB::commit();
            return response()->json('sucesso', 201);
        } catch (\Exception $e) {         
            DB::rollBack();  
            return response()->json(['messege' => $e->getMessage()], 500);
        }
        
        return response()->json($walletDados);
    }
    
    
    public function deposit(Request $request)
    {
        $dadosRequest = $request->all();

        $this->validate($request, ['id_user' => 'required|integer',
                                    'sale' => 'required|numeric|min:0.01',
                                    'password' => 'required']);

        $userId = $this->user->returnById($dadosRequest['id_user']);

        if (!$userId->all()) return response()->json('User não encontrado', 404);

        if ($userId[0]->password !=$request->password) return response()->json('Senha não confere.', 401);

        $walletDados = $this->wallet->returnWallet($request->id_user)->all();
        
        $walletDados[0]->sale += $dadosRequest['sale'];

        try{

            DB::beginTransaction();
            
            $wallet = $this->wallet->updateWallet($walletDados[0]->sale, $walletDados[0]->id_user);
            $this->transaction->insertTransactionDeposit($dadosRequest['sale'], $walletDados[0]->id_user); 
           
            DB::commit();
            return  response()->json('sucesso', 201);
           
        } catch (\Exception $e) {
        
            DB::rollBack();
            return response()->json(['messege' => $e->getMessage()], 500);
        }

    }
  
    public function transfer(Request $request)
    {
        $response = Http::get('http://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6', $request);
      
        if(!$response->ok()) return response()->json('Unauthorized', 401);
      
        $this->validate($request, [
            'id_user_in' => 'required|integer',
            'id_user_out' => 'required|integer',
            'value' => 'required|numeric|min:0.01'
        ]);

        $userIdIn = $this->user->returnById($request->id_user_in);

        if (!$userIdIn->all()) return response()->json('Usuario de entrada não cadastrado', 500);

        $userIdOut = $this->user->returnById($request->id_user_in);

        if (!$userIdOut->all()) return response()->json('Usuario de saida não cadastrado', 500);

        if ($request->id_user_in == $request->id_user_out) {
            return response()->json('Não é permitido fazer transferência apra si.', 403);
        } 

        $id_user_in = $this->wallet->returnWallet($request->id_user_in)->all();
        $id_user_out = $this->wallet->returnWallet($request->id_user_out)->all();
  
        if ($id_user_in[0]->password != $request->password) return response()->json('Senha não confere.', 401);

        if (!$id_user_in) return response()->json( 'Usuário não econtrado', 404);
        if (!$id_user_out) return response()->json('Usuário não econtrado, por favor registre uma conta.', 404);

        $userCommom = $this->user->returnByIdUserCommum($request->id_user_out)->all();
      
        if(!$userCommom) return response()->json('Transferência de envio não permitida pra esse tipo de usuário.', 401);

        if ($id_user_out[0]->sale <= $request->value) return response()->json('Saldo insufuciente', 401);

        try{

            DB::beginTransaction();

            $transition = $this->transaction->insertTransactionTransfer($request->all());
            $id_user_in[0]->sale += $request->value;
            $id_user_out[0]->sale -= $request->value;
            $this->wallet->updateWallet($id_user_in[0]->sale, $request->id_user_in);
            $this->wallet->updateWallet($id_user_out[0]->sale, $request->id_user_out);

            DB::commit();

            $response = Http::get('http://o4d9z.mocklab.io/notify');
      
            if(!$response->ok()) return response()->json('Fail', 401);

            return response()->json('sucesso', 201);
        }catch(\Exception $e) {
            
            DB::rollBack();
            return response()->json('Unable to transfer', 501);
        }
    }
}
