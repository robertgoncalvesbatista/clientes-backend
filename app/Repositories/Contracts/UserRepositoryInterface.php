<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    /**
     * Lista os dados de todos os usuários
     *
     * @return void
     */
    public function getAll();

    /**
     * Cria novo usuário
     *
     * @param  array  $data
     * @return void
     */
    public function create(array $data);

    /**
     * Lista os dados de um usuário
     *
     * @param  int  $id
     * @return void
     */
    public function findById(int $id);

    /**
     * Atualiza os dados de um usuário
     *
     * @param  array  $data
     * @param  int  $id
     * @return void
     */
    public function edit(array $data, int $id);

    /**
     * Deleta um usuário
     *
     * @param  int  $id
     * @return void
     */
    public function delete(int $id);
}
