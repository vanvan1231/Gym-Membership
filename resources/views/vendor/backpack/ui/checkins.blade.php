@extends(backpack_view('blank'))

@section('content')

    <!-- Breadcrumb Navigation -->

    @include(backpack_view('inc.breadcrumbs'))
    <nav aria-label="breadcrumb" class="d-flex justify-content-end me-3 mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="">Admin</a></li>
            <li class="breadcrumb-item"><a href="">Reports</a></li>
            <li class="breadcrumb-item active"><a href="">Daily Checkins</a></li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-baseline d-print-none" bp-section="page-header">
        <h1 class="text-capitalize mb-0" bp-section="page-heading">Daily Checkins</h1>
    </section>
    <div class="container-fluid">
        @include('custom/filter_date')
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    @if (isset($checkins) && $checkins->count() > 0)
                    <table class="table table-striped table-hover nowrap rounded card-table table-vcenter card d-table shadow-xs border-xs dataTable dtr-inline">
                            <thead class="table-header">
                                <tr>
                                    <th scope="col">Fullname</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($checkins as $checkin)
                                    <tr>
                                        <td>{{ $checkin->full_name }}</td>
                                        <td>{{ $checkin->checkin_date ? \Carbon\Carbon::parse($checkin->checkin_date)->format('F j, Y') : '' }}
                                        </td>
                                        <td>{{ $checkin->checkin_date ? \Carbon\Carbon::parse($checkin->checkin_date)->format('H:i') : '' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $checkins->links() }}
                    @else
                        <p>No checkins found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
