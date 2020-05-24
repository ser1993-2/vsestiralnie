<?php

namespace App\Console\Commands;

use App\Models\Stats;
use App\Models\StatValues;
use Illuminate\Console\Command;
use \Ixudra\Curl\CurlService;
use Symfony\Component\DomCrawler\Crawler;

class nadavi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:nadavi';

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
        $value = $this->getStatToday();
        $stat = Stats::getStatByAlias('nadavi');

        StatValues::storeValue($stat->id,$value);
    }

    public function getStatToday() {
        $curlService = new CurlService();

        $html = $curlService->to('https://nadavi.net/ban_stat.php')
            ->withData(['us'=> env('NADAVI_US'), 'pw'=> env('NADAVI_PW')])
            ->post();

        $crawler = new Crawler($html);
        $statToday = $crawler->filter('.blk > tr:nth-child(2) > td:nth-child(4)')->html();
        $statToday = str_replace('- /','', $statToday);

        return (int) trim($statToday);
    }
}
