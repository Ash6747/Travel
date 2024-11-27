@extends('admin.layouts.main')

@push('header')
    <title>Feedbacks</title>
@endpush

@section('admin-main')

    <div class="pagetitle">
      <h1>Feedbacks Table</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Feedbacks</li>
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
                    <h5 class="card-title">Feedbacks</h5>
                    {{-- <a class="ms-2" href="{{ route('complaint.table') }}">
                        <button class="btn btn-primary rounded-pill ">
                            <i class="bi bi-info-circle"></i>
                            All Type Feedbacks
                        </button>
                    </a> --}}

                    {{-- <a class="ms-auto" href="{{ route('complaint.export', ['status' => $status]) }}" title="Download Excel">
                        <button class="btn btn-dark rounded-pill">
                            <i class="ri ri-download-line"></i>
                            <i class="ri ri-file-excel-2-line"></i>
                        </button>
                    </a> --}}
                    {{-- <a class="ms-2" href="{{ route('complaint.create') }}">
                      <button class="btn btn-primary rounded-pill ">
                          <i class="bi bi-plus-circle"></i>
                          Add Complaint
                      </button>
                    </a> --}}
                </div>
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>Bus No</th>
                    <th>Route</th>
                    <th>Driver</th>
                    <th>Contact</th>
                    {{-- <th>Status</th> --}}
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($feedbacks as $feedback)
                        <tr>
                            <td>{{ $feedback->bus->bus_no }}</td>
                            <td>{{ $feedback->bus->route->route_name }}</td>
                            <td>{{ $feedback->driver->full_name }}</td>
                            <td>{{ $feedback->driver->contact }}</td>
                            {{-- <td>
                                @php
                                    $color = $complaint->status == 'pending' ? 'warning' : ($complaint->status == 'progress' ? 'danger' : 'success');
                                    $textColor = $complaint->status == 'pending' ? 'dark' : ($complaint->status == 'progress' ? 'light' : 'light');
                                    $icon = $complaint->status == 'pending' ? 'bi-exclamation-triangle' : ($complaint->status == 'progress' ? 'bi-exclamation-octagon' : 'bi-check-circle');
                                @endphp
                                <span class="badge rounded-pill bg-{{ $color }} text-{{ $textColor }}">
                                    <i class="bi {{ $icon }} me-1"></i> {{ Str::ucfirst($complaint->status)}}
                                </span>
                            </td> --}}
                            <td>
                                <div class="form-button-action">
                                <a href="{{ route('feedback.show', ['id' => $feedback->id])}}" title="Show">
                                    <button type="button" data-bs-toggle="tooltip" title="Show"
                                        class="btn btn-link btn-info btn-lg rounded-pill" data-original-title="Show Task" >
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

@endsection
