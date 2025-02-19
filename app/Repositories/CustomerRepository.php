<?php

namespace App\Repositories;

use App\Helpers\HelperCPF;
use App\Models\Address;
use App\Models\Customer;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class CustomerRepository implements CustomerRepositoryInterface
{
    protected $customer;
    protected $address;

    /**
     * Create the repository instance
     *
     * @param Customer $customer
     * @param Address $address
     */
    public function __construct(Customer $customer, Address $address)
    {
        $this->customer = $customer;
        $this->address = $address;
    }

    public function getAll(int $perPage)
    {
        return $this->customer->paginate($perPage);
    }

    public function create(array $data)
    {
        if (!HelperCPF::verify($data["cpf"])) {
            throw new Exception('O CPF informado não é válido!', 404);
        }

        // Cria o endereço do cliente
        $address = $this->address
            ->create([
                'cep' => $data['cep'],
                'rua' => $data['rua'],
                'bairro' => $data['bairro'],
                'cidade' => $data['cidade'],
                'uf' => $data['uf'],
                'complemento' => $data['complemento'],
            ]);

        // Cria o cliente
        $customer = $this->customer
            ->create([
                'name' => $data['name'],
                'cpf' => $data['cpf'],
                'category' => $data['category'],
                'telephone' => $data['telephone'],
                'address_id' => $address->id,
            ]);

        // Relaciona o cliente ao usuário autenticado
        $user = Request()->user();
        $user->customers()->attach($customer);

        return $customer;
    }

    public function findById(int $id)
    {
        // Busca os dados do cliente com o endereço
        $customer = $this->customer->find($id);

        if (!$customer) {
            throw new Exception('Cliente não encontrado!', 404);
        }

        return $customer;
    }

    public function edit(array $data, int $id)
    {
        // Primeira parte da validação do CPF
        $numbers = [];
        for ($i = 0, $j = 10; $i < 9; $i++, $j--) {
            $digit = $data['cpf'][$i];

            array_push($numbers, $digit * $j);
        }

        $resultFirstVerification = (array_sum($numbers) * 10) % 11;

        if ($resultFirstVerification != $data['cpf'][9]) {
            throw new Exception('Este CPF não é válido!', 400);
        }

        // Segunda parte da validação do CPF
        $numbers = [];
        for ($i = 0, $j = 11; $i < 10; $i++, $j--) {
            $digit = $data['cpf'][$i];

            array_push($numbers, $digit * $j);
        }

        $resultSecondVerification = (array_sum($numbers) * 10) % 11;

        if ($resultSecondVerification != $data['cpf'][10]) {
            throw new Exception('Este CPF não é válido!', 400);
        }

        // Edita e salva os dados do cliente
        $customer = $this->customer->find($id);

        $customer->name = $data['name'];
        $customer->cpf = $data['cpf'];
        $customer->category = $data['category'];
        $customer->telephone = $data['telephone'];

        $customer->save();

        // Edita e salva os dados do endereço do cliente
        $this->address
            ->where('id', $customer->address_id)
            ->update([
                'rua' => $data['rua'],
                'bairro' => $data['bairro'],
                'cidade' => $data['cidade'],
                'uf' => $data['uf'],
                'cep' => $data['cep'],
                'complemento' => $data['complemento'],
            ]);

        return $customer;
    }

    public function delete(int $id)
    {
        $customer = $this->customer
            ->destroy($id);

        return $customer;
    }
}
