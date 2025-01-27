<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $customer;

    /**
     * Create the controller instance
     *
     * @param CustomerRepositoryInterface $customer
     */
    public function __construct(CustomerRepositoryInterface $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Busca pelos dados de todos os clientes no banco de dados
     *
     * @return \App\Http\Resources\CustomerCollection
     */
    public function index(Request $request)
    {
        try {
            $data = $this->customer->getAll($request->query('per_page') ?? 10);

            return new CustomerCollection($data);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }

    /**
     * Cria e guarda um novo cliente no banco de dados
     *
     * @param  \App\Http\Requests\CustomerStoreRequest  $request
     * @return \App\Http\Resources\CustomerResource
     */
    public function store(CustomerStoreRequest $request)
    {
        try {
            $validated = $request->validated();

            $response = $this->customer->create($validated);

            return new CustomerResource($response);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }

    /**
     * Busca pelos dados de um cliente
     *
     * @param  int $id
     * @return \App\Http\Resources\CustomerResource
     */
    public function show(int $id)
    {
        try {
            $response = $this->customer->findById($id);

            return new CustomerResource($response);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }

    /**
     * Atualiza os dados de um cliente
     *
     * @param  \App\Http\Requests\CustomerUpdateRequest  $request
     * @param  int  $id
     * @return \App\Http\Resources\CustomerResource
     */
    public function update(CustomerUpdateRequest $request, int $id)
    {
        try {
            $validated = $request->validated();

            $response = $this->customer->edit($validated, $id);

            return new CustomerResource($response);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }

    /**
     * Remove o cliente do banco de dados
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            $this->customer->delete($id);

            return response()->json(['message' => 'Registro removido com sucesso'], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }

    // Busca os clientes que pertencem ao usuário logado
    public function userCustomers(Request $request)
    {
        $customers = $request->user()->customers->load('address');

        return response($customers, 201);
    }

    // Busca os clientes que pertencem ao usuário logado
    public function searchCustomer(Request $request)
    {
        $customers = Customer::where("name", "like", $request->search)->with("address");

        return response($customers, 201);
    }
}
