@extends('admin.layouts.main')

@push('header')
    <title>Trip</title>
@endpush

@section('admin-main')

    <div class="pagetitle">
      <h1>Trip Form</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Trip</li>
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
                  <form method="post" action="{{ isset($trip) ? route($url, ['id'=>$id]) : route($url) }}" enctype="multipart/form-data" class="row g-3">
                    @csrf

                    <div class="col-md-5">
                        <label for="expected_morning_start_time" class="form-label">Morning Start and End Time</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Start:</span>
                            {{-- <input type="time" class="form-control"> --}}
                            <input type="time" class="form-control"
                                name="expected_morning_start_time"
                                value="{{ old('expected_morning_start_time') ?? $trip->expected_morning_start_time ?? '' }}">
                            <span class="input-group-text">End:</span>
                            <input type="time" class="form-control"
                                name="expected_morning_end_time"
                                value="{{ old('expected_morning_end_time') ?? $trip->expected_morning_end_time ?? '' }}">
                        </div>
                        @error('expected_morning_start_time')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        @error('expected_morning_end_time')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-5">
                        <label for="expected_evening_start_time" class="form-label">Evening Start and End Time</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Start:</span>
                            <input type="time" class="form-control"
                                name="expected_evening_start_time"
                                value="{{ old('expected_evening_start_time') ?? $trip->expected_evening_start_time ?? '' }}"
                                aria-label="expected_evening_start_time">

                            <span class="input-group-text">End:</span>
                            <input type="time" class="form-control"
                                name="expected_evening_end_time"
                                value="{{ old('expected_evening_end_time') ?? $trip->expected_evening_end_time ?? '' }}"
                                aria-label="expected_evening_end_time">
                        </div>
                        @error('expected_evening_start_time')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        @error('expected_evening_end_time')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-2">
                      <label for="expected_distance" class="form-label">Expected Distance</label>
                      <input type="number" class="form-control"
                        id="expected_distance" name="expected_distance"
                        placeholder="0.00"
                        min="0.00" max="999.99"
                        value="{{ old('expected_distance') ?? $trip->expected_distance ?? '' }}">
                        @error('expected_distance')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Bus of Route</label>
                        <select class="form-select" aria-label="Default select example" name="bus_id">
                            <option value="" selected >Select Bus of Route</option>
                            @isset($trip)
                                <option value="{{ $trip->bus->id }}" {{ isset($trip) ? ($trip->bus->id == $trip->bus_id ? 'selected' : '') : (old('bus_id') == $trip->bus->id ? 'selected' : '') }}>{{ $trip->bus->bus_no }} | {{ $trip->bus->route->route_name }}</option>
                            @endisset
                            @foreach ($buses as $bus)
                                <option value="{{ $bus->id }}" {{ isset($trip) ? ($bus->id == $trip->bus_id ? 'selected' : '') : (old('bus_id') == $bus->id ? 'selected' : '') }}>{{ $bus->bus_no }} | {{ $bus->route->route_name }}</option>
                            @endforeach
                        </select>
                        @error('bus_id')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Driver for trip</label>
                        <select class="form-select" aria-label="Default select example" name="driver_id">
                            <option value="" selected >Select Driver</option>
                            @isset($trip)
                                <option value="{{ $trip->driver->id }}" {{ isset($trip) ? ($trip->driver->id == $trip->driver_id ? 'selected' : '') : (old('driver_id') == $trip->driver->id ? 'selected' : '') }}>{{ $trip->driver->full_name }} | {{ $trip->driver->license_number }}</option>
                            @endisset
                            @foreach ($drivers as $driver)
                                <option value="{{ $driver->id }}" {{ isset($trip) ? ($driver->id == $trip->driver_id ? 'selected' : '') : (old('driver_id') == $driver->id ? 'selected' : '') }}>{{ $driver->full_name }} | {{ $driver->license_number }}</option>
                            @endforeach
                        </select>
                        @error('driver_id')
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
