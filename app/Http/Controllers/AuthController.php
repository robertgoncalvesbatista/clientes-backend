<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Registra um novo usuário via HTTP
     *
     * @param \Illuminate\Http\Request $request
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

        Mail::send("emails.test", ['user' => $user], function ($m) use ($user) {
            $m->from("robert.comunicar@gmail.com", "Robert");

            $m->to($user->email, $user->name)->subject('Your Reminder!');
        });

        $token = $user->createToken("appToken")->plainTextToken;

        $user->remember_token = $token;
        $user->save();

        $response = [
            "user" => $user,
            "token" => $token,
        ];

        return response($response, 201);
    }

    /**
     * Realiza o login do usuário via HTTP
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Valida para que os campos sejam strings obrigatórias
        // Caso não atinja um dos requisitos, não continua
        $fields = $request->validate([
            "email" => "required|string",
            "password" => "required|string",
        ]);

        // Pesquisa pelo email do usuário e guarda o resultado na variável $user
        $user = User::where("email", $fields["email"])->first();

        // Valida se a variável $user guardou algo e se as senhas batem
        // A senha passa por um hash para ser conferida com a hash no banco de dados
        // Se tudo der certo continua, senão retorna um json com "message" => "Bad creds"
        if (!$user || !Hash::check($fields["password"], $user->password)) {
            return response(["message" => "Bad creds"], 401);
        };

        // Gera um token e guarda na variável $token
        $token = $user->createToken("appToken")->plainTextToken;

        $user->remember_token = $token;
        $user->save();

        // Guarda a resposta que será enviada em caso de sucesso
        $response = [
            "user" => $user,
            "token" => $token,
        ];

        // Envia a resposta pelo HTTP
        return response($response, 201);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            "message" => "Logged out"
        ];
    }
}
