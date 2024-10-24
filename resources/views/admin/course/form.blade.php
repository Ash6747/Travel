@extends('admin.layouts.main')

@push('header')
    <title >Course form</title>
@endpush

@section('admin-main')

    <div class="pagetitle">
      <h1>Course Form</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Courses</li>
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
                  <form method="post" action="{{ isset($course) ? route($url, ['id'=>$id]) : route($url) }}" class="row g-3">
                    @csrf
                    <div class="col-md-12">
                      <label for="coures_full_name" class="form-label">Course Full Name</label>
                      <input type="text" class="form-control"
                        id="coures_full_name" name="coures_full_name"
                        value="{{ old('coures_full_name') ?? $course->coures_full_name ?? '' }}">
                      @error('coures_full_name')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="col-md-6">
                      <label for="coures_short_name" class="form-label">Coures Short Name</label>
                      <input type="text" class="form-control"
                        id="coures_short_name" name="coures_short_name"
                        value="{{ old('coures_short_name') ?? $course->coures_short_name ?? '' }}">
                      @error('coures_short_name')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="col-md-4">
                      <label for="coures_code" class="form-label">Coures Code</label>
                      <input type="text" class="form-control"
                        id="coures_code" name="coures_code"
                        value="{{ old('coures_code') ?? $course->coures_code ?? '' }}">
                      @error('coures_code')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>

                    <div class="col-md-2">
                      <label for="coures_years" class="form-label">Coures Years</label>
                      <input type="number" class="form-control" id="coures_years" name="coures_years"
                        value="{{ old('coures_years') ?? $course->coures_years ?? '' }}">
                      @error('coures_years')
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
