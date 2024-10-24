<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Profile Completion</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
  {{-- <pre>
      @php
          print_r($errors->all());
          // print_r($user->all());
          // echo $user->role;
      @endphp
  </pre> --}}
  <main>
    <div class="container">

      <section class="py-4 section register min-vh-100 d-flex flex-column align-items-center justify-content-center">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="py-4 d-flex justify-content-center">
                <a href="index.html" class="w-auto logo d-flex align-items-center">
                  <img src="{{ asset('assets/img/logo.png') }}" alt="">
                  {{-- <span class="d-none d-lg-block">SafeRide</span> --}}
                  <span class="d-none d-lg-block">
                    <i class="bi bi-truck-front"></i> SafeRide
                </span>

                </a>
              </div><!-- End Logo -->

              <div class="mb-3 card">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="pb-0 text-center card-title fs-4 text-info">Personal Details</h5>
                    <p class="text-center small">Provide your details to set up your profile</p>
                  </div>

                  <!-- Multi Columns Form -->
              <form class="row g-3" method="POST" action="{{ route('complete-profile', ['id'=> $user->id]) }}" enctype="multipart/form-data">
                @csrf
                {{-- <input type="number" value="{{ $user->id }}" name="user_id" hidden> --}}

                <div class="col-md-12">
                  <label for="profile" class="form-label">Profile Photo Upload</label>
                  <input class="form-control" type="file" accept="image/*" id="profile" name="profile" value="{{ old('profile') }}">
                  @error('profile')
                      <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-12">
                  <div class="row">
                    <label class="form-label">User Full Name</label>
                    <div class="col-md-4">
                      <label for="firstName" class="form-label">First</label>
                      <input type="text" class="form-control" id="firstName" name="firstName" value="{{ old('firstName') }}">
                      @error('firstName')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="col-md-4">
                      <label for="middleName" class="form-label">Middle</label>
                      <input type="text" class="form-control" id="middleName" name="middleName" value="{{ old('middleName') }}">
                      @error('middleName')
                      <div class="text-danger">{{ $message }}</div>
                  @enderror
                    </div>
                    <div class="col-md-4">
                      <label for="lastName" class="form-label">Last</label>
                      <input type="text" class="form-control" id="lastName" name="lastName" value="{{ old('lastName') }}">
                      @error('lastName')
                      <div class="text-danger">{{ $message }}</div>
                  @enderror
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="contact" class="form-label">Contact</label>
                  <input type="tel" class="form-control" id="contact" name="contact"  pattern="\d{10}" maxlength="10" value="{{ old('contact') }}">
                  @error('contact')
                      <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-6">
                  <label for="whatsup_no" class="form-label">Whats'up No.</label>
                  <input type="tel" class="form-control" id="whatsup_no" name="whatsup_no"  pattern="\d{10}" maxlength="10" value="{{ old('whatsup_no') }}">
                  @error('whatsup_no')
                      <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>

                @if ($user->role == 'driver')
                  {{-- driver --}}
                  <div class="col-md-12">
                    <label for="license_file" class="form-label">License ID Upload</label>
                    <input class="form-control" type="file" accept="image/*" id="license_file" name="license_file" value="{{ old('license_file') }}">
                    @error('license_file')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-6">
                    <label for="license_number" class="form-label">License No.</label>
                    <input type="text" class="form-control" id="license_number" name="license_number" maxlength="10" value="{{ old('license_number') }}">
                    @error('license_number')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-6">
                    <label for="license_exp" class="form-label">License Expire Date</label>
                    <input type="date" class="form-control" id="license_exp" name="license_exp" value="{{ old('license_exp') }}">
                    @error('license_exp')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-12">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" style="height: 100px" id="address" name="address" placeholder="address">{{ old('address') }}</textarea>
                    @error('address')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    {{-- <input type="text" class="form-control" id="inputAddres5s" placeholder="1234 Main St"> --}}
                  </div>

                  <div class="col-md-6">
                    <label for="pincode" class="form-label">Zip</label>
                    <input type="text" class="form-control" id="pincode" name="pincode"  pattern="\d{6}" maxlength="6" value="{{ old('pincode') }}">
                    @error('pincode')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                @elseif ($user->role == 'student')
                  {{-- student --}}
                  <div class="col-md-6">
                    <label for="prn" class="form-label">PRN No.</label>
                    <input type="text" class="form-control" id="prn" name="prn" value="{{ old('prn') }}">
                    @error('prn')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-6">
                    <label for="dob" class="form-label">Date Of Birth</label>
                    <input type="date" class="form-control" id="dob" name="dob" value="{{ old('dob') }}">
                    @error('dob')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-12">
                    <label for="course" class="form-label">Course</label>
                    <input type="text" class="form-control" id="course" name="course" value="BSC">
                    @error('course')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  @php
                    $currentYear = now()->year; // Get current year
                    $startYear = $currentYear - 10; // Start 10 years ago
                    {{-- $endYear = $currentYear + 10; // End 10 years from now --}}
                  @endphp
                  <div class="form-group col-12">
                    <label for="year">Select Addmission Year</label>
                    <select name="year" id="year" class="form-control">
                        <option value="">-- Select Year --</option>
                        @for ($year = $startYear; $year <= $endYear; $year++)
                            <option value="{{ $year }}" {{ old('year') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                    @error('year')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-md-12">
                    <div class="row">
                      <label class="form-label">Guardian Full Name</label>
                      <div class="col-md-4">
                        <label for="guardianFirstName" class="form-label">First</label>
                        <input type="text" class="form-control" id="guardianFirstName" value="{{ old('guardianFirstName') }}" name="guardianFirstName">
                        @error('guardianFirstName')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="col-md-4">
                        <label for="guardianMiddleName" class="form-label">Middle</label>
                        <input type="text" class="form-control" id="guardianMiddleName" name="guardianMiddleName" value="{{ old('guardianMiddleName') }}">
                        @error('guardianMiddleName')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="col-md-4">
                        <label for="guardianLastName" class="form-label">Last</label>
                        <input type="text" class="form-control" id="guardianLastName" name="guardianLastName" value="{{ old('guardianLastName') }}">
                        @error('guardianLastName')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label for="guardianContact" class="form-label">Guardian Contact</label>
                    <input type="tel" class="form-control" id="guardianContact" name="guardianContact"  pattern="\d{10}" maxlength="10" value="{{ old('guardianContact') }}">
                    @error('guardianContact')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-6">
                    <label for="guardianEmail" class="form-label">Guardian Email</label>
                    <input type="email" class="form-control" id="guardianEmail" name="guardianEmail" value="{{ old('guardianEmail') }}">
                    @error('guardianEmail')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-12">
                    <label for="address" class="form-label">Guardian Address</label>
                    <textarea class="form-control" style="height: 100px" id="address" name="address" placeholder="1234 Main St">{{ old('address') }}</textarea>
                    @error('address')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    {{-- <input type="text" class="form-control" id="inputAddres5s" placeholder="1234 Main St"> --}}
                  </div>

                  <div class="col-md-6">
                    <label for="pincode" class="form-label">Zip</label>
                    <input type="text" class="form-control" id="pincode" name="pincode" pattern="\d{6}" maxlength="6" value="{{ old('pincode') }}">
                    @error('pincode')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>

                @elseif ($user->role == 'guardian')
                {{-- guardian --}}
                @elseif ($user->role == 'admin')
                  {{-- admin --}}

                  <div class="col-md-12">
                    <label for="identity_file" class="form-label">College ID Upload</label>
                    <input class="form-control" type="file" accept="image/*" id="identity_file" name="identity_file" value="{{ old('identity_file') }}">
                    @error('identity_file')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-md-12">
                    <label for="identity_number" class="form-label">College ID No.</label>
                    <input type="text" class="form-control" id="identity_number" name="identity_number" maxlength="10" value="{{ old('identity_number') }}">
                    @error('identity_number')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                @endif
                <input type="number" value="{{ $user->id }}" name="user_id" hidden>

                @error('user_id')
                    <div class="text-danger">{{ $message }}</div>
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
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
  <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
  <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
  <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>
