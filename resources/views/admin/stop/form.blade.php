@extends('admin.layouts.main')

@push('header')
    <title >Stops form</title>
@endpush

@section('admin-main')

    <div class="pagetitle">
      <h1>Stops Form</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Stops</li>
          <li class="breadcrumb-item active">{{ $routTitle }}</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    {{-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif --}}

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                  <h5 class="card-title">{{ $title }}</h5>

                  <!-- Multi Columns Form -->
                  <form method="post" action="{{ isset($stop) ? route($url, ['id'=>$id]) : route($url) }}" class="row g-3">
                    @csrf
                    <div class="col-md-12">
                      <label for="stop_name" class="form-label">Stop Name</label>
                      <input type="text" class="form-control"
                        id="stop_name" name="stop_name"
                        value="{{ old('stop_name') ?? $stop->stop_name ?? '' }}">
                      @error('stop_name')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="col-md-4">
                      <label for="longitude" class="form-label">Longitude</label>
                      <input type="text" class="form-control"
                        id="longitude" name="longitude"
                        value="{{ old('longitude') ?? $stop->longitude ?? '' }}">
                      @error('longitude')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="col-md-4">
                      <label for="latitude" class="form-label">Latitude</label>
                      <input type="text" class="form-control"
                        id="latitude" name="latitude"
                        value="{{ old('latitude') ?? $stop->latitude ?? '' }}">
                      @error('latitude')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>

                    <div class="col-md-4">
                      <label for="fee" class="form-label">Fee</label>
                      <input type="number" class="form-control" id="fee" name="fee"
                        value="{{ old('fee') ?? $stop->fee ?? '' }}">
                      @error('fee')
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
