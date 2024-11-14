@extends('admin.layouts.main')

@push('header')
    <title>Routes stops</title>
@endpush

@section('admin-main')

    <div class="pagetitle">
      <h1>Route's Stops</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Route</li>
          <li class="breadcrumb-item active">Stops</li>
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

    <section class="section dashboard">
        <div class="row ">

            <!-- Left side columns -->
            <div class="col-lg-6 position-sticky">
                <div class="card sticky-md-top">
                    <div class="card-body">
                        <h5 class="card-title">Route</h5>
                        <div>
                          <b>Route Name : </b><span>{{ $route->route_name }}</span>
                        </div>
                        <div>
                            <b>Start Location : </b><span>{{ $route->start_location }}</span>
                        </div>
                        <div>
                            <b>End Location : </b><span>{{ $route->end_location }}</span>
                        </div>

                      <!-- Multi Columns Form -->
                      <form method="post" action="{{ route('route.add', ['id'=>$id]) }}" class="mt-2 row g-3">
                        @csrf
                        <div class="col-md-2">
                            <label for="stop_order" class="form-label">Order</label>
                            <input type="number" class="form-control" min="1" max="99"
                                id="stop_order" name="stop_order"
                                value="{{ old('stop_order') ?? '' }}">
                        </div>
                        <div class="col-md-10">
                            <label for="stop" class="form-label">Stops</label>
                            <select id="stop" name="stop" class="form-select">
                                <option value="" selected>Choose...</option>
                                @foreach ($stops as $stop)
                                    <option value="{{ $stop->id }}">{{ $stop->stop_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('stop')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        @error('stop_order')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-node-plus"></i>
                                Add Stop
                            </button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                      </form><!-- End Multi Columns Form -->

                    </div>
                </div>
            </div><!-- End Left side columns -->

            <!-- Right side columns -->
            <div class="col-lg-6">
                <!-- Recent Activity -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Route Stops </h5>

                        <div class="activity">
                            @foreach ( $route->stops as $stop)
                            {{-- bi-circle-fill --}}
                                <div class="activity-item d-flex">
                                    <div class="activite-label">{{ $stop->fee }}</div>
                                    <a href="{{ route('route.detach', ['id'=>$id, 'stopId'=> $stop->id]) }}" title="Remove Stop">
                                        <i class='bi bi-node-minus-fill activity-badge text-success align-self-start fs-3'></i>
                                    </a>
                                    <div class="activity-content">
                                        <form action="{{ route('route.sync', ['id'=>$id, 'stopId'=> $stop->id]) }}" method="post">
                                            <div class="row">
                                                @csrf
                                                <div class="col-md-3">
                                                    <input type="text" class="w-2 form-control" min="1" max="99"
                                                        id="order" name="stop_order{{ $stop->id }}"
                                                        value="{{ old('stop_order') ?? $stop->pivot->stop_order ?? '' }}">
                                                </div>
                                                <div class="text-center col-md-2">
                                                    <button type="submit" class="btn btn-primary" title="Update Sequece">
                                                        <i class="bi bi-arrow-repeat"></i>
                                                    </button>
                                                </div>
                                                @error('stop_order'.$stop->id)
                                                        <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                                <div class="col-md-9">
                                                    <b href="#" class="fw-bold text-dark">{{ $stop->stop_name }}</b>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div><!-- End activity item-->
                            @endforeach
                        </div>
                    </div>
                </div><!-- End Recent Activity -->
            </div><!-- End Right side columns -->

        </div>
      </section>

@endsection
