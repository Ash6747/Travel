@extends('admin.layouts.main')

@push('header')
    <title>Buses</title>
@endpush

@section('admin-main')

    <div class="pagetitle">
      <h1>Buses Form</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Buses</li>
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
                  <form method="post" action="{{ isset($bus) ? route($url, ['id'=>$id]) : route($url) }}" enctype="multipart/form-data" class="row g-3">
                    @csrf
                    <div class="col-md-4">
                      <label for="bus_no" class="form-label">Bus Number</label>
                      <input type="text" class="form-control"
                        id="bus_no" name="bus_no"
                        value="{{ old('bus_no') ?? $bus->bus_no ?? '' }}">
                        @error('bus_no')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-2">
                      <label for="capacity" class="form-label">Capacity</label>
                      <input type="number" class="form-control"
                        id="capacity" name="capacity"
                        value="{{ old('capacity') ?? $bus->capacity ?? '' }}">
                      @error('capacity')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Route</label>
                        {{-- <select class="form-select" aria-label="Default select example" name="route_id">
                            <option value="" selected >Select Route</option>
                            @foreach ($routes as $route)
                            <option value="{{ $route->id }}" {{ isset($bus) ? ($route->id == $bus->route_id ? 'selected' : '') : (old('route_id') == $route->id ? 'selected' : '') }}>{{ $route->start_location }} - {{ $route->end_location }}</option>
                            @endforeach
                        </select> --}}
                        <input list="routes" name="route_id" id="route" class="form-control">
                        <datalist id="routes">
                            @foreach ($routes as $route)
                            <option value="{{ $route->id }}" {{ isset($bus) ? ($route->id == $bus->route_id ? 'selected' : '') : (old('route_id') == $route->id ? 'selected' : '') }}>{{ $route->start_location }} - {{ $route->end_location }}</option>
                            @endforeach
                          </datalist>
                        @error('route_id')
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
