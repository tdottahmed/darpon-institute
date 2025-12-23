<?php

namespace Database\Seeders;

use App\Models\PaymentGateway;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gateways = [
            [
                'name' => 'Bkash',
                'type' => 'bkash',
                'account_number' => '017XXXXXXXX',
                'account_name' => 'Darpon BD',
                'instructions' => 'Send money to this Bkash number and enter the transaction ID in the form below.',
                'order' => 1,
                'status' => true,
            ],
            [
                'name' => 'Nagad',
                'type' => 'nagad',
                'account_number' => '017XXXXXXXX',
                'account_name' => 'Darpon BD',
                'instructions' => 'Send money to this Nagad number and enter the transaction ID in the form below.',
                'order' => 2,
                'status' => true,
            ],
            [
                'name' => 'Rocket',
                'type' => 'rocket',
                'account_number' => '017XXXXXXXX',
                'account_name' => 'Darpon BD',
                'instructions' => 'Send money to this Rocket number and enter the transaction ID in the form below.',
                'order' => 3,
                'status' => true,
            ],
            [
                'name' => 'Bank Transfer',
                'type' => 'bank',
                'account_number' => '1234567890123',
                'account_name' => 'Darpon BD',
                'instructions' => 'Transfer money to the bank account mentioned above. Include your transaction reference number in the form below.',
                'order' => 4,
                'status' => true,
            ],
        ];

        foreach ($gateways as $gateway) {
            PaymentGateway::updateOrCreate(
                ['type' => $gateway['type']],
                $gateway
            );
        }
    }
}
