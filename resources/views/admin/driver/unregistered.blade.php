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
          <li class="breadcrumb-item">Non-Verified Drivers</li>
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
              <h5 class="card-title" style="color: red;">Non-Verified Drivers</h5>

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>
                      <b>N</b>ame
                    </th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($drivers as $driver)
                        <tr>
                            <td>{{ $driver->name }}</td>
                            <td>{{ $driver->email }}</td>
                            <td>{{ $driver->role }}</td>
                            <td>
                                <div class="form-button-action ">
                                    <a href="{{ route('driver.create', ['id' => $driver->id])}}">
                                        <button type="button" data-bs-toggle="tooltip" title="Join as Driver"
                                            class="text-black btn btn-link btn-info btn-lg text-decoration-none" data-original-title="Edit Task" >
                                            <i class="bi bi-person-plus"></i>
                                            Register
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
