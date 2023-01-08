<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Create the repository instance
     */
    public function __construct()
    {
        //
    }

    public function getAll()
    {
        $users = User::all();

        $response = [];
        foreach ($users as $user) {
            $customers = User::with('customers')->findOrFail($user->id);
            array_push($response, $customers);
        }

        return $response;
    }

    public function create(array $data)
    {
        $data['password'] = bcrypt($data['password']);

        return User::create($data);
    }

    public function findById(int $id)
    {
        // Busca o cliente pelo seu ID
        $user = User::find($id);

        // Mostra os dados do cliente com o endereço
        return User::with('customers')->findOrFail($user->id);
    }

    public function edit(array $data, int $id)
    {
        return User::where('id', $id)->update($data);
    }

    public function delete(int $id)
    {
        return User::destroy($id);
    }
}
