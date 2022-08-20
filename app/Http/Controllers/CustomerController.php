<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
     * Store a newly created resource in storage.
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

        return response($customer, 201);
    }

    /**
     * Display the specified resource.
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
     * Update the specified resource in storage.
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

        $customer = Customer::find($id);

        $customer->name = $fields["name"];
        $customer->cpf = $fields["cpf"];
        $customer->category = $fields["category"];
        $customer->cep = $fields["cep"];
        $customer->rua = $fields["rua"];
        $customer->bairro = $fields["bairro"];
        $customer->cidade = $fields["cidade"];
        $customer->uf = $fields["uf"];
        $customer->complemento = $fields["complemento"];
        $customer->telephone = $fields["telephone"];

        $customer->save();

        return response($customer, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Number  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::destroy($id);

        return response($customer, 201);
    }
}
