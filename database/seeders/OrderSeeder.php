<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\BulkOrder;
use App\Models\FittingOrder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::all();

        foreach ($customers as $customer) {

            if ($customer->type === 'bulk') {

                BulkOrder::create([
                    'order_id' => 'BO-' . str_pad($customer->id, 4, '0', STR_PAD_LEFT),
                    'customer_id' => $customer->id,
                    'customer_name' => $customer->name,
                    'company_name' => $customer->company_name,
                    'mobile' => $customer->mobile,
                    'product_name' => 'School Uniform',
                    'product_description' => 'Bulk uniform order',
                    'fabric' => 'Cotton',
                    'color' => 'Blue',
                    'size_breakdown' => json_encode([
                        'S' => 50,
                        'M' => 100,
                        'L' => 50
                    ]),
                    'quantity' => 200,
                    'unit_price' => 300,
                    'advance_paid' => 10000,
                    'discount_amount' => 2000,
                    'delivery_date' => now()->addDays(15),
                    'delivery_address' => $customer->address,
                    'status' => 'confirmed',
                    'invoice_number' => 'INV-' . $customer->id,
                    'gst_percent' => 18,
                    'notes' => 'Seeded bulk order',
                ]);

            } else {

                FittingOrder::create([
                    'order_id' => 'FO-' . str_pad($customer->id, 4, '0', STR_PAD_LEFT),
                    'customer_id' => $customer->id,
                    'customer_name' => $customer->name,
                    'mobile' => $customer->mobile,
                    'product_name' => 'Designer Suit',
                    'style' => 'Wedding',
                    'product_description' => 'Custom stitching',
                    'fabric' => 'Silk',
                    'color' => 'Maroon',
                    'total_amount' => 5000,
                    'advance_paid' => 2000,
                    'delivery_date' => now()->addDays(10),
                    'trial_date' => now()->addDays(5),
                    'status' => 'stitching',
                    'notes' => 'Seeded fitting order',
                ]);
            }
        }
    }
}
