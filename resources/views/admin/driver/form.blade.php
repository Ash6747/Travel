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
          <li class="breadcrumb-item active">{{ $routTitle }}</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <section class="section">
      <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                  <h5 class="card-title">{{ $title }}</h5>

                  <!-- Multi Columns Form -->
                  <form method="post" action="{{ route($url, ['id'=>$id]) }}" enctype="multipart/form-data" class="row g-3">
                    @csrf
                    <div class="col-md-4">
                      <label for="firstName" class="form-label">First Name</label>
                      <input type="text" class="form-control"
                        id="firstName" name="firstName"
                            pattern="^[A-Za-z]+(\s[A-Za-z]+)*$"
                            title="Please enter a valid first name without spaces"  maxlength="20"
                        value="{{ old('firstName') ?? $driverName[0] ?? '' }}">
                      @error('firstName')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="col-md-4">
                      <label for="middleName" class="form-label">Middle Name</label>
                      <input type="text" class="form-control"
                        pattern="^[A-Za-z]+(\s[A-Za-z]+)*$"
                        title="Please enter a valid middle name without spaces"  maxlength="20"
                        id="middleName" name="middleName"
                        value="{{ old('middleName') ?? $driverName[1] ?? '' }}">
                      @error('middleName')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="col-md-4">
                      <label for="lastName" class="form-label">Last Name</label>
                      <input type="text" class="form-control"
                        pattern="^[A-Za-z]+(\s[A-Za-z]+)*$"
                        title="Please enter a valid last name without spaces"  maxlength="20"
                        id="lastName" name="lastName"
                        value="{{ old('lastName') ?? $driverName[2] ?? '' }}">
                      @error('lastName')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="contact" class="form-label">Contact</label>
                        <input type="text" class="form-control" id="contact" title="Phone number must be exactly 10 digits."
                            pattern="\d{10}" maxlength="10" name="contact"
                            value="{{ old('contact') ?? $driver->contact ?? '' }}">
                        @error('contact')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="whatsup_no" class="form-label">What's up Number</label>
                        <input type="text" class="form-control" id="whatsup_no" title="Phone number must be exactly 10 digits."
                            pattern="\d{10}" maxlength="10" name="whatsup_no"
                            value="{{ old('whatsup_no') ?? $driver->contact ?? '' }}">
                        @error('whatsup_no')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="license_number" class="form-label">License Number</label>
                        <input type="text" class="form-control"
                            id="license_number" maxlength="10" name="license_number"
                            value="{{ old('license_number') ?? $driver->contact ?? '' }}">
                        @error('license_number')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>

                    <div class="col-6">
                        <label for="profile" class="form-label">Profile File</label>
                        <input type="file" class="mb-3 form-control" id="profile" name="profile" accept="image/*"
                        onchange="document.querySelector('#target_profile').src = window.URL.createObjectURL(this.files[0])" value="{{ old('profile') }}">

                        <label for="target_profile" class="form-label">Profile :</label>
                        @isset($driver)
                            <img class="img-fluid" id="target_profile"
                                src="{{ $driver->profile ? asset('/storage/' . $driver->profile) : asset('assets/img/profile.png') }}"
                                alt="license">
                        @else
                            <img class="img-fluid" id="target_profile" src="{{ asset('assets/img/profile.png') }}" alt="profile">
                        @endisset
                        {{-- <img class="img-fluid" id="target_profile" src="{{ $driver->profile ? asset('/storage/'.$driver->profile) : asset('assets/img/profile.png') }}" alt="profile"> --}}
                        @error('profile')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>
                    <div class="col-6">
                        <label for="license_file " class="form-label">License File</label>
                        <input type="file" class="mb-2 form-control" id="license_file" name="license_file" accept="image/*" value="{{ old('license_file') }}"
                        onchange="document.querySelector('#target_license_file').src = window.URL.createObjectURL(this.files[0])">

                        <label for="target_license_file" class="form-label">License :</label>
                        @isset($driver)
                            <img class="img-fluid" id="target_license_file"
                                src="{{ $driver->license_file ? asset('/storage/' . $driver->license_file) : asset('assets/img/license2.jpg') }}"
                                alt="license">
                        @else
                            <img class="img-fluid" id="target_license_file" src="{{ asset('assets/img/license2.jpg') }}" alt="license">
                        @endisset

                        {{-- <img class="img-fluid" id="target_license_file"
                        src="{{ isset($driver) ? asset('/storage/'.$driver->license_file) : asset('assets/img/license2.jpg') }}"
                        alt="license"> --}}

                        @error('license_file')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12">
                      <label for="address" class="form-label">Address</label>
                      <input type="text" class="form-control" id="address" name="address" placeholder="address" value="{{ old('address') ?? $driver->address ?? '' }}">
                      @error('address')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>


                    <div class="col-md-2">
                      <label for="pincode" class="form-label">Zip</label>
                      <input type="text" class="form-control" id="pincode" pattern="\d{6}" maxlength="6" name="pincode" value="{{ old('pincode') ?? $driver->pincode ?? '' }}">
                      @error('pincode')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>

                    <div class="col-4">
                        <label for="license_exp" class="form-label">License Expiration Date</label>
                        <input type="date" class="form-control" id="license_exp" name="license_exp" accept="image/*" value="{{ old('license_exp') ?? $driver->license_exp ?? '' }}">
                        @error('license_exp')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <input type="number" value="{{ $id }}" name="user_id" hidden>
                    @error('user_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

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
