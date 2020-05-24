<?php

namespace App\Http\Controllers\Admin\Charts;

use App\Models\Stats;
use App\Models\StatValues;
use Backpack\CRUD\app\Http\Controllers\ChartController;
use Backpack\CRUD\app\Library\Widget;
use Carbon\Carbon;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

/**
 * Class YandexMetrikaChartController
 * @package App\Http\Controllers\Admin\Charts
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class YandexMetrikaChartController extends ChartController
{
    public function setup()
    {

        $stats = Stats::getStatByAlias('Yandex');

        $date = StatValues::convertDate(StatValues::getDateLastMounthByStatsId($stats->id));
        $value = StatValues::getValueLastMounthByStatsId($stats->id);

        $this->chart = new Chart();

        $this->chart->dataset($stats->name, 'line', $value)
            ->color('rgb(77, 189, 116)');

        // OPTIONAL
        $this->chart->displayAxes(true);
        $this->chart->displayLegend(true);

        // MANDATORY. Set the labels for the dataset points
        $this->chart->labels($date);

    }

    /**
     * Respond to AJAX calls with all the chart data points.
     *
     * @return json
     */
     public function data()
     {
         $statsId = Stats::getStatIdByAlias('y.metrika');
         $date = StatValues::convertDate(StatValues::getDateLastMounthByStatsId($statsId));

         $this->chart->dataset('Users Created', 'line', $date)
             ->color('rgba(205, 32, 31, 1)')
             ->backgroundColor('rgba(205, 32, 31, 0.4)');
     }
}
