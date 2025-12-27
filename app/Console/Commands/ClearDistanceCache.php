<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DistanceService;
use Illuminate\Support\Facades\Cache;

class ClearDistanceCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'distance:clear-cache {--stats : Show cache statistics before clearing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear cached distance calculations from Mapbox API';

    protected $distanceService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DistanceService $distanceService)
    {
        parent::__construct();
        $this->distanceService = $distanceService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->option('stats')) {
            $this->showCacheStats();
        }

        $this->info('Clearing distance cache...');

        // Clear all distance-related cache keys
        $keys = Cache::get('distance_*');
        $clearedCount = 0;

        if ($keys) {
            foreach ($keys as $key) {
                Cache::forget($key);
                $clearedCount++;
            }
        }

        $this->info("Cleared {$clearedCount} cached distance calculations.");
        $this->info('Distance cache cleared successfully!');

        return 0;
    }

    private function showCacheStats()
    {
        $this->info('Distance Cache Statistics:');
        $this->line('------------------------');

        $keys = Cache::get('distance_*');
        $count = $keys ? count($keys) : 0;

        $this->line("Total cached distances: {$count}");

        if ($count > 0) {
            $this->line('Sample cache keys:');
            $sampleKeys = array_slice($keys, 0, 5);
            foreach ($sampleKeys as $key) {
                $this->line("  - {$key}");
            }

            if ($count > 5) {
                $this->line("  ... and " . ($count - 5) . " more");
            }
        }

        $this->line('');
    }
}
