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
                    <form method="post" action="{{ route('store.business.plan') }}">
                        @csrf

                        <div class="card-body">
                            <div class="container-fluid d-flex justify-content-between">
                                <div class="col-lg-3 ps-0">
                                    <a href="#"
                                        class="noble-ui-logo logo-light d-block mt-3">Gojo<span>Property</span></a>
                                    <p class="mt-1 mb-1"><b>Gojo Property</b></p>
                                    <p class="text-muted fst-italic">"Where every key finds its home."</p>
                                    <p>Piyassa, Hawassa, Ethiopia.</p>
                                    <h5 class="mt-5 mb-2 text-muted">Invoice to :</h5>
                                    <p>{{ $data->name }},<br> {{ $data->email }},<br> {{ $data->address }}.</p>
                                </div>
                                <div class="col-lg-3 pe-0">
                                    <h4 class="fw-bolder text-uppercase text-end mt-4 mb-2">Invoice</h4>
                                    <p class="text-end mb-1">Balance Due</p>
                                    <h4 class="text-end fw-normal">ETB 1,200</h4>
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
                                                <th class="text-end">Unit cost (ETB)</th>
                                                <th class="text-end">Total (ETB)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="text-end">
                                                <td class="text-start">1</td>
                                                <td class="text-start">Gojo Package</td>
                                                <td>3</td>
                                                <td>1,200</td>
                                                <td>1,200</td>
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
                                                        <td class="text-bold-800 text-end">ETB 1,200</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Payment Made</td>
                                                        <td class="text-danger text-end">(-) ETB 1,200</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- COMMISSION NOTICE --}}
                            <div class="alert alert-info mt-4">
                                <strong>Note:</strong> A <strong>10% commission</strong> will be added to the price of every
                                property you post using this plan. This commission will be applied when setting your
                                property price.
                            </div>

                            <div class="container-fluid w-100">
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
