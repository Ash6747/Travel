@extends('admin.layouts.main')

@push('header')
    <title>Profile</title>
@endpush

@section('admin-main')
    {{-- <pre>
      @php
        //   print_r($errors->all());
        //   print_r($user);
        // $userFirst = $user->first()
        $adminFirst = $user->admin->first()
        //   print_r($admin);
      @endphp
  </pre> --}}
    <div class="pagetitle">
        <h1>Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">{{ $user->role }}</li>
                <li class="breadcrumb-item active">Profile</li>
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
    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="pt-4 card-body profile-card d-flex flex-column align-items-center">

                        <img src="{{ asset('/storage/' . $user->admin->profile) }}" alt="Profile" class="rounded-circle">
                        <h2>{{ $user->admin->full_name }}</h2>
                        <h3></h3>
                        {{-- <div class="mt-2 social-links">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div> --}}
                    </div>
                </div>

            </div>

            <div class="col-xl-8">

                <div class="card">
                    <div class="pt-3 card-body">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab"
                                    data-bs-target="#profile-overview">Overview</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                    Profile</button>
                            </li>

                            {{-- <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Settings</button>
                </li> --}}

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#profile-change-password">Change Password</button>
                            </li>

                        </ul>
                        <div class="pt-2 tab-content">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                {{-- <h5 class="card-title">About</h5>
                  <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p> --}}

                                <h5 class="card-title">Profile Details</h5>

                                <div class="mb-3 row">
                                    <div class="col-lg-3 col-md-4 label ">Identity</div>
                                    <div class="col-md-8 col-lg-9">
                                        <img class="rounded img-fluid" id="targetIdentity_file" src="{{ asset('/storage/' . $user->admin->identity_file) }}"
                                            alt="identity_file" >
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->admin->full_name }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Phone</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->admin->contact }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">What's up No.</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->admin->whatsup_no }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Identity No</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->admin->identity_number }}</div>
                                </div>

                            </div>

                            <div class="pt-3 tab-pane fade profile-edit" id="profile-edit">

                                <!-- Profile Edit Form -->
                                <form method="POST" action="{{ route('admin.profile.update') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3 row">
                                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile
                                            Image</label>
                                        <div class="col-md-8 col-lg-9">
                                            <img id="targetProfile" src="{{ asset('/storage/' . $user->admin->profile) }}"
                                                alt="Profile">
                                            @error('profile')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            <div class="pt-2">
                                                <a href="#profile" class="btn btn-primary btn-sm"
                                                    title="Upload new profile image"><i class="bi bi-upload">
                                                        <input type="file" accept="image/*" id="profile" name="profile"
                                                            onchange="document.querySelector('#targetProfile').src = window.URL.createObjectURL(this.files[0])">
                                                    </i>
                                                </a>
                                                {{-- <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image">
                                                    <i class="bi bi-trash"></i>
                                                </a> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="identity_file" class="col-md-4 col-lg-3 col-form-label">Identity
                                            Image</label>
                                        <div class="col-md-8 col-lg-9">
                                            <img id="targetIdentity" src="{{ asset('/storage/' . $user->admin->identity_file) }}"
                                                alt="identity_file">
                                            @error('identity_file')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            <div class="pt-2">
                                                <a href="#identity_file" class="btn btn-primary btn-sm"
                                                    title="Upload new identity_file image"><i class="bi bi-upload">
                                                        <input type="file" accept="image/*" id="identity_file" name="identity_file"
                                                            onchange="document.querySelector('#targetIdentity').src = window.URL.createObjectURL(this.files[0])">
                                                    </i>
                                                </a>
                                                {{-- <a href="#" class="btn btn-danger btn-sm" title="Remove my identity file image">
                                                    <i class="bi bi-trash"></i>
                                                </a> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="full_name" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="full_name" type="text" class="form-control" id="full_name"
                                                value="{{ $user->admin->full_name }}">
                                            @error('full_name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="contact" class="col-md-4 col-lg-3 col-form-label">Contact</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="contact" type="text" class="form-control" id="contact" pattern="[0-9]{10}" maxlength="10"
                                                value="{{ $user->admin->contact }}">
                                            @error('contact')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="whatsup_no" class="col-md-4 col-lg-3 col-form-label">What's up No.</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="whatsup_no" type="text" class="form-control" id="whatsup_no" pattern="[0-9]{10}" maxlength="10"
                                                value="{{ $user->admin->whatsup_no }}">
                                            @error('whatsup_no')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="identity_number" class="col-md-4 col-lg-3 col-form-label">Identity
                                            No.</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="identity_number" type="text" class="form-control" maxlength="10"
                                                id="identity_number" value="{{ $user->admin->identity_number }}">
                                            @error('identity_number')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- <div class="mb-3 row">
                                    <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="email" type="email" class="form-control" id="Email" value="k.anderson@example.com">
                                    </div>
                                    </div> --}}

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form><!-- End Profile Edit Form -->

                            </div>

                            {{-- <div class="pt-3 tab-pane fade" id="profile-settings">

                  <!-- Settings Form -->
                  <form>

                    <div class="mb-3 row">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>
                      <div class="col-md-8 col-lg-9">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="changesMade" checked>
                          <label class="form-check-label" for="changesMade">
                            Changes made to your account
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="newProducts" checked>
                          <label class="form-check-label" for="newProducts">
                            Information on new products and services
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="proOffers">
                          <label class="form-check-label" for="proOffers">
                            Marketing and promo offers
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="securityNotify" checked disabled>
                          <label class="form-check-label" for="securityNotify">
                            Security alerts
                          </label>
                        </div>
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form><!-- End settings Form -->

                </div> --}}

                            <div class="pt-3 tab-pane fade" id="profile-change-password">
                                <!-- Change Password Form -->
                                <form method="POST" action="{{ route('password.update') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="mb-3 row">
                                        <label for="current_password" class="col-md-4 col-lg-3 col-form-label">Current
                                            Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="current_password" type="password" class="form-control"
                                                id="current_password">
                                            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="text-danger" />
                                            @error('current_password')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="password" type="password" class="form-control"
                                                id="newPassword">
                                            <x-input-error :messages="$errors->updatePassword->get('password')" class="text-danger" />
                                            @error('password')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New
                                            Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="password_confirmation" type="password" class="form-control"
                                                id="renewPassword">
                                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="text-danger" />
                                            @error('password_confirmation')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                    </div>
                                </form><!-- End Change Password Form -->

                            </div>

                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
