@extends('admin.layouts.main')

@push('header')
    <title>Bookings Cancelation</title>
@endpush

@section('admin-main')

    <div class="pagetitle">
      <h1>Booking Cancelation Table</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">Home</li>
          <li class="breadcrumb-item">Bookings</li>
          <li class="breadcrumb-item active">Cancelation</li>
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
                    <h5 class="card-title">Bookings Cancelation</h5>
                    <a class="ms-2" href="{{ route('cancellation.table') }}">
                      <button class="btn btn-primary rounded-pill ">
                          <i class="bi bi-info-circle"></i>
                          All
                      </button>
                    </a>
                    <a class="ms-2" href="{{ route('cancellation.pending') }}">
                      <button class="btn btn-warning rounded-pill ">
                          <i class="bi bi-exclamation-triangle"></i>
                          Pending
                      </button>
                    </a>
                    <a class="ms-2" href="{{ route('cancellation.approved') }}">
                      <button class="btn btn-success rounded-pill ">
                          <i class="bi bi-check-circle"></i>
                          Approved
                      </button>
                    </a>
                    <a class="ms-2" href="{{ route('cancellation.rejected') }}">
                      <button class="btn btn-danger rounded-pill ">
                          <i class="bi bi-exclamation-octagon"></i>
                          Rejected
                      </button>
                    </a>

                    {{-- <a class="ms-auto" href="{{ route('bookings.export', ['status' => $status]) }}" title="Download Excel">
                        <button class="btn btn-dark rounded-pill">
                            <i class="ri ri-download-line"></i>
                            <i class="ri ri-file-excel-2-line"></i>
                        </button>
                    </a> --}}

                </div>
              <!-- Table with stripped rows -->
              <table
               id="multi-filter-select"
               class="table display nowrap datatable table-striped table-hover">
                <thead>
                  <tr>
                    <th>Student PRN</th>
                    <th>Start date</th>
                    <th>End Date</th>
                    <th>Stop</th>
                    <th>Bus No.</th>
                    <th>Route</th>
                    <th>Fee</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($cancellations as $cancellation)
                        <tr>
                            <td>{{ $cancellation->student->prn }}</td>
                            <td>{{ $cancellation->booking->start_date }}</td>
                            <td>{{ $cancellation->booking->end_date }}</td>
                            <td>{{ $cancellation->booking->stop->stop_name }}</td>
                            <td>{{ $cancellation->booking->bus->bus_no }}</td>
                            <td>{{ $cancellation->booking->bus->route->route_name }}</td>
                            <td>{{ $cancellation->booking->fee }}</td>
                            <td>
                                @php
                                    $color = $cancellation->status == 'pending' ? 'warning' : ($cancellation->status == 'rejected' ? 'danger' : 'success');
                                    $textColor = $cancellation->status == 'pending' ? 'dark' : ($cancellation->status == 'rejected' ? 'light' : 'light');
                                    $icon = $cancellation->status == 'pending' ? 'bi-exclamation-triangle' : ($cancellation->status == 'rejected' ? 'bi-exclamation-octagon' : 'bi-check-circle');
                                @endphp
                                <span class="badge rounded-pill bg-{{ $color }} text-{{ $textColor }}">
                                    <i class="bi {{ $icon }} me-1"></i> {{ Str::ucfirst($cancellation->status)}}
                                </span>
                            </td>
                            <td>
                                <div class="form-button-action">
                                    {{-- <a href="{{ route('cancellation.edit', ['id' => $cancellation->id])}}" title="Open cancellation">
                                        <button type="button" data-bs-toggle="tooltip" title="Open cancellation"
                                            class="btn btn-link btn-info btn-lg rounded-pill" data-original-title="Open cancellation" >
                                            <i class="bi text-secondary-emphasis bi-pencil-square"></i>
                                        </button>
                                    </a> --}}

                                    <a href="{{ route('student.edit', ['id' => $cancellation->student->id])}}" title="Open Student Details">
                                        <button type="button" data-bs-toggle="tooltip" title="Open Student Details"
                                            class="btn btn-link btn-info btn-lg rounded-pill" data-original-title="Open Student Details" >
                                            <i class="bi bi-person-badge text-secondary-emphasis"></i>
                                        </button>
                                    </a>
                                    {{-- <a href="{{ route('cancellation.delete', ['id' => $cancellation->id]) }}">
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
