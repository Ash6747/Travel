@extends('admin.layouts.main')

@push('header')
    <title>Stops</title>
@endpush

@section('admin-main')

    <div class="pagetitle">
      <h1 style="color: blue;">Stop Table</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Stops</li>
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
                    <h5 class="card-title">Stops</h5>
                    <a class="ms-auto" href="{{ route('stop.create') }}" title="Add Stop">
                      <button class="btn btn-primary rounded-pill ">
                          <i class="ri ri-map-pin-add-fill"></i>
                          Add Stop
                      </button>
                    </a>
                </div>
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>Stop Name</th>
                    <th>Longitude</th>
                    <th>Latitude</th>
                    <th>Fee</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($stops as $stop)
                        <tr>
                            <td>{{ $stop->stop_name }}</td>
                            <td>{{ $stop->longitude }}</td>
                            <td>{{ $stop->latitude }}</td>
                            <td>{{ $stop->fee }}</td>
                            <td>
                                <div class="form-button-action">
                                <a href="{{ route('stop.edit', ['id' => $stop->id])}}" title="Edit">
                                    <button type="button" data-bs-toggle="tooltip" title="Edit"
                                        class="btn btn-link btn-info btn-lg rounded-pill" data-original-title="Edit Task" >
                                        <i class="bi text-secondary-emphasis bi-pencil-square"></i>
                                    </button>
                                </a>
                                {{-- <a href="{{ route('stop.delete', ['id' => $route->id]) }}">
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
