<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Repositories\Contracts\UserRepositoryInterface;
use Exception;

class UserController extends Controller
{
    protected $user;

    /**
     * Create the controller instance
     *
     * @param UserRepositoryInterface $user
     */
    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\UserCollection
     */
    public function index()
    {
        try {
            $users = $this->user->getAll();

            return new UserCollection($users);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserStoreRequest  $request
     * @return \App\Http\Resources\UserResource
     */
    public function store(UserStoreRequest $request)
    {
        try {
            $validated = $request->validated();

            $user = $this->user->create($validated);

            return new UserResource($user);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \App\Http\Resources\UserResource
     */
    public function show(int $id)
    {
        try {
            $user = $this->user->findById($id);

            return new UserResource($user);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserUpdateRequest  $request
     * @param  int  $id
     * @return \App\Http\Resources\UserResource
     */
    public function update(UserUpdateRequest $request, int $id)
    {
        try {
            $validated = $request->validated();

            $user = $this->user->edit($validated, $id);

            return new UserResource($user);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            $this->user->delete($id);

            return response()->json(['message' => 'Registro removido com sucesso!'], 400);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }
}
