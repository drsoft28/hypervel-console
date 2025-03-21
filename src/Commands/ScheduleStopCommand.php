<?php

declare(strict_types=1);

namespace Hypervel\Console\Commands;

use Hypervel\Cache\Contracts\Factory as CacheFactory;
use Hypervel\Console\Command;
use Hypervel\Support\Facades\Date;

class ScheduleStopCommand extends Command
{
    /**
     * The console signature name.
     */
    protected ?string $signature = 'schedule:stop
        {--minutes=1 : Ttl in minutes for the stop signal}
    ';

    /**
     * The console command description.
     */
    protected string $description = 'Stop the current schedule workers';

    /**
     * Create a new schedule interrupt command.
     *
     * @param CacheFactory $cache the cache store implementation
     */
    public function __construct(
        protected CacheFactory $cache
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /* @phpstan-ignore-next-line */
        $this->cache->put(
            'hypervel:schedule:stop',
            true,
            Date::now()->addMinutes((int) $this->option('minutes'))
        );

        $this->info('Broadcasting schedule stop signal.');
    }
}
