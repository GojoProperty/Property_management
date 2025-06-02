@extends('agent.agent_dashboard')
@section('agent')

<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form method="post" action="{{ route('store.professional.plan') }}">
                    @csrf

                    <div class="card-body">
                        <div class="container-fluid d-flex justify-content-between">
                            <div class="col-lg-3 ps-0">
                                <a href="#" class="noble-ui-logo logo-light d-block mt-3">Gojo Property</a>
                                <p class="mt-1 mb-3 text-muted"><em>“Your Key to Every Door.”</em></p>
                                <p>Piyassa, Hawassa, Ethiopia.</p>
                                <h5 class="mt-5 mb-2 text-muted">Invoice to:</h5>
                                <p>{{ $data->name }},<br> {{ $data->email }},<br> {{ $data->address }}.</p>
                            </div>
                            <div class="col-lg-3 pe-0">
                                <h4 class="fw-bolder text-uppercase text-end mt-4 mb-2">Invoice</h4>
                                <p class="text-end mb-1">Balance Due</p>
                                <h4 class="text-end fw-normal">ETB 50</h4>
                            </div>
                        </div>

                        <div class="container-fluid mt-5 d-flex justify-content-center w-100">
                            <div class="table-responsive w-100">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Package Name</th>
                                            <th class="text-end">Property Qty</th>
                                            <th class="text-end">Unit Cost</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-end">
                                            <td class="text-start">1</td>
                                            <td class="text-start">Netsanet</td>
                                            <td>10</td>
                                            <td>ETB 3000</td>
                                            <td>ETB 3000</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="container-fluid mt-5 w-100">
                            <div class="row">
                                <div class="col-md-6 ms-auto">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                        
                                                <tr>
                                                    <td class="text-bold-800">Total</td>
                                                    <td class="text-bold-800 text-end">ETB 3000</td>
                                                </tr>
                                                <tr>
                                                    <td>Payment Made</td>
                                                    <td class="text-danger text-end">(-) ETB 3000</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="container-fluid w-100">
                            <p class="text-danger mt-4">
        <strong>Note:</strong> A <strong>10% commission</strong> will be added to the price of every property you post using this plan. This commission will be applied when setting your property price
    </p>
                            <button type="submit" class="btn btn-primary float-end mt-4 ms-2">
                                <i data-feather="send" class="me-3 icon-md"></i>Send Invoice
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>

@endsection
