<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class StoreUserRequest extends FormRequest
{
   
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:10|max:255',
            'email' => self::emailRules(['required', 'email'], true),
            'document' => self::documentRules(['required'], true),
            'type_document' => 'required',
            'type_user' => 'required',
            'password' => 'required|min:6',
        ];
    }



    private static function emailRules(array $rules = [], bool $unique = false){
        $validEmailUnique = function ($attribute, $value, $fail) use ($unique) {

            if(!$unique) return;

            $data = User::where([$attribute => $value])->get()->first();

            if($data) {
                $fail($attribute.'already registered.');
            }
        };

        array_push($rules, $validEmailUnique);
        return $rules;
    }

    private static function documentRules(array $rules = [], bool $unique = false) {
        $validCpfCnpj = function ($attribute, $value, $fail) use ($unique) {
           
            if(!$unique) return;

            $data = User::where([$attribute => $value])->get()->first();

            if($data) {
                $fail($attribute.' already registered.');
            }
        };

        array_push($rules, $validCpfCnpj);
        return $rules;
    }
}
