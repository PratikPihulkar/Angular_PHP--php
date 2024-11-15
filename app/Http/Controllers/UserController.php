<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

use App\Mail\UserRegisterMail;
use Illuminate\Support\Facades\Mail; 

class UserController extends Controller
{
   //THis function first register the user and then send email on registered email ID 

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required',
            'mobile' => 'required',
            'password' => 'required|confirmed',
            
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
            
        ]);

        //Try send mail directly After User Registration 

        $details = [
            'title' => 'Hello Mr.'.$request->name,
            'body' => 'This is a test email sent from a Lumen application.'
            ]; 

            Mail::to($request->email)->send(new UserRegisterMail($details));

        return response()->json(['message' => 'User registered successfully','email'=>$request->email], 201);
    }

    public function login() : Returntype {
        
    }





    public function getSingleUserByEmail(Request $request){

        $email=$request->email;
        

        try{
            $user = User::where('email', $email)->first();
            
                if($user){
                    return response()->json([
                        'status' => 'success',
                        'message' => [],
                        'data' => $user
                    ], 200);
                }
                else{
                    return response()->json([
                        'status' => 'error',
                        'message' => [
                            [
                                'code' => 'bad_request',
                                'msg' => 'No user details found'
                            ]
                        ],
                        'data' => []
                    ], 404);
                }
        
         } 
            catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => [
                            [
                                'code' => 'bad_request',
                                'msg' => 'An error occurred while fetching user details'
                            ]
                        ],
                    'data' => []
                ], 500);
         }
    }


}
