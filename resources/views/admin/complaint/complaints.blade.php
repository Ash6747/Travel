@extends('admin.layouts.main')

@push('header')
    <title>Complaints</title>
@endpush

@section('admin-main')

    <div class="pagetitle">
      <h1>Complaints Table</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Complaints</li>
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
                    <h5 class="card-title">Complaints</h5>
                    <a class="ms-2" href="{{ route('complaint.table') }}">
                        <button class="btn btn-primary rounded-pill ">
                            <i class="bi bi-info-circle"></i>
                            All Type Complaints
                        </button>
                    </a>
                    <a class="ms-2" href="{{ route('complaint.pending') }}">
                        <button class="btn btn-warning rounded-pill ">
                            <i class="bi bi-exclamation-triangle"></i>
                            Pending
                        </button>
                    </a>
                    <a class="ms-2" href="{{ route('complaint.progress') }}">
                        <button class="btn btn-danger rounded-pill ">
                            <i class="bi bi-exclamation-octagon"></i>
                            Progress
                        </button>
                    </a>
                    <a class="ms-2" href="{{ route('complaint.resolved') }}">
                        <button class="btn btn-success rounded-pill ">
                            <i class="bi bi-check-circle"></i>
                            Resolved
                        </button>
                    </a>

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
                    <th>PRN</th>
                    <th>Name</th>
                    <th>Details</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($complaints as $complaint)
                        <tr>
                            <td>{{ $complaint->student->prn }}</td>
                            <td>{{ $complaint->student->full_name }}</td>
                            <td>{{ $complaint->details }}</td>
                            <td>
                                @php
                                    $color = $complaint->status == 'pending' ? 'warning' : ($complaint->status == 'progress' ? 'danger' : 'success');
                                    $textColor = $complaint->status == 'pending' ? 'dark' : ($complaint->status == 'progress' ? 'light' : 'light');
                                    $icon = $complaint->status == 'pending' ? 'bi-exclamation-triangle' : ($complaint->status == 'progress' ? 'bi-exclamation-octagon' : 'bi-check-circle');
                                @endphp
                                <span class="badge rounded-pill bg-{{ $color }} text-{{ $textColor }}">
                                    <i class="bi {{ $icon }} me-1"></i> {{ Str::ucfirst($complaint->status)}}
                                </span>
                            </td>
                            <td>
                                <div class="form-button-action">
                                <a href="{{ route('complaint.edit', ['id' => $complaint->id])}}" title="Edit">
                                    <button type="button" data-bs-toggle="tooltip" title="Edit"
                                        class="btn btn-link btn-info btn-lg rounded-pill" data-original-title="Edit Task" >
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
