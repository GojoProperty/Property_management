@extends('admin.admin_dashboard')

@section('admin')
<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Add Property Type</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Add New Property Type</h6>
                    <form action="{{ route('store.type') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Type Name</label>
                            <input type="text" name="type_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Type Icon</label>
                            <input type="text" name="type_icon" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Save Property Type</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
