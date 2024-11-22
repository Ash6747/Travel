@extends('admin.layouts.main')

@push('header')
    <title>Trip Histories</title>
@endpush

@section('admin-main')

    <div class="pagetitle">
      <h1>Trip Histories Table</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Trip Histories</li>
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
                    <h5 class="card-title">Trip Histories</h5>
                    <a class="ms-2" href="{{ route('triphistory.table') }}">
                      <button class="btn btn-primary rounded-pill ">
                          <i class="bi bi-info-circle"></i>
                          All Trip Histories
                      </button>
                    </a>

                    <a class="ms-2" href="{{ route('triphistory.morning') }}">
                      <button class="btn btn-warning rounded-pill ">
                          <i class="bi bi-brightness-high"></i>
                          Morning
                      </button>
                    </a>
                    <a class="ms-2" href="{{ route('triphistory.evening') }}">
                      <button class="btn btn-danger rounded-pill ">
                          <i class="bi bi-cloud-moon"></i>
                          Evening
                      </button>
                    </a>

                    <a class="ms-auto" href="{{ route('triphistory.export', ['phase' => $phase]) }}" title="Download Excel">
                        <button class="btn btn-dark rounded-pill">
                            <i class="ri ri-download-line"></i>
                            <i class="ri ri-file-excel-2-line"></i>
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
                    <th>Time</th>
                    <th>Distance</th>
                    <th>Route</th>
                    <th>Bus No</th>
                    <th>Phase</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($triphistories as $triphistory)
                        <tr>
                            <td>{{ $triphistory->driver->full_name }}</td>
                            <td>
                                <b>Start</b> {{ $triphistory->created_at->format('g:i A') }}
                                <br>
                                <b>End</b> {{ $triphistory->updated_at->format('g:i A') }}
                            </td>
                            <td>{{ $triphistory->distance_traveled }}</td>
                            <td>{{ $triphistory->trip->bus->route->route_name }}</td>
                            <td>{{ $triphistory->trip->bus->bus_no }}</td>
                            <td>
                                <span class="badge rounded-pill bg-{{ $triphistory->phase? 'warning' : 'danger' }} {{ $triphistory->phase? 'text-dark' : 'text-light' }}">
                                    <i class="bi {{ $triphistory->phase? 'bi-brightness-high' : 'bi-cloud-moon' }} me-1"></i> {{ $triphistory->phase? 'Morning' : 'Evening' }}
                                </span>
                            </td>
                            <td>
                                <div class="form-button-action">
                                    <a href="{{ route('triphistory.show', ['id' => $triphistory->id])}}" title="Open trip">
                                        <button type="button" data-bs-toggle="tooltip" title="Open trip"
                                            class="btn btn-link btn-info btn-lg rounded-pill" data-original-title="Open trip" >
                                            <i class="bi text-secondary-emphasis bi-pencil-square"></i>
                                        </button>
                                    </a>
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
