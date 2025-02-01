<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'name' => 'John Doe',
                'document_id' => 'DNI',
                'number_id' => '12345678',
                'email' => 'johnDoe@test.com',
                'phone' => '987654321',
            ],
            [
                'name' => 'Jane Doe',
                'document_id' => 'RUC',
                'number_id' => '87654321',
                'email' => 'janeDoe@test.com',
                'phone' => '123456789',
            ],
            [
                'name' => 'John Smith',
                'document_id' => 'DNI',
                'number_id' => '12345679',
                'email' => 'johnSmith@test.com',
                'phone' => '987654322',
            ]
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
