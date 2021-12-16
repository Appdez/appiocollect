<?php

namespace App\Console\Commands;

use App\Models\Benificiary;
use Illuminate\Console\Command;
use Paymentsds\MPesa\Client;
use Illuminate\Support\Str;

class SendHourlyRaport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:hourly-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send report of database data store for my mobile using Mpesa SandBox every 1 hour';

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
        $cp = Benificiary::where('neighborhood_uuid', '9a81ea14-8896-4d24-b4d7-62888aa37911')->WhereDate('created_at', now()->day)->count();
        $ma = Benificiary::where('neighborhood_uuid', 'af1103d9-7240-483e-8721-6d32d04d127e')->WhereDate('created_at', now()->day)->count();
        $maf = Benificiary::where('neighborhood_uuid', 'c3eccf0a-150b-4417-9a56-63d9d7c5c7d2')->WhereDate('created_at', now()->day)->count();
        $mu = Benificiary::where('neighborhood_uuid', '2a26a8c8-12aa-41c2-a01f-e7959dbcee98')->WhereDate('created_at', now()->day)->count();
        $in = Benificiary::where('neighborhood_uuid', '61ed1d72-01fa-488c-a83f-e3a16a0c3e0d')->WhereDate('created_at', now()->day)->count();
        $sum = $cp  + $ma + $maf  + $mu + $in;

        $client = new Client([
            'apiKey' => '83f7zvajuj5dp27aj9fsrcm1py6lqsr4',             // API Key
            'publicKey' => 'MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAmptSWqV7cGUUJJhUBxsMLonux24u+FoTlrb+4Kgc6092JIszmI1QUoMohaDDXSVueXx6IXwYGsjjWY32HGXj1iQhkALXfObJ4DqXn5h6E8y5/xQYNAyd5bpN5Z8r892B6toGzZQVB7qtebH4apDjmvTi5FGZVjVYxalyyQkj4uQbbRQjgCkubSi45Xl4CGtLqZztsKssWz3mcKncgTnq3DHGYYEYiKq0xIj100LGbnvNz20Sgqmw/cH+Bua4GJsWYLEqf/h/yiMgiBbxFxsnwZl0im5vXDlwKPw+QnO2fscDhxZFAwV06bgG0oEoWm9FnjMsfvwm0rUNYFlZ+TOtCEhmhtFp+Tsx9jPCuOd5h2emGdSKD8A6jtwhNa7oQ8RtLEEqwAn44orENa1ibOkxMiiiFpmmJkwgZPOG/zMCjXIrrhDWTDUOZaPx/lEQoInJoE2i43VN/HTGCCw8dKQAwg0jsEXau5ixD0GUothqvuX3B9taoeoFAIvUPEq35YulprMM7ThdKodSHvhnwKG82dCsodRwY428kg2xM/UjiTENog4B6zzZfPhMxFlOSFX4MnrqkAS+8Jamhy1GgoHkEMrsT5+/ofjCx0HjKbT5NuA2V/lmzgJLl3jIERadLzuTYnKGWxVJcGLkWXlEPYLbiaKzbJb2sYxt+Kt5OxQqC1MCAwEAAQ==',          // Public Key
            'serviceProviderCode' => '171717' // input_ServiceProviderCode
        ]);
        $paymentData = [
            'from' => '258847607095',       // input_CustomerMSISDN
            'reference' =>
            'CP' . $cp .
                'MA' . $ma .
                'MAF' . $maf .
                'MU' . $mu .
                'IN' . $in . Str::random(5),      // input_ThirdPartyReference
            'transaction' => Str::random(12), // input_TransactionReference
            'amount' =>    5   // input_Amount
        ];

        try {
            $client->receive($paymentData);
            $this->info('Report sent successful.');
        } catch (\Throwable $th) {
            throw $th;
            $this->info('Error sending report.');
        }
    }
}
