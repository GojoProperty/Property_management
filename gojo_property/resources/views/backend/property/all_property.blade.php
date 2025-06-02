@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">

        <ol class="breadcrumb">
            <a href="{{ route('add.property') }}" class="btn btn-inverse-info"> Add Property </a>
        </ol>
        <div class="page-content">
            {{-- Breadcrumb and Add Button --}}
            <ol class="breadcrumb d-flex justify-content-between">
                <h6 class="mb-0"> {{ $filter ?? 'All' }}-Properties</h6>
                <a href="{{ route('add.property') }}" class="btn btn-inverse-info">Add Property</a>
            </ol>

            <div class="row">
                <div class="col-md-12">
                    {{-- Tabs Navigation --}}
                    <ul class="nav nav-tabs w-100 justify-content-start" id="propertyTabs">
                        @php
                            $tabs = [
                                'All' => 'all.property',
                                'For Rent' => 'property.rent',
                                'For Sale' => 'property.sale',
                                'Scheduled' => 'property.scheduled',
                                'Requested' => 'property.requested',
                                'Active' => 'property.active',
                                'Inactive' => 'property.inactive',
                                'Rented' => 'property.rented',
                                'Sold' => 'property.sold',
                            ];
                        @endphp

                        @foreach ($tabs as $name => $route)
                            <li class="nav-item">
                                <a class="nav-link @if (($filter ?? 'All') === $name) active @endif"
                                    href="{{ route($route) }}">
                                    {{ $name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>


            {{-- Properties Table --}}
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dataTableExample" class="table">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>P_Type</th>
                                            <th>Status Type</th>
                                            <th>City</th>
                                            <th>Code</th>
                                            <th>Status</th>
                                            <th>Hot</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($property as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    <img src="{{ asset($item->property_thambnail) }}"
                                                        style="width:70px; height:40px;">
                                                </td>
                                                <td>{{ $item->property_name }}</td>
                                                <td>{{ $item['type']['type_name'] ?? 'N/A' }}</td>
                                                <td>{{ $item->property_status }}</td>
                                                <td>{{ $item->city }}</td>
                                                <td>{{ $item->property_code }}</td>
                                                <td>
                                                    @if ($item->status == 1)
                                                        <span class="badge rounded-pill bg-success">Active</span>
                                                    @elseif ($item->status == 0 && $item->property_status == 'For Rent')
                                                        <span class="badge rounded-pill bg-warning text-dark">Rented</span>
                                                    @elseif ($item->status == 0 && $item->property_status == 'For Buy')
                                                        <span class="badge rounded-pill bg-secondary">Sold</span>
                                                    @else
                                                        <span class="badge rounded-pill bg-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <input type="checkbox" class="hot-toggle" data-id="{{ $item->id }}"
                                                        {{ $item->hot ? 'checked' : '' }}>
                                                </td>
                                                <td>
                                                    <a href="{{ route('details.property', $item->id) }}"
                                                        class="btn btn-inverse-info" title="Details">
                                                        <i data-feather="eye"></i>
                                                    </a>
                                                    <a href="{{ route('edit.property', $item->id) }}"
                                                        class="btn btn-inverse-warning" title="Edit">
                                                        <i data-feather="edit"></i>
                                                    </a>
                                                    <a href="{{ route('delete.property', $item->id) }}"
                                                        class="btn btn-inverse-danger" id="delete" title="Delete">
                                                        <i data-feather="trash-2"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">No properties found for
                                                    {{ $filter }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div> <!-- table-responsive -->
                        </div> <!-- card-body -->
                    </div> <!-- card -->
                </div> <!-- col -->
            </div> <!-- row -->
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                const table = $('#dataTableExample');
                if ($.fn.DataTable.isDataTable(table)) {
                    table.DataTable().clear().destroy();
                }
                table.DataTable();
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('.hot-toggle').on('change', function() {
            var isChecked = $(this).is(':checked') ? 1 : 0;
            var propertyId = $(this).data('id');

            $.ajax({
                url: "{{ route('property.toggle.hot') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: propertyId,
                    hot: isChecked
                },
                success: function(response) {
                    if (response.success) {
                        console.log('Hot status updated.');
                    }
                }
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .nav-tabs {
            display: flex;
            flex-wrap: wrap;
            border-bottom: 2px solid #ddd;
            width: 100%;
        }

        .nav-tabs .nav-item {
            flex: 1;
            /* Make tabs evenly spaced */
            text-align: center;
        }

        .nav-tabs .nav-link {
            width: 100%;
            padding: 10px 12px;
            border-radius: 0;
            background-color: #f8f9fa;
            color: #4CAF50;
            border: 1px solid transparent;
        }

        .nav-tabs .nav-link.active {
            background-color: #4CAF50;
            color: white;
            border-color: #4CAF50 #4CAF50 transparent;
        }
    </style>
@endpush
