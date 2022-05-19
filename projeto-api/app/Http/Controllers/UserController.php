<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;



class UserController extends Controller
{

    protected $user;

     function __construct(User $user, Wallet $wallet)
    {
        $this->user = $user;
        $this->wallet = $wallet;

    }  
     
     
     public function store(StoreUserRequest $request){


       $dados = $request->all();
       
       try{
           DB::beginTransaction();

           $data = $this->user->create($dados);
           if($data) $returnType = $this->user->inserTypetUser($dados['type_user'],$data['id']);
           
           if (!$returnType) {
                DB::rollBack();
                return response()->json('Pemitido apenas no type_user "common" e "sales"', 401);
           }
           
           $dados['sale'] = 0.00;
           $dados['id_user'] = $data['id'];
           $this->wallet->create($dados);
           DB::commit();
           return response()->json('sucesso', 201);

       } catch (\Exception $e) {
            DB::rollBack();
           return response()->json(['messege' => $e->getMessage()], 500);
       }
        

    }

    public function update(StoreUserRequest $request, $id){
      
        $dados = $request->all();

        $userId = $this->user->returnById($id);

        if (!$userId->all()) return response()->json('Usuario não cadastrado', 500);

        $user = $this->user->updateUser($dados, $id);
        if (!$user) return response()->json('Usuario não atualizado', 500);

        return response()->json('Sucesso', 201);

    }

    public function delete(int $id){

        $userId = $this->user->returnById($id);

        if (!$userId->all()) return response()->json('Usuario não cadastrado', 500);

        $deleteId = $this->user->deleteById($id);
        
        if(!$deleteId) return response()->json('Usuario não deletado', 500);

        return response()->json('Sucesso', 201);

    } 

    public function index(){

        return response()->json($this->user->all());

    }

    public function show(int $id){

        $userId = $this->user->returnById($id);
        return response()->json($userId);
        
    } 

    public function showEmail(string $email){
    
        $userEmail = $this->user->returnByEmail($email);
        return response()->json($userEmail);
        
    } 

    public function showDocument(string $document){

        $userDocument = $this->user->returnByDocument($document);
        return response()->json($userDocument);
        
    }
}
