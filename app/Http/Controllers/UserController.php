<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login' , 'register' , 'resetPassword' , 'changePassword' ,  'showUser' , 'users' , 'getUser']]);
    }



    public function register(Request $request){

        $this->validate($request, [
            'first_name' => 'required|string|between:2,50',
            'last_name' => 'required|string|between:2,50',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|max:25'
        ]);

        try{

            $user = new User;
              $user->first_name = $request->input('first_name');
              $user->last_name = $request->input('last_name');
              $user->email = $request->input('email');
              $password = $request->input('password');
              $user->password = app('hash')->make($password);

              if($user->save()){
                  $input = $request->only('first_name','last_name','email','password');

                  if($authorized = Auth::attempt($input)) {
                      $token = $this->respondWithToken($authorized);
                      $output = [
                          'status' => true,
                          'message' => 'Register done successfully',
                          'user' => $user,
                          'data' => $token,
                      ];
                  }else{
                      $output = [
                          'status' => false,
                          'message' => 'Failed to register',
                          'user' => null,
                          'data' => null,
                      ];
                  }

              }else{
                  $output = [
                      'status' => false,
                      'message' => 'Error, registration was not completed successfully',
                      'user' => null,
                  ];
              }


          }catch(Exception $e){

              $output = [
                  'status' => false,
                  'message' => $e->getMessage(),
                  'data' => null
              ];


          }


          return response()->json($output);

    }


    public function login(Request $request){

        $this->validate($request, [
          'email' => 'required|email',
          'password' => 'required|string'
        ]);

        $input = $request->only('email', 'password');

        if($authorized = Auth::attempt($input)){

            $token = $this->respondWithToken($authorized);

            $output = [
                'status' => true,
                'message' => 'Login done successfully',
                'user' => Auth::user(),
                'data' => $token,
            ];
        }else{

            $output = [
                'status' => false,
                'message' => "You are not authorized , make sure you have entered the right information's",
                'user' => null,
                'data' => null,
            ];

        }

     return response()->json($output);

    }

    public function user(){

        $user = Auth::user();

        return response()->json($user);


    }

    public function update(Request $request , $user_id){


        try{

           $user = User::where('user_id', $user_id)->first();
           $user->first_name = $request->input('first_name');
           $user->last_name = $request->input('last_name');
           $user->email = $request->input('email');


        if($user->save()){

            $output = [
                'status' => true,
                'message' => 'Update done successfully',
                'user' => $user,
            ];

        }else{

            $output = [
                'status' => false,
                'message' => 'Error occurred while updating',
                'user' => null,
            ];
        }

        }catch(Exception $e){

            $output = [
                'status' => false,
                'message' => $e->getMessage(),
                'data' => null
            ];

        }

     return response()->json($output);

    }

    public function logout(){

        $this->guard()->logout();

        $output = [
            'status' => true,
            'message' => 'Log out done successfully',
            'user' => null,
            'data' => null,
        ];

        return response()->json($output);

    }


    public function guard(): \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
    {
        return Auth::guard();
    }


    public function delete($user_id){

        $user = User::where('user_id', $user_id)->first();

      try{


        if($user->delete()){

            $output = [
                'status' => true,
                'message' => 'Delete done successfully',
                'user' => $user,
            ];

        }else{

                $output = [
                    'status' => false,
                    'message' => 'Error occurred while deleting',
                    'user' => null,
                ];
        }


      }catch(Exception $e){

          $output = [
              'status' => false,
              'message' => $e->getMessage(),
              'data' => null
          ];


     }

     return response()->json($output);

    }


    public function resetPassword(Request $request , $email){

        $user = User::where('email' , $email)->first();
        $password = $request->input('password');
        $user->password = app('hash')->make($password);

        try{

        if($user->save()){

            $output = [
                'status' => true,
                'message' => 'Reset password done successfully',
                'user' => $user,
            ];

        }else{

            $output = [
                'status' => false,
                'message' => 'Error occurred while changing password',
                'user' => null,
            ];
        }

        }catch(Exception $e){

            $output = [
                'status' => false,
                'message' => $e->getMessage(),
                'data' => null
            ];

        }

     return response()->json($output);


    }



    public function changePassword(Request $request , $user_id){

        $user = User::where('user_id', $user_id)->first();
        $password = $request->input('password');
        $user->password = app('hash')->make($password);

        try{

        if($user->save()){

            $output = [
                'status' => true,
                'message' => 'Change password done successfully',
                'user' => $user,
            ];

        }else{

            $output = [
                'status' => false,
                'message' => 'Error occurred while changing password',
                'user' => null,
            ];
        }

        }catch(Exception $e){

            $output = [
                'status' => false,
                'message' => $e->getMessage(),
                'data' => null
            ];

        }

     return response()->json($output);


    }



    public function users(){

        $user = User::all();

        $output = [
          'users' => $user
        ];

        return response()->json($output);

    }


    public function showUser($user_id){

        $user = User::where('user_id', $user_id)->first();

        return response()->json($user);

    }


    public function getUser($email){

        $user = User::where('email' , $email)->first();

        return response()->json($user);

    }



}
