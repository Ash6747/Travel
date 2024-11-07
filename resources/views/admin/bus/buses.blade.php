@extends('admin.layouts.main')

@push('header')
    <title>Buses</title>
@endpush

@section('admin-main')

    <div class="pagetitle">
      <h1>Bus Table</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Buses</li>
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
                    <h5 class="card-title">Buses</h5>
                    <a class="ms-2" href="{{ route('bus.table') }}">
                        <button class="btn btn-primary rounded-pill ">
                            <i class="bi bi-info-circle"></i>
                            All Type Buses
                        </button>
                    </a>
                    <a class="ms-2" href="{{ route('bus.enabled') }}">
                        <button class="btn btn-success rounded-pill ">
                            <i class="bi bi-check-circle"></i>
                            Active
                        </button>
                    </a>
                    <a class="ms-2" href="{{ route('bus.disabled') }}">
                        <button class="btn btn-danger rounded-pill ">
                            <i class="bi bi-exclamation-octagon"></i>
                            Inactive
                        </button>
                    </a>

                    <a class="ms-auto" href="{{ route('bus.export', ['status' => $status]) }}" title="Download Excel">
                        <button class="btn btn-dark rounded-pill">
                            <i class="ri ri-download-line"></i>
                            <i class="ri ri-file-excel-2-line"></i>
                        </button>
                    </a>
                    <a class="ms-2" href="{{ route('bus.create') }}">
                      <button class="btn btn-primary rounded-pill ">
                          <i class="bi bi-plus-circle"></i>
                          Add Bus
                      </button>
                    </a>
                </div>
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>Bus No.</th>
                    <th>Capacity</th>
                    <th>Route</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($buses as $bus)
                        <tr>
                            <td>{{ $bus->bus_no }}</td>
                            <td>{{ $bus->capacity }}</td>
                            <td>{{ $bus->route->route_name }}</td>
                            <td>
                                <a class="badge rounded-pill bg-{{ $bus->status? 'success' : 'danger' }}" href="{{ route('bus.status', ['id' => $bus->id])}}">
                                    <i class="bi {{ $bus->status? 'bi-check-circle' : 'bi-exclamation-octagon' }} me-1"></i> {{ $bus->status? 'Active' : 'Inactive' }}
                                </a>
                            </td>
                            <td>
                                <div class="form-button-action">
                                <a href="{{ route('bus.edit', ['id' => $bus->id])}}">
                                    <button type="button" data-bs-toggle="tooltip" title="Edit"
                                        class="btn btn-link btn-info btn-lg rounded-pill" data-original-title="Edit Task" >
                                        <i class="bi text-secondary-emphasis bi-pencil-square"></i>
                                    </button>
                                </a>
                                {{-- <a href="{{ route('bus.delete', ['id' => $bus->id]) }}">
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
