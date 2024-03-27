@extends(backpack_view('blank'))

@section('content')
    <!-- Breadcrumb Navigation -->

    @include(backpack_view('inc.breadcrumbs'))
    <nav aria-label="breadcrumb" class="d-flex justify-content-end me-3 mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="">Admin</a></li>
            <li class="breadcrumb-item"><a href="">Reports</a></li>
            <li class="breadcrumb-item active"><a href="">Cashflow</a></li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-baseline d-print-none"
        bp-section="page-header">
        <h1 class="text-capitalize mb-0" bp-section="page-heading">Cashflow</h1>
    </section>

    <div class="container-fluid">
        <div class="row">
            @include('custom/filter_cashflow')
            <div class="col-lg-12">
                <div class="card-body">
                    @if ($has_query)
                    <div class="col-12">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span
                                            class="bg-success text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path
                                                    d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2">
                                                </path>
                                                <path d="M12 3v3m0 12v3"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="fw-bold fs-1 mb-2">
                                            ₱ {{ $cashflow }}
                                        </div>
                                        <div class="text-secondary">
                                            {{$message}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
