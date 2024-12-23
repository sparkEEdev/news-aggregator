<?php

namespace App\Console\Commands;

use App\Enums\DataSources;
use Illuminate\Console\Command;
use App\Services\NewsAggregator\NewsAggregatorService;

class NewsAggregatorServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:news-aggregator-service-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $providers = DataSources::cases();

        foreach ($providers as $provider) {
            $service = new NewsAggregatorService($provider);

            $service->process();
        }

        $this->info('News aggregator service command executed successfully.');
    }
}
