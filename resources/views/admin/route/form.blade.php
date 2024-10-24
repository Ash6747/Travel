@extends('admin.layouts.main')

@push('header')
    <title>Routes</title>
@endpush

@section('admin-main')

    <div class="pagetitle">
      <h1 style="color: rgb(25, 0, 255);">Routes Form</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Route</li>
          <li class="breadcrumb-item active">{{ $routTitle }}</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                  <h5 class="card-title">{{ $title }}</h5>

                  <!-- Multi Columns Form -->
                  <form method="post" action="{{ isset($route) ? route($url, ['id'=>$id]) : route($url) }}" enctype="multipart/form-data" class="row g-3">
                    @csrf
                    <div class="col-md-12">
                      <label for="route_name" class="form-label">Route Name</label>
                      <input type="text" class="form-control"
                        id="route_name" name="route_name"
                        value="{{ old('route_name') ?? $route->route_name ?? '' }}">
                      @error('route_name')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="col-md-12">
                      <label for="start_location" class="form-label">Start Location</label>
                      <input type="text" class="form-control"
                        id="start_location" name="start_location"
                        value="{{ old('start_location') ?? $route->start_location ?? '' }}">
                      @error('start_location')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="col-md-12">
                      <label for="end_location" class="form-label">End Location</label>
                      <input type="text" class="form-control"
                        id="end_location" name="end_location"
                        value="{{ old('end_location') ?? $route->end_location ?? '' }}">
                      @error('end_location')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                  </form><!-- End Multi Columns Form -->

                </div>
              </div>

        </div>
      </div>
    </section>

@endsection
