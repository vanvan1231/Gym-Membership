@extends(backpack_view('blank'))

@section('content')

    <!-- Breadcrumb Navigation -->

    @include(backpack_view('inc.breadcrumbs'))
    <nav aria-label="breadcrumb" class="d-flex justify-content-end me-3 mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="">Admin</a></li>
            <li class="breadcrumb-item"><a href="">Reports</a></li>
            <li class="breadcrumb-item active"><a href="">Payments</a></li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-baseline d-print-none" bp-section="page-header">
        <h1 class="text-capitalize mb-0" bp-section="page-heading">Payments</h1>
    </section>

    <div class="container-fluid">
        <div class="row">
            @include('custom/filter_date')
            <div class="col-lg-12">
                <div class="card-body">
                    @if (isset($payments) && $payments->count() > 0)
                        <table class="table table-striped table-hover nowrap rounded card-table table-vcenter card d-table shadow-xs border-xs dataTable dtr-inline">
                            <thead class="table-header">
                                <tr>
                                    <th scope="col">Fullname</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Payment Type</th>
                                    <th scope="col">Payment For</th>
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
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $payments->links() }}
                    @else
                        <p>No payments found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
