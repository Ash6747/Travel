@extends('admin.layouts.main')

@push('header')
    <title>Drivers</title>
@endpush

@section('admin-main')

    <div class="pagetitle">
      <h1 style="color: blue;">Drivers Leaves</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Drivers</li>
          <li class="breadcrumb-item active">Leaves</li>
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
                    <h5 class="card-title">Leaves</h5>
                    {{-- <a class="ms-2" href="{{ route('driver.table') }}">
                      <button class="btn btn-primary rounded-pill ">
                          <i class="bi bi-info-circle"></i>
                          All Type Drivers
                      </button>
                    </a>
                    <a class="ms-2" href="{{ route('driver.enabled') }}">
                        <button class="btn btn-success rounded-pill ">
                            <i class="bi bi-check-circle"></i>
                            Active
                        </button>
                    </a>
                    <a class="ms-2" href="{{ route('driver.disabled') }}">
                        <button class="btn btn-danger rounded-pill ">
                            <i class="bi bi-exclamation-octagon"></i>
                            Inactive
                        </button>
                    </a> --}}
                </div>

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>Driver Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Duration</th>
                    <th>Reason</th>
                    <th>Status</th>
                    {{-- <th>Action</th> --}}
                  </tr>
                </thead>
                <tbody>
                    @foreach ( $leaves as $leave)
                        <tr>
                            <td>{{ $leave->driver->full_name }}</td>
                            <td>{{ $leave->start_date }}</td>
                            <td>{{ $leave->end_date }}</td>
                            <td>{{ $leave->duration }}</td>
                            <td>{{ $leave->reason }}</td>
                            <td>
                                @php
                                    $color = $leave->status == 'pending' ? 'warning' : ($leave->status == 'rejected' ? 'danger' : 'success');
                                    $textColor = $leave->status == 'pending' ? 'dark' : ($leave->status == 'rejected' ? 'light' : 'light');
                                    $icon = $leave->status == 'pending' ? 'bi-exclamation-triangle' : ($leave->status == 'rejected' ? 'bi-exclamation-octagon' : 'bi-check-circle');
                                @endphp

                                @if ($leave->status == 'pending')
                                <a class="badge rounded-pill bg-danger" href="{{ route('leave.status', ['leaveId' => $leave->id, 'status' => 'rejected'])}}">
                                    <i class="bi bi-exclamation-octagon me-1"></i> Reject
                                </a>
                                <a class="badge rounded-pill bg-success" href="{{ route('leave.status', ['leaveId' => $leave->id, 'status' => 'approved'])}}">
                                    <i class="bi bi-check-circle me-1"></i> Approve
                                </a>
                                @else
                                <span class="badge rounded-pill bg-{{ $color }} text-{{ $textColor }}">
                                    <i class="bi {{ $icon }} me-1"></i> {{ Str::ucfirst($leave->status)}}
                                </span>
                                @endif
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
