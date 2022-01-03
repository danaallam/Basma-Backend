<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(AdminRequest $request)
    {
        $admin = Admin::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email'    => $request->email,
            'password' => $request->password,
        ]);

        $token = auth('admin')->login($admin);

        return $this->respondWithToken($token);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('admin')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('admin')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'expires_in'   => auth('admin')->factory()->getTTL() * 60
        ]);
    }

    public function getUsers(){
        $users = User::all();
        return response()->json(['size'=>sizeof($users),'users'=>$users]);
    }

    public function filter(Request $request){
        $users = User::paginate($request->filter);
        return response()->json(['users'=>$users]);
    }

    public function registeredUsers(Request $request){
        $now = Carbon::now();
        if ($request->time == 'day'){
            $time= Carbon::yesterday();
        }
        elseif ($request->time == 'week'){
            $time = Carbon::now()->subWeek();
        }
        elseif ($request->time == 'month'){
            $time = Carbon::now()->subMonth();
        }
        elseif ($request->time == '3months'){
            $time = Carbon::now()->subMonth(3);
        }
        elseif ($request->time == 'year'){
            $time = Carbon::now()->subYear();
        }
        $users = User::where('created_at', '>=', $time)->where('created_at', '<', $now)->get();
        return response()->json(['size'=>sizeof($users),'users'=>$users]);
    }

    public function checkToken(){
        return response()->json(['status' => 200, "user"=>auth('admin')->user()]);
    }
}
