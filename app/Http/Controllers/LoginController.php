<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\facades\Auth;
use Validator;

class LoginController extends Controller
{
// La fonction qui permet l'inscription d'un nouveau utilisateur

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'noms'=>'required',
            'email'=>'required',
            'mot_de_passe'=>'required',
            'numero_telephone'=>'required',
            'titre'=>'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),202);
        }

        try{

            $user=new User;
            $user->noms=$request->noms;
            $user->email=$request->email;
            $user->mot_de_passe=$request->mot_de_passe;
            $user->numero_telephone=$request->numero_telephone;
            $user->titre=$request->titre;

            $rep=$user->save();
            return response()->json(['state'=>$rep,'user'=>$user],200);

            }catch(Exception $e){
            return response()->json(['error'=>$e->error],404);
        }
        
    }


// c'est la fonction qui permet l'authentification d'un nouveau utilisateur dans le système

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'=>'required',
            'mot_de_passe'=>'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),202);
        }

            try{
                $user=User::where('email',$request->email)
                    ->where('mot_de_passe',$request->mot_de_passe)
                    ->first();
                if($user!=null)
                    return response()->json($user,200);
                else{
                    $rep=["error"=>"Bad request, verify you password and email"];
                    return response()->json($rep,400);
                }
            }
            catch(Exception $e){
    
            }
    }
}
