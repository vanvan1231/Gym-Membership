@extends(backpack_view('blank'))

@section('content')

    <!-- Breadcrumb Navigation -->

    @include(backpack_view('inc.breadcrumbs'))
    <nav aria-label="breadcrumb" class="d-flex justify-content-end me-3 mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="">Admin</a></li>
            <li class="breadcrumb-item"><a href="">Reports</a></li>
            <li class="breadcrumb-item active"><a href="">Members</a></li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-baseline d-print-none" bp-section="page-header">
        <h1 class="text-capitalize mb-0" bp-section="page-heading">members</h1>
    </section>

    <div class="container-fluid">
        <div class="row">
            @include('custom/filter_date')
            <div class="col-lg-12">
                <div class="card-body">
                    @if (isset($members) && $members->count() > 0)
                        <table class="table table-striped table-hover nowrap rounded card-table table-vcenter card d-table shadow-xs border-xs dataTable dtr-inline">
                            <thead class="table-header">
                                <tr>
                                    <th scope="col">Fullname</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">Membership Status</th>
                                    <th scope="col">Subscription Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($members as $mem)
                                    <tr>
                                        <td>{{ $mem->full_name }}</td>
                                        <td>{{ $mem->code }}
                                        </td>
                                        <td>{{ $mem->mem_status }}
                                        </td>
                                        <td>{{ $mem->sub_status }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $members->links() }}
                    @else
                        <p>No members found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
