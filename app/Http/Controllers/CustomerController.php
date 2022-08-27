<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Busca pelos dados de todos os clientes no banco de dados
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customers = Customer::all();

        $data = array();
        foreach ($customers as $customer) {
            $address = Customer::with("address")->findOrFail($customer->id);
            array_push($data, $address);
        }

        return response($data, 201);
    }

    /**
     * Cria e guarda um novo cliente no banco de dados
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $fields = $request->validate([
            "name" => "required|string",
            "cpf" => "required|string",
            "category" => "string",
            "cep" => "required|string",
            "rua" => "string",
            "bairro" => "string",
            "cidade" => "string",
            "uf" => "string",
            "complemento" => "string",
            "telephone" => "string",
        ]);

        $fields["cpf"] = str_replace(["-", "."], "", $fields["cpf"]);

        // Primeira parte da validação do CPF
        $numbers = [];
        for ($i = 0, $j = 10; $i < 9; $i++, $j--) {
            $digit = $fields["cpf"][$i];

            array_push($numbers, $digit * $j);
        }

        $resultFirstVerification = (array_sum($numbers) * 10) % 11;

        if ($resultFirstVerification != $fields["cpf"][9]) {
            return response(["message" => "Este CPF não é válido!"], 401);
        }

        // Segunda parte da validação do CPF
        $numbers = [];
        for ($i = 0, $j = 11; $i < 10; $i++, $j--) {
            $digit = $fields["cpf"][$i];

            array_push($numbers, $digit * $j);
        }

        $resultSecondVerification = (array_sum($numbers) * 10) % 11;

        if ($resultSecondVerification != $fields["cpf"][10]) {
            return response(["message" => "Este CPF não é válido!"], 401);
        }

        // Cria o cliente
        $customer = Customer::create([
            "name" => $fields["name"],
            "cpf" => $fields["cpf"],
            "category" => $fields["category"],
            "telephone" => $fields["telephone"],
        ]);

        // Cria o endereço do cliente
        Address::create([
            "cep" => $fields["cep"],
            "rua" => $fields["rua"],
            "bairro" => $fields["bairro"],
            "cidade" => $fields["cidade"],
            "uf" => $fields["uf"],
            "complemento" => $fields["complemento"],
            "id_customer" => $customer->id,
        ]);

        // Relaciona o cliente ao usuário autenticado
        $user = $request->user();
        $user->customers()->attach($customer);

        // Busca os dados do cliente com o endereço relacionado
        $response = Customer::with("address")->findOrFail($customer->id);

        return response($response, 201);
    }

    /**
     * Busca pelos dados de um cliente
     * 
     * @param  Number  $id
     * @return \Illuminate\Http\Response
     */
    public function read($id)
    {
        // Busca o cliente pelo seu ID
        $customer = Customer::find($id);

        // Guarda os dados do cliente com o endereço
        $response = Customer::with("address")->findOrFail($customer->id);

        return response($response, 201);
    }

    /**
     * Atualiza os dados de um cliente
     *
     * @param  \Request  $request
     * @param  Number  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            "name" => "required|string",
            "cpf" => "required|string",
            "category" => "string",
            "cep" => "required|string",
            "rua" => "string",
            "bairro" => "string",
            "cidade" => "string",
            "uf" => "string",
            "complemento" => "string",
            "telephone" => "string",
        ]);

        $fields["cpf"] = str_replace(["-", "."], "", $fields["cpf"]);

        // Primeira parte da validação do CPF
        $numbers = [];
        for ($i = 0, $j = 10; $i < 9; $i++, $j--) {
            $digit = $fields["cpf"][$i];

            array_push($numbers, $digit * $j);
        }

        $resultFirstVerification = (array_sum($numbers) * 10) % 11;

        if ($resultFirstVerification != $fields["cpf"][9]) {
            return response(["message" => "Este CPF não é válido!"], 401);
        }

        // Segunda parte da validação do CPF
        $numbers = [];
        for ($i = 0, $j = 11; $i < 10; $i++, $j--) {
            $digit = $fields["cpf"][$i];

            array_push($numbers, $digit * $j);
        }

        $resultSecondVerification = (array_sum($numbers) * 10) % 11;

        if ($resultSecondVerification != $fields["cpf"][10]) {
            return response(["message" => "Este CPF não é válido!"], 401);
        }

        // Edita e salva os dados do cliente
        $customer = Customer::find($id);

        $customer->name = $fields["name"];
        $customer->cpf = $fields["cpf"];
        $customer->category = $fields["category"];
        $customer->telephone = $fields["telephone"];

        $customer->save();

        // Edita e salva os dados do endereço do cliente
        $address = Address::where("id_customer", $id)->get();

        $address->toQuery()->update([
            'cep' => $fields["cep"],
            'rua' => $fields["rua"],
            'bairro' => $fields["bairro"],
            'cidade' => $fields["cidade"],
            'uf' => $fields["uf"],
            'complemento' => $fields["complemento"],
        ]);

        // Busca pelos dados do cliente com os dados do endereço relacionado
        $response = Customer::with("address")->findOrFail($customer->id);

        // Retornar dados
        return response($response, 201);
    }

    /**
     * Remove o cliente do banco de dados
     *
     * @param  Number  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::destroy($id);

        return response($customer, 201);
    }

    // Busca os clientes que pertencem ao usuário logado
    public function userCustomers(Request $request)
    {
        $customers = $request->user()->customers->load("address");

        return response($customers, 201);
    }

    // Busca os clientes que pertencem ao usuário logado
    public function searchCustomer(Request $request)
    {
        $customers = Customer::where("name", "like", $request->search)->with("address");

        return response($customers, 201);
    }
}
