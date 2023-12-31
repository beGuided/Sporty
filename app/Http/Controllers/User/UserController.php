<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Sport;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

 

class UserController extends Controller
{


    
    public function __construct()
    {
     $this->middleware('admin')->only([ 'index','delete'  ]);
   
    }

    // get all user
    public function index() {
      $allUser = User::all();
       return response()->json( ['user' => $allUser,'status'=>true], 200);
      
    }

    //Show single user
    public function show(Request $request ) {
       $user = User::find($request->id);
        return response()->json(['user'=>$user,'status'=>true],200);
    }

    //update a user
    public function update(Request $request)
    {
            $request->validate([
            // 'name' => 'string',
            // 'user_name' => 'string',
            // 'email' => 'string',
            'name' => 'string',
            'email' => ['nullable','email', Rule::unique('users', 'email')],
            'user_name' => ['nullable', Rule::unique('users', 'user_name')],
            
        ]);

        $user =  User::find($request->id);
        $user->name = $request->name;
        $user->user_name = $request->user_name;
        $user->email = $request->email;

        $user->save();
        if ($request->has('interest')) {
            $interest = Sport::whereIn('id', $request->interest)->get();
            $user->sports()->sync($interest);
        } else {
            $user->sports()->detach();
        }
        return response()->json(['message' => 'user Update successful.',], 201); 
    }

    
    // Delete profile
    public function delete(Request $request) {  
        $user = User::find($request->id);
        if(empty( $user)){
            return response()->json(
                [ 'message' => "user do not exist",
                  'status'=>false ]);
        }
         $user->delete();
         return response()->json([ 'message'=>'User deleted successfully!','status'=>true],200);

}

}
