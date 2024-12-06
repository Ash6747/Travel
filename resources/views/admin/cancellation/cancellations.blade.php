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
                <div class="p-2 d-flex align-items-center">
                    <h5 class="card-title d-block">Bookings Cancelation</h5>
                    <form class="gap-2 p-2 border border-black rounded-3 flex-grow-1 row ms-2 text-bg-secondary bg-gradient" action="{{ route('cancellation.filter') }}" method="get">
                        <div class="p-0 mb-2 col-12 col-md-2 mb-md-0">
                            <select id="inputState" class="text-white bg-dark form-select" name="status">
                                <option class="text-primary fw-bold fs-6" value="all" {{ $status == 'all' ? 'selected' : '' }}>
                                    All
                                </option>
                                <option class="fw-bold fs-6 text-warning" value="pending" {{ $status == 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option>
                                <option class="fw-bold fs-6 text-success" value="approved" {{ $status == 'approved' ? 'selected' : '' }}>
                                    Approved
                                </option>
                                <option class="fw-bold fs-6 text-danger" value="rejected" {{ $status == 'rejected' ? 'selected' : '' }}>
                                    Rejected
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

                        <div class="p-0 mx-2 mb-2 col-12 col-md-1 me-2 mb-md-0">
                            <button type="submit" class="btn btn-light fw-bold">
                                Filter
                            </button>
                        </div>
                    </form>

                    <a class="ms-3" href="{{ route('cancellation.export', ['status' => $status, 'fdate' => $fdate, 'tdate' => $tdate]) }}" title="Download Excel">
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
