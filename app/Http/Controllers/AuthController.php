<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show the form for authenticate an user.
     *
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $fields = $request->validate([
            "email" => "required|string|unique:users,email",
            "password" => "required|string|confirmed",
        ]);

        $hash = bcrypt($fields["password"]);

        $user = User::where("email", $fields["email"])->first();

        if ($user->password !== $hash) {
            return response("Credentials failed! Passwords don't match.", 401);
        };

        $token = $user->createToken("appToken")->plainTextToken;

        $response = [
            "user" => $user,
            "token" => $token,
        ];

        return response($response, 201);
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $fields = $request->validate([
            "name" => "required|string",
            "email" => "required|string|unique:users,email",
            "password" => "required|string|confirmed",
        ]);

        $user = User::create([
            "name" => $fields["name"],
            "email" => $fields["email"],
            "password" => bcrypt($fields["password"]),
        ]);

        $token = $user->createToken("appToken")->plainTextToken;

        $response = [
            "user" => $user,
            "token" => $token,
        ];

        return response($response, 201);
    }
}
