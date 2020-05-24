<?php

namespace App\Console\Commands;

use Alexusmai\YandexMetrika\YandexMetrika;
use App\Models\Stats;
use App\Models\StatValues;
use Carbon\Carbon;
use Illuminate\Console\Command;

class metrika extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:metrika';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        $yandexMetrika = new YandexMetrika();

        $hosts = 0;

        $hosts = $this->getSummary($yandexMetrika,$hosts);
        $this->getNewUsers($yandexMetrika);
        $total = $this->getother($yandexMetrika);

        $alias = 'other';
        $stats = Stats::getStatByAlias($alias);
        $value = $total - $hosts;
        StatValues::storeValue($stats->id,$value);
    }

    public function getother($yandexMetrika)
    {
        $startDate = Carbon::today();
        $endDate = Carbon::today();

        $urlParams = [
            'ids' => env('YANDEX_COUNTER_ID'),
            'date1' => $startDate->format('Y-m-d'),
            'date2' => $endDate->format('Y-m-d'),
            'metrics' => 'ym:s:visits',
        ];

        $response = $yandexMetrika->getRequestToApi($urlParams);

        $total = $response->data['totals'][0];

        return (int) $total;
    }
    public function getNewUsers($yandexMetrika)
    {
        $startDate = Carbon::today();
        $endDate = Carbon::today();

        $urlParams = [
            'ids' => env('YANDEX_COUNTER_ID'),
            'date1' => $startDate->format('Y-m-d'),
            'date2' => $endDate->format('Y-m-d'),
            'metrics' => 'ym:s:visits,ym:s:users',
            'filters' => "ym:s:isNewUser=='Yes'",
        ];

        $response = $yandexMetrika->getRequestToApi($urlParams);
        $statAlias = 'yandex_search';

        foreach ($response->data['data'] as $item) {
            $stats = Stats::getStatByAlias($statAlias);
            $value = (int)$item['metrics'][0];
            StatValues::storeValue($stats->id,$value);
        }
    }

    public function getSummary($yandexMetrika,$hosts)
    {
        $statAliases = [ 'Yandex: Direct', 'Yandex' ];
        $response = $yandexMetrika->getSourcesSummary(0)->adapt();

        foreach ($response->data['data'] as $item) {
            foreach ($statAliases as $alias) {
                if ( $item['dimensions'][1]['name'] == $alias) {
                    $stats = Stats::getStatByAlias($alias);
                    $value = (int) $item['metrics'][0];
                    $hosts += $value;
                    StatValues::storeValue($stats->id,$value);
                }
            }
        }

        return $hosts;
    }
}
