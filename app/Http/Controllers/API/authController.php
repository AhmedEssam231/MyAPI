<?php


namespace App\Http\Controllers\API;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class authController extends BaseController
{
 function register(Request $request){

    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required',
        'c_password' => 'required|same:password',
    ]);

    if($validator->fails()){
        return $this->sendError('Validation Error.', $validator->errors());       
    }
    $input = $request->all();
    $input['password'] =bcrypt($input['password']);

    $user= User::create($input);

    $success ['token']=$user->createToken('myapp')->plainTextToken;
    $success['name'] =$user->name;
    
    return $this->sendResponse($success, 'User register successfully.');
}


    



function login (Request $request){

    if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
    {
        $user = Auth::user();

        $success['token']=$user->createToken('myapp')->plainTextToken;
        $success['name']= $user->name;

        return $this->sendResponse($success, 'User login successfully.');
    } 
    else{ 
        return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
    } 
}

    



function delete($id){
   
    $user = User::find($id);

    $user->delete();

    return $this->sendResponse([],'User deleted successfully.');
}



}
