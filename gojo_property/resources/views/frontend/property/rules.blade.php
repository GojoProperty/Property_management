@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <h4>Terms of Use for: {{ $property->property_name }}</h4>
                <p><strong>Address:</strong> {{ $property->address }}</p>
                <hr>
                <div>
                    {!! nl2br(e($property->term->content ?? 'No terms provided for this property.')) !!}
                </div>
            </div>
        </div>
    </div>
@endsection
