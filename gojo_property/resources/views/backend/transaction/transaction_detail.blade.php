@extends('admin.admin_dashboard')
@section('admin')
<div class="page-content">

    <ol class="breadcrumb">
        <a href="#" class="btn btn-inverse-info"> All Transactions </a>
    </ol>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row mt-3">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Transaction Details</h6>

                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>User</th>
                                    <th>Property</th>
                                    <th>Agent</th>
                                    <th>Type</th>
                                    <th>Price</th>
                                    <th>Reference Code</th>
                                    <th>Status</th>
                                    <th>Request Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->user?->name ?? 'Admin' }}</td>
                                        <td>{{ $item->property?->property_name ?? 'N/A' }}</td>
                                        <td>{{ $item->agent?->name ?? 'Admin' }}</td>
                                        <td>{{ ucfirst($item->transaction_type) }}</td>
                                        <td>{{ $item->price }} ETB</td>
                                        <td>{{ $item->reference_code }}</td>
                                        <td style="min-width: 140px; white-space: nowrap;">
                                            <form action="{{ route('update.transaction.status', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="approved" {{ $item->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                                <option value="rejected" {{ $item->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            </select>

                                            </form>
                                        </td>
                                        <td>{{ $item->request_date }}</td>
                                        <td>
                                            <a href="{{ route('delete.transaction', $item->id) }}" class="btn btn-inverse-danger btn-sm" title="Delete"
                                                        onclick="return confirm('Are you sure you want to delete this transaction?');">
                                                            <i data-feather="trash-2"></i>
                                                        </a>

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
