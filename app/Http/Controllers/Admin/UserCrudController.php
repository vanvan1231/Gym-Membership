<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Library\Widget;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column([
            'name' => 'name',
            'label' => 'Name'
        ]);

        CRUD::column([
            'name' => 'email',
            'label' => 'Email'
        ]);
        CRUD::column([
            'name' => 'capabilities',
            'label' => 'Cabilities'
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setFromDb(); // set fields from db columns.

        CRUD::field([
            'name' => 'capabilities',
            'label' => 'Capabilities',
            'type' => 'hidden'
        ]);
        $labels = [
            'Add New Users',
            'Accept Payments',
            'View Payments',
            'View Reports - Checkins',
            'View Reports - Members',
            'View Reports - Payments',
            'View Reports - Cash Flow',
        ];
        for ($i = 0; $i < count($labels); $i++) {
            CRUD::field([
                'name' => 'capabilities'.$i+1,
                'label' => $labels[$i],
                'type' => 'checkbox',
                'attributes' => [
                    'class' => 'capability-checkbox',
                    'data-value' => $i+1,
                    'value' => $i + 1
                ]
            ]);
        }
        Widget::add()->type('script')->content(asset('assets/js/admin/user.js'));
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
