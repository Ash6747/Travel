@extends('admin.layouts.main')

@push('header')
    <title>Bookings</title>
@endpush

@section('admin-main')

    <div class="pagetitle">
      <h1>Booking Table</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Bookings</li>
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
                    <h5 class="card-title">Bookings</h5>
                    <a class="ms-2" href="{{ route('booking.table') }}">
                      <button class="btn btn-primary rounded-pill ">
                          <i class="bi bi-info-circle"></i>
                          All Type Bookings
                      </button>
                    </a>
                    <a class="ms-2" href="{{ route('booking.pending') }}">
                      <button class="btn btn-warning rounded-pill ">
                          <i class="bi bi-exclamation-triangle"></i>
                          Pending
                      </button>
                    </a>
                    <a class="ms-2" href="{{ route('booking.active') }}">
                      <button class="btn btn-success rounded-pill ">
                          <i class="bi bi-check-circle"></i>
                          Active
                      </button>
                    </a>
                    <a class="ms-2" href="{{ route('booking.rejected') }}">
                      <button class="btn btn-danger rounded-pill ">
                          <i class="bi bi-exclamation-octagon"></i>
                          Rejected
                      </button>
                    </a>
                    <a class="ms-2" href="{{ route('booking.leave') }}">
                      <button class="btn btn-info rounded-pill ">
                          <i class="bi bi-hourglass-split"></i>
                          Leave
                      </button>
                    </a>
                    <a class="ms-2" href="{{ route('booking.expired') }}">
                      <button class="btn btn-secondary rounded-pill ">
                          <i class="bi bi-collection"></i>
                          Expired
                      </button>
                    </a>

                    <a class="ms-auto" href="{{ route('bookings.export', ['status' => $status]) }}" title="Download Excel">
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
                    @foreach ($bookings as $booking)
                        <tr>
                            <td>{{ $booking->student->prn }}</td>
                            <td>{{ $booking->start_date }}</td>
                            <td>{{ $booking->end_date }}</td>
                            <td>{{ $booking->stop->stop_name }}</td>
                            <td>{{ $booking->bus->bus_no }}</td>
                            <td>{{ $booking->bus->route->route_name }}</td>
                            <td>{{ $booking->fee }}</td>
                            <td>
                                @php
                                    $color = $booking->status == 'pending' ? 'warning' : ($booking->status == 'rejected' ? 'danger' : ($booking->status == 'leave' ? 'info' : 'success'));
                                    $textColor = $booking->status == 'pending' ? 'dark' : ($booking->status == 'rejected' ? 'light' : ($booking->status == 'leave' ? 'dark' : 'light'));
                                    $icon = $booking->status == 'pending' ? 'bi-exclamation-triangle' : ($booking->status == 'rejected' ? 'bi-exclamation-octagon' : ($booking->status == 'leave' ? 'bi-hourglass-split me-1' : 'bi-check-circle'));
                                @endphp
                                <span class="badge rounded-pill bg-{{ $color }} text-{{ $textColor }}">
                                    <i class="bi {{ $icon }} me-1"></i> {{ Str::ucfirst($booking->status)}}
                                </span>
                            </td>
                            <td>
                                <div class="form-button-action">
                                <a href="{{ route('booking.edit', ['id' => $booking->id])}}" title="Open Booking">
                                    <button type="button" data-bs-toggle="tooltip" title="Open Booking"
                                        class="btn btn-link btn-info btn-lg rounded-pill" data-original-title="Open Booking" >
                                        <i class="bi text-secondary-emphasis bi-pencil-square"></i>
                                    </button>
                                </a>

                                <a href="{{ route('student.edit', ['id' => $booking->student->id])}}" title="Open Student Details">
                                    <button type="button" data-bs-toggle="tooltip" title="Open Student Details"
                                        class="btn btn-link btn-info btn-lg rounded-pill" data-original-title="Open Student Details" >
                                        <i class="bi bi-person-badge text-secondary-emphasis"></i>
                                    </button>
                                </a>
                                {{-- <a href="{{ route('booking.delete', ['id' => $booking->id]) }}">
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
