@extends(backpack_view('blank'))
@auth('backpack')
    @php
        $user = auth()->guard('backpack')->user();
        if ($user && strpos($user->capabilities, '') !== false) {
            $capabilities = explode(',', $user->capabilities);
        }
        $defaultBreadcrumbs = [
            trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
            $crud->entity_name_plural => url($crud->route),
            'Payment' => false,
        ];
        // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
        $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
    @endphp

    @section('header')
        <section class="container-fluid">
            <h2>
                <span class="text-capitalize">Add Payment</span>
                @if ($crud->hasAccess('list'))
                    <small>
                        <a href="{{ url($crud->route) }}" class="d-print-none font-sm">
                            <i
                                class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i>
                            {{ trans('backpack::crud.back_to_all') }}
                            <span>{{ $crud->entity_name_plural }}</span>
                        </a>
                    </small>
                @endif
            </h2>
        </section>
    @endsection

    @section('content')
        @if (in_array('2', $capabilities))
            <div class="row justify-content-center">
                <div class="col-md-8 bold-labels">
                    @if ($errors->any())
                        <div class="alert alert-danger pb-0">
                            <ul class="list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li><i class="la la-info-circle"></i> {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="post" action="">
                        @csrf
                        <div class="card">
                            <div class="card-body row">
                                <div class="col-12">
                                    <h2>{{ $entry->full_name }}</h2>
                                </div>
                                <input type="hidden" name="id" value="{{ $entry->id }}">
                                <div class="form-group col-12">
                                    <label>Amount</label>
                                    <input type="number" name="amount" class="form-control">
                                </div>
                                <div class="form-group col-12">
                                    <label>Payment For</label>

                                    <select name="paymentFor" id="payment-for" class="form-control">
                                        <option value="">Select Payment</option>
                                        @if (!$entry->mem_status || $entry->mem_status === 'expired')
                                            <option value="annual_fee" selected="selected">Annual Fee</option>
                                        @else
                                            @if (!$entry->sub_status || $entry->sub_status === 'expired')
                                                <option value="session">Session</options>
                                            @endif
                                            <option value="sub_monthly">Monthly</options>
                                            <option value="sub_quarterly">Quarterly</options>
                                            <option value="sub_half">Six Months</options>
                                            <option value="sub_yearly">Yearly</options>
                                        @endif
                                    </select>
                                    @if (!$entry->mem_status || $entry->mem_status === 'expired')
                                        <input type="hidden" name="paymentFor" value="annual_fee">
                                    @endif
                                    @error('paymentFor')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-12">
                                    <label>Payment Type</label>
                                    <select name="paymentType" id="payment-type" class="form-control">
                                        <option value="cash" selected>Cash</option>
                                        <option value="gcash">GCash</option>
                                    </select>
                                    @error('subject')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-12 trans-code d-none">
                                    <label>Transaction Code</label>
                                    <input type="text" name="transactionCode" id="transaction-code" class="form-control">
                                    @error('transactionCode')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-none" id="parentLoadedAssets">[]</div>
                        <div id="saveActions" class="form-group mt-3">
                            <input type="hidden" name="_save_action" value="send_email">
                            <button type="submit" class="btn btn-success">
                                <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                                <span data-value="add_payment">Add Payment</span>
                            </button>
                            <div class="btn-group" role="group">
                            </div>
                            <a href="{{ url($crud->route) }}" class="btn btn-default"><span class="la la-ban"></span>
                                &nbsp;Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        @endif
        @if (in_array('3', $capabilities))
            <section class="header-operation container-fluid animated fadeIn d-flex mb-2 mt-5 align-items-baseline d-print-none"
                bp-section="page-header">
                <h1 class="text-capitalize mb-0" bp-section="page-heading">Payment History</h1>
            </section>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-body">
                            @if (isset($payments) && $payments->count() > 0)
                                <table
                                    class="table table-striped table-hover nowrap rounded card-table table-vcenter card d-table shadow-xs border-xs dataTable dtr-inline">
                                    <thead class="table-header">
                                        <tr>
                                            <th scope="col">Fullname</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Payment Type</th>
                                            <th scope="col">Payment For</th>
                                            <th scope="col">Transaction Code</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($payments as $payment)
                                            <tr>
                                                <td>{{ $payment->full_name }}</td>
                                                <td>{{ $payment->amount }}
                                                </td>
                                                <td>{{ $payment->payment_type }}
                                                </td>
                                                <td>{{ $payment->payment_for }}
                                                </td>
                                                <td>{{ $payment->transaction_code }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{-- {{ $payments->links() }} --}}
                            @else
                                <p>No payments found.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endsection
@endauth
@php
    Widget::add()->type('script')->content(asset('assets/js/admin/payment.js'));
@endphp
