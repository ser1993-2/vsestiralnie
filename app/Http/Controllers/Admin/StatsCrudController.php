<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StatsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;

/**
 * Class StatsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StatsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\StatValues');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/stats');
        $this->crud->setEntityNameStrings('Статистику', 'Статистика');

        $this->data['widgets']['before_content'] = [
            [
                'type' => 'div',
                'class' => 'row',
                'content' => [ // widgets
                    [
                        'type' => 'chart',
                        'controller' => \App\Http\Controllers\Admin\Charts\YandexMetrikaChartController::class,
                    ],
                    [
                        'type' => 'chart',
                        'controller' => \App\Http\Controllers\Admin\Charts\YandexDirectChartController::class,

                        'class' => 'card mb-2',
                        'wrapper' => ['class' => 'col-md-4'],
                    ],
                    [
                        'type' => 'chart',
                        'controller' => \App\Http\Controllers\Admin\Charts\YandexNewUserChartController::class,

                        'class' => 'card mb-2',
                        'wrapper' => ['class' => 'col-md-4'],
                    ],
                ]
            ],
            [
                'type' => 'div',
                'class' => 'row',
                'content' => [ // widgets
                    [
                        'type' => 'chart',
                        'controller' => \App\Http\Controllers\Admin\Charts\YandexOtherChartController::class,
                    ],
                    [
                        'type' => 'chart',
                        'controller' => \App\Http\Controllers\Admin\Charts\NadaviChartController::class,
                    ],
                ]
            ],
        ];





    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->setFromDb();
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(StatsRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
