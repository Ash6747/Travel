@extends('admin.layouts.main')

@push('header')
    <title>Students</title>
@endpush

@section('admin-main')

    <div class="pagetitle">
      <h1>Student Table</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Students</li>
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
                    <h5 class="card-title">Students</h5>
                    {{-- <a class="ms-2" href="{{ route('booking.table') }}">
                      <button class="btn btn-primary rounded-pill ">
                          <i class="bi bi-info-circle"></i>
                          All Type Students
                      </button>
                    </a>
                    <a class="ms-2" href="{{ route('booking.pending') }}">
                      <button class="btn btn-warning rounded-pill ">
                          <i class="bi bi-exclamation-triangle"></i>
                          Pending
                      </button>
                    </a> --}}
                </div>
              <!-- Table with stripped rows -->
              <table
               id="multi-filter-select"
               class="table display nowrap datatable table-striped table-hover">
                <thead>
                  <tr>
                    <th>PRN</th>
                    <th>Full Name</th>
                    <th>Course</th>
                    <th>Addmission Year</th>
                    <th>Contact</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $student->prn }}</td>
                            <td>{{ $student->full_name }}</td>
                            <td>{{ $student->course->coures_code }}</td>
                            <td>{{ $student->admission_year }}</td>
                            <td>{{ $student->contact }}</td>
                            <td>
                                <div class="form-button-action">
                                    <a href="{{ route('student.edit', ['id' => $student->id])}}">
                                        <button type="button" data-bs-toggle="tooltip" title="Open Details"
                                            class="btn btn-link btn-info btn-lg rounded-pill" data-original-title="Open Details" >
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
