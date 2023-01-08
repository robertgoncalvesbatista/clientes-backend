<?php

namespace App\Repositories\Contracts;

interface CustomerRepositoryInterface
{
    /**
     * Lista os dados de todos os clientes
     *
     * @return void
     */
    public function getAll();

    /**
     * Cria novo cliente
     *
     * @param  array  $data
     * @return void
     */
    public function create(array $data);

    /**
     * Lista os dados de um cliente
     *
     * @param  int  $id
     * @return void
     */
    public function findById(int $id);

    /**
     * Atualiza os dados de um cliente
     *
     * @param  array  $data
     * @param  int  $id
     * @return void
     */
    public function edit(array $data, int $id);

    /**
     * Deleta um cliente
     *
     * @param  int  $id
     * @return void
     */
    public function delete(int $id);
}
