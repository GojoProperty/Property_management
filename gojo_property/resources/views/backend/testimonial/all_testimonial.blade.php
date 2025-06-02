@extends('frontend.frontend_dashboard')
@section('main')
    <section class="page-title-two bg-color-1 centred">
        <div class="pattern-layer">
            <div class="pattern-1" style="background-image: url({{ asset('frontend/assets/images/shape/shape-9.png') }});">
            </div>
            <div class="pattern-2" style="background-image: url({{ asset('frontend/assets/images/shape/shape-10.png') }});">
            </div>
        </div>

        <div class="auto-container">
            <div class="content-box clearfix">
                <h1>Compare Properties</h1>
                <ul class="bread-crumb clearfix">
                    <li><a href="{{ route('dashboard') }}">Home</a></li>
                    <li>Compare Properties</li>
                </ul>
            </div>
        </div>
    </section>
    <div class="page-content mb-12 mt-6">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <a href="{{ route('add.testimonials') }}" class="btn btn-inverse-info">Add Testimonials</a>
            </ol>
        </nav>

        <div class="row mt-6">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">All Testimonials</h6>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($testimonial as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->position }}</td>
                                            <td>
                                                <img src="{{ asset($item->image) }}" style="width:70px; height:40px;">
                                            </td>
                                            <td>
                                                <a href="{{ route('edit.testimonials', $item->id) }}"
                                                    class="btn btn-inverse-warning">Edit</a>
                                                <a href="{{ route('delete.testimonials', $item->id) }}"
                                                    class="btn btn-inverse-danger" id="delete">Delete</a>
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
