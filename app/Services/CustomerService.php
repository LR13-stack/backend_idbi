<?php

namespace App\Services;

use App\Models\Customer;

class CustomerService
{
    public function all()
    {
        return Customer::all();
    }

    public function create($data)
    {
        return Customer::create($data);
    }

    public function find($id)
    {
        return Customer::findOrFail($id);
    }

    public function update($data, $customer)
    {
        $customer->name = $data['name'];
        $customer->document_id = $data['document_id'];
        $customer->number_id = $data['number_id'];
        $customer->email = $data['email'];
        $customer->phone = $data['phone'];
        $customer->save();

        return $customer;
    }

    public function delete($customer)
    {
        $customer->delete();
    }
}
