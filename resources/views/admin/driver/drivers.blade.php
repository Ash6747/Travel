@extends('admin.layouts.main')

@push('header')
    <title>Drivers</title>
@endpush

@section('admin-main')

    <div class="pagetitle">
      <h1 style="color: blue;">Drivers Table</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Drivers</li>
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
                    <h5 class="card-title" style="color: red;">Verified Drivers</h5>
                    <a class="ms-2" href="{{ route('driver.table') }}">
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
                    </a>
                </div>

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>
                      <b>Name</b>
                    </th>
                    <th>Contact</th>
                    <th>Whats's up No.</th>
                    <th>License No.</th>
                    <th data-type="date" data-format="YYYY/DD/MM">Exp. Date</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($drivers as $driver)
                        <tr>
                            <td>{{ $driver->full_name }}</td>
                            <td>{{ $driver->contact }}</td>
                            <td>{{ $driver->whatsup_no }}</td>
                            <td>{{ $driver->license_number }}</td>
                            <td>{{ $driver->license_exp }}</td>
                            <td>
                                <a class="badge rounded-pill bg-{{ $driver->status? 'success' : 'danger' }}" href="{{ route('driver.status', ['id' => $driver->id])}}">
                                    <i class="bi {{ $driver->status? 'bi-check-circle' : 'bi-exclamation-octagon' }} me-1"></i> {{ $driver->status? 'Active' : 'Inactive' }}
                                </a>
                            </td>
                            <td>
                                <div class="form-button-action">
                                <a href="{{ route('driver.edit', ['id' => $driver->id])}}" title="Edit">
                                    <button type="button" data-bs-toggle="tooltip" title="Edit"
                                        class="btn btn-link btn-info btn-lg rounded-pill" data-original-title="Edit Task" >
                                        <i class="bi text-secondary-emphasis bi-pencil-square"></i>
                                    </button>
                                </a>
                                <a href="{{ route('driver.leaves', ['id' => $driver->id]) }}" title="Leaves">
                                    <button type="button" data-bs-toggle="tooltip"
                                        class="btn btn-link btn-danger btn-lg rounded-pill" >
                                        <i class="bi bi-calendar-x text-secondary-emphasis"></i>
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
