@extends('admin.layouts.main')

@push('header')
    <title>Trips</title>
@endpush

@section('admin-main')

    <div class="pagetitle">
      <h1>Trips Table</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Trips</li>
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
                    <h5 class="card-title">Trips</h5>
                    <a class="ms-2" href="{{ route('trip.table') }}">
                      <button class="btn btn-primary rounded-pill ">
                          <i class="bi bi-info-circle"></i>
                          All Type Trips
                      </button>
                    </a>

                    <a class="ms-2" href="{{ route('trip.enabled') }}">
                      <button class="btn btn-success rounded-pill ">
                          <i class="bi bi-check-circle"></i>
                          Active
                      </button>
                    </a>
                    <a class="ms-2" href="{{ route('trip.disabled') }}">
                      <button class="btn btn-danger rounded-pill ">
                          <i class="bi bi-exclamation-octagon"></i>
                          Inactive
                      </button>
                    </a>

                    <a class="ms-auto" href="{{ route('trip.export', ['status' => $status]) }}" title="Download Excel">
                        <button class="btn btn-dark rounded-pill">
                            <i class="ri ri-download-line"></i>
                            <i class="ri ri-file-excel-2-line"></i>
                        </button>
                    </a>

                    <a class="ms-2" href="{{ route('trip.create') }}">
                        <button class="btn btn-primary rounded-pill ">
                            <i class="bi bi-plus-circle"></i>
                            Add Trip
                        </button>
                    </a>
                </div>
              <!-- Table with stripped rows -->
              <table
               id="multi-filter-select"
               class="table display nowrap datatable table-striped table-hover">
                <thead>
                  <tr>
                    <th>Driver Name</th>
                    <th>Morning Time</th>
                    <th>Evening Time</th>
                    <th>Distance</th>
                    <th>Route</th>
                    <th>Bus No</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($trips as $trip)
                        <tr>
                            <td>{{ $trip->driver->full_name }}</td>
                            <td>
                                @php
                                    $morningStart = new DateTime($trip->expected_morning_start_time);
                                    $morningEnd = new DateTime($trip->expected_morning_end_time);
                                @endphp
                                <b>Start:</b> {{ $morningStart->format('g:i A') }}
                                <b>End:</b>{{ $morningEnd->format('g:i A') }}
                            </td>
                            <td>
                                @php
                                    $eveningStart = new DateTime($trip->expected_evening_start_time);
                                    $eveningEnd = new DateTime($trip->expected_evening_end_time);
                                @endphp
                                <b>Start:</b>{{ $eveningStart->format('g:i A') }}
                                <b>End:</b>{{ $eveningEnd->format('g:i A') }}
                            </td>
                            <td>{{ $trip->expected_distance }}</td>
                            <td>{{ $trip->bus->route->route_name }}</td>
                            <td>{{ $trip->bus->bus_no }}</td>
                            <td>
                                <a class="badge rounded-pill bg-{{ $trip->status? 'success' : 'danger' }}" href="{{ route('trip.status', ['id' => $trip->id])}}">
                                    <i class="bi {{ $trip->status? 'bi-check-circle' : 'bi-exclamation-octagon' }} me-1"></i> {{ $trip->status? 'Active' : 'Inactive' }}
                                </a>
                            </td>
                            <td>
                                <div class="form-button-action">
                                    <a href="{{ route('trip.edit', ['id' => $trip->id])}}" title="Open trip">
                                        <button type="button" data-bs-toggle="tooltip" title="Open trip"
                                            class="btn btn-link btn-info btn-lg rounded-pill" data-original-title="Open trip" >
                                            <i class="bi text-secondary-emphasis bi-pencil-square"></i>
                                        </button>
                                    </a>
                                  {{-- <a href="{{ route('trip.delete', ['id' => $trip->id]) }}">
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
    {{-- public\assets\vendor\simple-datatables\datatables.min.js --}}

@endsection
