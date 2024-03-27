<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PaymentRequest;
use App\Models\Member;
use Backpack\CRUD\app\Library\Widget;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PaymentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PaymentCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {

        CRUD::setModel(\App\Models\Member::class);
        CRUD::setModel(\App\Models\Payment::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/payment');
        CRUD::setEntityNameStrings('payment', 'payments');
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
            'name' => 'fullname',
            'label' => 'Name',
            'entity' => 'member',
            'attribute' => 'full_name'
        ]);
        CRUD::column([
            'name' => 'code',
            'label' => 'Code',
            'entity' => 'member',
            'attribute' => 'code'
        ]);
        CRUD::column([
            'name' => 'amount',
            'label' => 'Amount'
        ]);
        CRUD::column([
            'name' => 'payment_for',
            'label' => 'Payment For',
            'display_as' => 'payment_for'
        ]);
        CRUD::column([
            'name' => 'payment_type',
            'label' => 'Payment Type',
            'display_as' => 'payment_type'
        ]);
        CRUD::column([
            'name' => 'transaction_code',
            'label' => 'Transaction Code'
        ]);
        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {

        CRUD::setValidation(PaymentRequest::class);
        CRUD::field([
            'name' => 'member_id',
            'label' => 'Name',
            'type' => 'select',
            'attribute' => 'full_name',
            'entity' => 'member'
        ]);
        CRUD::field('amount')->type('number')->label('Amount');
        CRUD::field([
            'name' => 'payment_for',
            'label' => 'Payment For',
            'type' => 'enum',
            'options' => [
                'annual_fee' => 'Annual Fee',
                'sub_monthly' => 'Monthly',
                'sub_yearly' => 'Yearly',
                'sub_quarterly' => 'Quarterly',
                'sub_half' => 'Six Months'
            ]
        ]);
        CRUD::field([
            'name'=>'payment_type',
            'label' => 'Payment Type',
            'type' => 'enum',
            'options'=>[
                'cash'=> 'Cash',
                'gcash'=> 'GCash'
            ],
            'default' => 'cash'
        ]);

        CRUD::addField([
            'name' => 'transaction_code',
            'label' => 'Transaction Code',
            'type' => 'text'
        ]);
        Widget::add()->type('script')->content(asset('assets/js/admin/field.js'));
        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
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
