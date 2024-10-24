@extends('admin.layouts.main')

@push('header')
    <title>Routes</title>
@endpush

@section('admin-main')

    <div class="pagetitle">
      <h1 style="color: blue;">Route Table</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Route</li>
          <li class="breadcrumb-item active">Table</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    @session('status')
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i>
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endsession

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <h5 class="card-title">Routes</h5>
                    <a class="ms-auto" href="{{ route('route.create') }}">
                      <button class="btn btn-primary rounded-pill ">
                          <i class="bi bi-plus-circle"></i>
                          Add Route
                      </button>
                    </a>
                </div>
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>Route Name</th>
                    <th>Start Point</th>
                    <th>End Point</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($routes as $route)
                        <tr>
                            <td>{{ $route->route_name }}</td>
                            <td>{{ $route->start_location }}</td>
                            <td>{{ $route->end_location }}</td>
                            <td>
                                <a title="Change Status" class="badge rounded-pill bg-{{ $route->status? 'success' : 'danger' }}" href="{{ route('route.status', ['id' => $route->id])}}">
                                    <i class="bi {{ $route->status? 'bi-check-circle' : 'bi-exclamation-octagon' }} me-1"></i> {{ $route->status? 'Active' : 'Inactive' }}
                                </a>
                            </td>
                            <td>
                                <div class="form-button-action">
                                    <a href="{{ route('route.edit', ['id' => $route->id])}}"  title="Edit">
                                        <button type="button" data-bs-toggle="tooltip"
                                            class="btn btn-link btn-info btn-lg rounded-pill" data-original-title="Edit Task" >
                                            <i class="bi text-secondary-emphasis bi-pencil-square"></i>
                                        </button>
                                    </a>
                                    <a href="{{ route('route.stops', ['id' => $route->id])}}" title="Route Stops">
                                        <button type="button" data-bs-toggle="tooltip"
                                            class="btn btn-link btn-info btn-lg rounded-pill text-decoration-none" data-original-title="Route Stops" >
                                            <i class="ri text-secondary-emphasis ri-road-map-line"></i>
                                        </button>
                                    </a>
                                    {{-- <a href="{{ route('route.delete', ['id' => $route->id]) }}">
                                        <button type="button" data-bs-toggle="tooltip" title="Remove"
                                            class="btn btn-link btn-danger btn-lg rounded-pill" data-original-title="Remove" >
                                            <i class="bi text-secondary-emphasis bi-trash"></i>
                                        </button>
                                    </a> --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
    </section>

@endsection
