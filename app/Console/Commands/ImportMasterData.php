<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Customer;

class ImportMasterData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:masterdata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import master data from CSV file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $customerCsvUrl = Storage::disk('public')->path('customers.csv');
        $productCsvUrl = Storage::disk('public')->path('products.csv');

        $customerImported = $this->importCustomers($customerCsvUrl);
        $productImported = $this->importProducts($productCsvUrl);

        $this->info("$customerImported customer(s) imported");
        $this->info("$productImported product(s) imported");
    }

    private function importCustomers($url)
    {
        //Illuminate\Support\Facades\Log::info("customer import started");
        $csvFile = fopen($url, 'r');
        $chunkSize = 5;
        while (!feof($csvFile)) {
            $data = [];
            for ($i = 0; $i < $chunkSize && !feof($csvFile); $i++) {
                $line = fgetcsv($csvFile);

                if ($line !== false && $line !== null) {
                    if($line[0] !== "ID") {
                        $data[] = [
                            'job_title' => $line[1],
                            'name' => $line[3],
                            'email' => $line[2],
                            'registered_since' => date('Y-m-d', strtotime($line[4])),
                            'phone' => $line[5]
                        ];
                    }
                }
            }
            DB::table('customers')->insert($data);
        }
        //Illuminate\Support\Facades\Log::info("customer import finish");
    }

    private function importProducts($url)
    {
        $csvFile = fopen($url, 'r');
        $chunkSize = 5;
        while (!feof($csvFile)) {
            $data = [];
            for ($i = 0; $i < $chunkSize && !feof($csvFile); $i++) {
                $line = fgetcsv($csvFile);

                if ($line !== false && $line !== null) {
                    if($line[0] !== "ID") {
                        $data[] = [
                            'product_name' => $line[1],
                            'price' => $line[2]
                        ];
                    }
                }
            }
            DB::table('products')->insert($data);
        }
    }
}
