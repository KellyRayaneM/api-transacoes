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



class User extends Model
{
    use HasApiTokens,Authenticatable, HasFactory,Notifiable;
    
    public $incrementing = true;

    protected $fillable = [
        'name',
        'email',
        'type_document',
        'document',
        'password'
    ];

    protected $hidden = [
        'type_user'
    ];

    
    public function inserTypetUser(string $typeUser,int $idUser) {
        
        $tabela = "";
        if($typeUser =='common') $tabela = 'user_common';
        if($typeUser =='sales') $tabela = 'user_sales';
       
        if(empty($tabela)) return false;

        $users = DB::table($tabela)->insert([
            'id_user' => $idUser
        ]);

        
        return $users;
    }

    public function returnById(int $id) {
        
        $users = DB::table('users')->where('id_user', $id)->get();
        
        return $users;
    }

    public function returnByIdUserCommum(int $id) {
        
        $users = DB::table('users')
                        ->join('user_common', 'users.id_user', '=', 'user_common.id_user')
                        ->where('users.id_user', $id)
                        ->get();
        
        return $users;
    }

    public function returnByEmail(string $email)  {
        
        $users = DB::table('users')->where('email', $email)->get();
        return $users;
    }

    public function returnByDocument(string $document)  {

        $users = DB::table('users')->where('document', $document)->get();
        return $users;
    }

    public function updateUser(array $usuario, int $id) {

        $user = DB::table('users')
                ->where('id_user', $id)
                ->update(
                    ['email' => $usuario['email'],
                    'name' =>  $usuario['name'],
                    'password' =>  $usuario['password'],
                    'type_document' =>  $usuario['type_document'],
                    'document' =>  $usuario['document']]
                );

        return $user;
    }

    public function deleteById(int $id) {
        
        $deleted  = DB::table('users')->where('id_user', $id)->delete();
        
        return $deleted ;
    }


}
