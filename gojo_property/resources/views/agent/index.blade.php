@extends('agent.agent_dashboard')
@section('agent')
    @php
        $id = Auth::user()->id;
        $agentId = App\Models\User::find($id);
        $status = $agentId->status;
    @endphp

    <div class="page-content">
        @if ($status === 'active')
            <h4>Agent Account Is <span class="text-success">Active </span> </h4>
        @else
            <h4>Agent Account Is <span class="text-danger">Inactive </span> </h4>
            <p class="text-danger"><b> Plz wait admin will check and approve your account</b></p>
        @endif

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Welcome to Dashboard</h4>
            </div>
            <div class="d-flex align-items-center flex-wrap text-nowrap">
                <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
                    <span class="input-group-text input-group-addon bg-transparent border-primary" data-toggle><i
                            data-feather="calendar" class="text-primary"></i></span>
                    <input type="text" class="form-control bg-transparent border-primary" placeholder="Select date"
                        data-input>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-12 col-xl-12 stretch-card">
                <div class="row flex-grow-1">

                    {{-- New Properties --}}
                    <div class="col-md-6 col-xl-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="card-title mb-0">Total Properties</h6>
                                    <div class="dropdown mb-2">
                                        <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item d-flex align-items-center" href="#"><i
                                                    data-feather="eye" class="icon-sm me-2"></i> View</a>
                                            <a class="dropdown-item d-flex align-items-center" href="#"><i
                                                    data-feather="edit-2" class="icon-sm me-2"></i> Edit</a>
                                            <a class="dropdown-item d-flex align-items-center" href="#"><i
                                                    data-feather="trash" class="icon-sm me-2"></i> Delete</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-baseline mb-3">
                                    <h3>{{ $newPropertiesCount }}</h3>
                                    <small class="text-{{ $percentChange >= 0 ? 'success' : 'danger' }}">
                                        {{ $percentChange >= 0 ? '+' : '' }}{{ number_format($percentChange, 1) }}%
                                    </small>
                                </div>

                                <canvas id="weeklyChart" height="100"></canvas>
                            </div>
                        </div>
                    </div>



                </div>
            @endsection
