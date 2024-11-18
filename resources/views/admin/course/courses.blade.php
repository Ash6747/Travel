@extends('admin.layouts.main')

@push('header')
    <title>Courses</title>
@endpush

@section('admin-main')

    <div class="pagetitle">
      <h1 style="color: blue;">Courses Table</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Courses</li>
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
                    <h5 class="card-title">Courses</h5>
                    <a class="ms-2" href="{{ route('course.table') }}">
                        <button class="btn btn-primary rounded-pill ">
                            <i class="bi bi-info-circle"></i>
                            All Type Courses
                        </button>
                    </a>
                    <a class="ms-2" href="{{ route('course.enabled') }}">
                        <button class="btn btn-success rounded-pill ">
                            <i class="bi bi-check-circle"></i>
                            Active
                        </button>
                    </a>
                    <a class="ms-2" href="{{ route('course.disabled') }}">
                        <button class="btn btn-danger rounded-pill ">
                            <i class="bi bi-exclamation-octagon"></i>
                            Inactive
                        </button>
                    </a>

                    <a class="ms-auto" href="{{ route('course.create') }}" title="Add Course">
                      <button class="btn btn-primary rounded-pill ">
                          <i class="bi bi-journal-plus"></i>
                          Add Course
                      </button>
                    </a>
                </div>
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>Course Full Name</th>
                    <th>Course Short Name</th>
                    <th>Course Code</th>
                    <th>Course Years</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        <tr>
                            <td>{{ $course->coures_full_name }}</td>
                            <td>{{ $course->coures_short_name }}</td>
                            <td>{{ $course->coures_code }}</td>
                            <td>{{ $course->coures_years }}</td>
                            <td>
                                <a class="badge rounded-pill bg-{{ $course->status? 'success' : 'danger' }}" href="{{ route('course.status', ['id' => $course->id])}}">
                                    <i class="bi {{ $course->status? 'bi-check-circle' : 'bi-exclamation-octagon' }} me-1"></i> {{ $course->status? 'Active' : 'Inactive' }}
                                </a>
                            </td>
                            <td>
                                <div class="form-button-action">
                                <a href="{{ route('course.edit', ['id' => $course->id])}}" title="Edit">
                                    <button type="button" data-bs-toggle="tooltip" title="Edit"
                                        class="btn btn-link btn-info btn-lg rounded-pill" data-original-title="Edit Task" >
                                        <i class="bi text-secondary-emphasis bi-pencil-square"></i>
                                    </button>
                                </a>
                                {{-- <a href="{{ route('course.delete', ['id' => $route->id]) }}">
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

@endsection
