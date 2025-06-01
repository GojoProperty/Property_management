@extends('customer.customer_dashboard')
@section('customer')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <a href="{{ route('customer.add.property') }}" class="btn btn-inverse-info"> Add Property </a>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Your Posted Property</h6>

                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>P Type</th>
                                        <th>Status Type</th>
                                        <th>City</th>
                                        <th>Code</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($properties as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><img src="{{ asset($item->property_thambnail) }}"
                                                    style="width:70px; height:40px;"></td>
                                            <td>{{ $item->property_name }}</td>
                                            <td>{{ $item['type']['type_name'] ?? 'N/A' }}</td>
                                            <td>{{ $item->property_status }}</td>
                                            <td>{{ $item->city }}</td>
                                            <td>{{ $item->property_code }}</td>
                                            <td>
                                                @if ($item->status == 1)
                                                    <span class="badge rounded-pill bg-success">Approved</span>
                                                @else
                                                    <span class="badge rounded-pill bg-warning">Pending</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
