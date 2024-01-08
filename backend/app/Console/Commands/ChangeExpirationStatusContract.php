<?php

namespace App\Console\Commands;

use App\Models\ContractOffer;
use Illuminate\Console\Command;
use App\Services\ContractOfferService;
use Illuminate\Support\Facades\Log;

class ChangeExpirationStatusContract extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set-expiration-status:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto scan and update status if offer expired';

    /**
     * @var  App\Services\ContractOfferService contractOfferService
     */
    protected $contractOfferService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ContractOfferService $contractOfferService)
    {
        parent::__construct();
        $this->contractOfferService = $contractOfferService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $contractOffer = $this->contractOfferService->getExpirationOfferIds();
        try {
            if ($contractOffer->count() > 0) {
                foreach ($contractOffer as $offer) {
                    $offer->status = ContractOffer::EXPIRED_STATUS;
                    $offer->save();
                }
            }
            Log::info('Update expiration contract status successfully!');
        } catch (\Exception $e) {
            Log::error('Error update expiration contract job: ' . $e->getFile() . ' - '. $e->getMessage());
        }
    }
}
