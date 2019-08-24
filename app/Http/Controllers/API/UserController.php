<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
class UserController extends Controller 
{
public $successStatus = 200;
/** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
	  public function providerlogin(){
	    $p = request('provider');
		$p_id = request('provider_id');
	    if(isset($p)&& isset($p)){
		$authUser = User::where('provider','=', request('provider'))->where('provider_id','=', request('provider_id'))->first(); 
        if($authUser){
			//$user = Auth::loginUsingId($authUser->id);
            $success['token'] =$authUser->api_token;  
			//$user->api_token = $success['token'];
			//$user->save();
            return response()->json(['success' => $success], $this-> successStatus); 
		}else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 	
		}else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }
    public function login(){		
		if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] = $user->api_token; 
			//$user->api_token = $success['token'];
			//$user->save();
            return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 		
    }
/** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required', 
            'c_password' => 'required|same:password', 
        ]);
if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
$input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        $success['name'] =  $user->name;
		$user->api_token = $success['token'];
		$user->save();
return response()->json(['success'=>$success], $this-> successStatus); 
    }
/** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details(Request $request) 
    { 
        $header = $request->header('Authorization');
		$header = str_replace("Bearer ", "", $header);
		$user = User::where('api_token','=',$header)->with('recipes')->with('ingredients')->get(); 
        return response()->json(['success' => $user], $this-> successStatus); 
    } 
}