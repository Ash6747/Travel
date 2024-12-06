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
                <div class="gap-2 p-2 d-flex align-items-center">
                    <h5 class="card-title">Bookings</h5>
                    <form class="gap-2 p-2 border border-black rounded-3 flex-grow-1 row ms-2 text-bg-secondary bg-gradient" action="{{ route('booking.filter') }}" method="get">
                        <div class="p-0 mb-2 col-12 col-md-2 mb-md-0">
                            <select id="inputState" class="text-white bg-dark form-select" name="status">
                                <option class="text-primary fw-bold fs-6" value="all" {{ $status == 'all' ? 'selected' : '' }}>
                                    All
                                </option>
                                <option class="fw-bold fs-6 text-warning" value="pending" {{ $status == 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option>
                                <option class="fw-bold fs-6 text-success" value="active" {{ $status == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option class="fw-bold fs-6 text-danger" value="rejected" {{ $status == 'rejected' ? 'selected' : '' }}>
                                    Rejected
                                </option>
                                <option class="fw-bold fs-6 text-info" value="leave" {{ $status == 'leave' ? 'selected' : '' }}>
                                    Leave
                                </option>
                                <option class="fw-bold fs-6 text-primary" value="expired" {{ $status == 'expired' ? 'selected' : '' }}>
                                    Expired
                                </option>
                            </select>
                        </div>

                        <div class="p-0 mb-2 ms-2 row col-12 col-md-4 mb-md-0">
                            <label for="inputEmail3" class="col-md-4 col-form-label">From:</label>
                            <div class="p-0 col-md-8">
                                <input type="date" value="{{ $fdate ?? '' }}" name="fdate" placeholder="from" class="form-control text-bg-dark">
                            </div>
                        </div>

                        <div class="p-0 mb-2 ms-2 row col-12 col-md-4 mb-md-0">
                            <label for="inputEmail3" class="col-md-3 col-form-label">To:</label>
                            <div class="p-0 col-md-9">
                                <input type="date" value="{{ $tdate ?? '' }}" name="tdate" class="form-control text-bg-dark">
                            </div>
                        </div>

                        <div class="p-0 mb-2 ms-auto col-12 col-md-1 me-2 mb-md-0">
                            <button type="submit" class="btn btn-light fw-bold">
                                Filter
                            </button>
                        </div>
                    </form>

                    {{-- <form class="gap-2 p-2 border border-black rounded flex-grow-1 row ms-2 text-bg-secondary bg-gradient" action="{{ route('booking.filter') }}" method="get">
                        <div class="p-0 col-md-2">
                            <select id="inputState" class="text-white bg-dark form-select" name="status">
                                <option class="text-primary fw-bold fs-6" value="all" {{ $status == 'all' ? 'selected' : '' }}>
                                    All
                                </option>
                                <option class="fw-bold fs-6 text-warning" value="pending" {{ $status == 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option>
                                <option class="fw-bold fs-6 text-success" value="active" {{ $status == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option class="fw-bold fs-6 text-danger" value="rejected" {{ $status == 'rejected' ? 'selected' : '' }}>
                                    Rejected
                                </option>
                                <option class="fw-bold fs-6 text-info" value="leave" {{ $status == 'leave' ? 'selected' : '' }}>
                                    Leave
                                </option>
                                <option class="fw-bold fs-6 text-primary" value="expired" {{ $status == 'expired' ? 'selected' : '' }}>
                                    Expired
                                </option>
                            </select>
                        </div>
                        <div class="p-0 ms-2 row col-md-4 border-start">
                            <label for="inputEmail3" class="col-md-4 col-form-label">From:</label>
                            <div class="p-0 col-md-8">
                                <input type="date" value="{{ $fdate ?? '' }}" name="fdate" placeholder="from" class="form-control text-bg-secondary">
                            </div>
                        </div>

                        <div class="p-0 ms-2 row col-md-4">
                            <label for="inputEmail3" class="col-md-3 col-form-label">To:</label>
                            <div class="p-0 col-md-9">
                                <input type="date" value="{{ $tdate ?? '' }}" name="tdate" class="form-control text-bg-secondary">
                            </div>
                        </div>
                        <div class="p-0 ms-auto col-md-1 me-2">
                            <button type="submit" class="btn btn-light fw-bold">
                                Filter
                            </button>
                        </div>
                    </form> --}}

                    <a class="ms-3" href="{{ route('bookings.export', ['status' => $status, 'fdate' => $fdate ?? '', 'tdate' => $tdate ?? '']) }}" title="Download Excel">
                        <button class="btn btn-dark rounded-pill">
                            <i class="ri ri-download-line"></i>
                            <i class="ri ri-file-excel-2-line"></i>
                        </button>
                    </a>

                </div>
                <hr>
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
