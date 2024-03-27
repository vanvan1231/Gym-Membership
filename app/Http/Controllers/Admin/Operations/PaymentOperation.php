<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Models\Member;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

trait PaymentOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupPaymentRoutes($segment, $routeName, $controller)
    {
        Route::get($segment . '/{id}/payment', [
            'as'        => $routeName . '.payment',
            'uses'      => $controller . '@payment',
            'operation' => 'payment',
        ]);
        Route::post($segment . '/{id}/payment', [
            'as'        => $routeName . '.payment-add',
            'uses'      => $controller . '@paymentForm',
            'operation' => 'payment',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupPaymentDefaults()
    {
        CRUD::allowAccess('payment');

        CRUD::operation('payment', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
            // CRUD::addButton('top', 'payment', 'view', 'crud::buttons.payment');
            // CRUD::addButton('line', 'payment', 'view', 'crud::buttons.payment');
            $this->crud->addButton('line', 'payment', 'view', 'crud::buttons.payment');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function payment()
    {
        CRUD::hasAccessOrFail('payment');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = CRUD::getTitle() ?? 'Payment ' . $this->crud->entity_name;
        $this->data['entry'] = $this->crud->getCurrentEntry();

        $id = request()->route('id');
        $payments = Payment::where('member_id',$id)->orderBy('created_at', 'desc')->get();
        $this->data['payments'] = $payments;

        // load the view
        return view('crud::operations.payment_form', $this->data);
    }

    public function paymentForm(Request $request)
    {
        // run validation
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'paymentFor' => 'required',
            'paymentType' => 'required',
            'transactionCode' => 'nullable'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $entry = $this->crud->getCurrentEntry();
        $entry->payment()->create([
            'amount'=> $request->get('amount'),
            'payment_for' => $request->get('paymentFor'),
            'payment_type' => $request->get('paymentType'),
            'transaction_code' => $request->get('transactionCode'),
            'member_id' => $entry->id
        ]);

        return redirect(url($this->crud->route));
    }
}
