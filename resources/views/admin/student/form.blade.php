@extends('admin.layouts.main')

@push('header')
    <title>Student Profile</title>
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
        <h1>Student Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">{{ $student->user->role }}</li>
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
    @session('error')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-octagon me-1"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endsession

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="section profile">
        <div class="row">
            <div class="col-xl-3 position-relative">
                <div class="z-0 card position-sticky" style="top: 80px">
                    <div class="pt-4 card-body profile-card d-flex flex-column align-items-center">

                        <img src="{{ asset('/storage/' . $student->profile) }}" alt="Profile" class="rounded-circle">
                        <h2>{{ $student->full_name }}</h2>
                        <h3>{{ $student->prn }}</h3>
                        {{-- <h3></h3> --}}
                        {{-- <div class="mt-2 social-links">
                            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                        </div> --}}
                    </div>
                </div>

            </div>

            <div class="col-xl-9">

                <div class="card">
                    <div class="pt-3 card-body">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab"
                                    data-bs-target="#profile-overview">Overview</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link"
                                    data-bs-toggle="tab" data-bs-target="#booking">Booking</button>
                            </li>

                            {{-- <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Settings</button>
                            </li> --}}

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#profile-change-password">Booking History</button>
                            </li>

                            {{-- @isset($student->bookings->cancel) --}}
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-Bookig-cancellation">Cancellation</button>
                            </li>
                            {{-- @endisset --}}
                        </ul>
                        <div class="pt-2 tab-content">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                {{-- <h5 class="card-title">About</h5>
                                <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p> --}}

                                <h5 class="card-title">Student Details</h5>

                                <div class="mb-3 row">
                                    <div class="col-lg-3 col-md-4 label ">Profile</div>
                                    <div class="col-md-8 col-lg-9">
                                        <img class="rounded img-fluid" id="targetIdentity_file" src="{{ asset('/storage/' . $student->profile) }}"
                                            alt="identity_file" >
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">PRN</div>
                                    <div class="col-lg-9 col-md-8">{{ $student->prn }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                    <div class="col-lg-9 col-md-8">{{ $student->full_name }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Date Of Birth</div>
                                    <div class="col-lg-9 col-md-8">{{ $student->dob }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">{{ $student->user->email }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Phone</div>
                                    <div class="col-lg-9 col-md-8">{{ $student->contact }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">What's up No.</div>
                                    <div class="col-lg-9 col-md-8">{{ $student->whatsup_no }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Course</div>
                                    <div class="col-lg-9 col-md-8">{{ $student->course->coures_full_name }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Admission Year</div>
                                    <div class="col-lg-9 col-md-8">{{ $student->admission_year }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Guardian Name</div>
                                    <div class="col-lg-9 col-md-8">{{ $student->guardian_name }}</div>
                                </div>

                                @isset($student->guardian_email)
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Guardian Email</div>
                                    <div class="col-lg-9 col-md-8">{{ $student->guardian_email }}</div>
                                </div>
                                @endisset

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Guardian Contact</div>
                                    <div class="col-lg-9 col-md-8">{{ $student->guardian_contact }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Address</div>
                                    <div class="col-lg-9 col-md-8">{{ $student->address }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Pincode</div>
                                    <div class="col-lg-9 col-md-8">{{ $student->pincode }}</div>
                                </div>

                            </div>

                            <div class="tab-pane fade booking" id="booking">

                                <h5 class="card-title">Booking Details</h5>
                                <table class="table table-bordered border-primary">
                                    <tr>
                                        <th scope="col">Stop</th>
                                        <td scope="col">{{ $student->bookings->stop->stop_name }}</td>
                                        <th scope="col">Bus</th>
                                        <td scope="col">{{ $student->bookings->bus->bus_no }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Route</th>
                                        <td scope="col">{{ $student->bookings->bus->route->route_name }}</td>
                                        <th scope="col">Class</th>
                                        <td scope="col">{{ $student->bookings->class }} Year</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Start Date</th>
                                        <td scope="col">{{ $student->bookings->start_date }}</td>
                                        <th scope="col">End Date</th>
                                        <td scope="col">{{ $student->bookings->end_date }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Duration</th>
                                        <td scope="col">{{ $student->bookings->duration }}</td>
                                        <th scope="col">Academic Year</th>
                                        <td scope="col">{{ $student->bookings->current_academic_year }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Fee</th>
                                        <td scope="col">{{ $student->bookings->fee }}</td>
                                        <th scope="col">Total Paid</th>
                                        <td scope="col">{{ $student->bookings->total_amount }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Refund</th>
                                        <td scope="col">{{ $student->bookings->refund ?? 0 }}</td>
                                        <th scope="col">Payment Status</th>
                                        <td scope="col">{{ $student->bookings->payment_status }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Booking Status</th>
                                        <td colspan="3" scope="col">{{ Str::ucfirst($student->bookings->status)}}</td>
                                        {{-- <th scope="col">Payment Status</th>
                                        <td scope="col">{{ $student->bookings->payment_status }}</td> --}}
                                    </tr>

                                    @isset($student->bookings->verified_by)
                                    <tr>
                                        <th scope="col">Verified By</th>
                                        <td colspan="3" scope="col">{{ $student->bookings->admin->full_name ?? "Admin" }}</td>
                                    </tr>

                                    <tr>
                                        <th scope="col">Comment</th>
                                        <td colspan="3" scope="col">{{ $student->bookings->comment ?? "Admin" }}</td>
                                    </tr>
                                    @endisset
                                </table>
                                @if ($student->bookings->status == 'pending')
                                    <div class="text-center border border-4 text-success border-success col-md-2"><b>Not Approved</b></div>
                                @elseif ($student->bookings->remaining_amount_check == 1)
                                    <div class="text-center border border-4 text-success border-success col-md-2"><b>No Remaining Amount</b></div>
                                @else
                                <!-- Profile Edit Form -->
                                <form method="POST" action="{{ route('student.update', ['id'=> $student->id]) }}">
                                    @csrf

                                    <fieldset class="m-auto border border-4 row">
                                        <legend class="pt-0 col-form-label col-md-4 fw-bold">Remaining Amount Confirm</legend>

                                        <div class="col-sm-8">
                                            <div class="form-check">
                                                <input type="radio" value="1" id="remaining_amount_check" name="remaining_amount_check" checked="{{ $student->bookings->remaining_amount_check ? 'true' : 'false' }}">
                                                <label class="form-check-label" for="remaining_amount_check_yes">
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="form-check disabled">
                                                <input type="radio" value="0" id="remaining_amount_check" name="remaining_amount_check" checked="{{ !$student->bookings->remaining_amount_check ? 'true' : 'false' }}">
                                                <label class="form-check-label" for="remaining_amount_check_no">
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                        @error('remaining_amount_check')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </fieldset>
                                    <b class="text-danger">Submiting 'Yes' will no longer accept payment from student</b>

                                    <fieldset class="m-auto my-2 row">
                                        <legend class="pt-0 col-form-label col-md-4 fw-bold">Refund Amount : </legend>
                                        <div class="col-sm-8">
                                            <input type="number" id="refund" name="refund" min="0" value="{{ old('refund') ?? 0.00 }}" class="form-control">
                                        </div>
                                        {{-- <div class="col-sm-8">
                                            <input type="number" id="refund" name="refund" min="0">
                                        </div> --}}
                                        @error('refund')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </fieldset>

                                    <div class="mb-3 form-floating">
                                        <textarea class="form-control" placeholder="Leave a comment here" name="comment" id="comment" style="height: 100px;"></textarea>
                                        <label for="comment">Comments</label>
                                        @error('comment')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mt-2 text-center">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                                @endif

                                @isset($student->bookings->transactions[0])

                                <h5 class="card-title">Transaction Details</h5>

                                <table class="table table-bordered border-primary">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Position</th>
                                            <th scope="col">Age</th>
                                            <th scope="col">Start Date</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $cnt = 1;
                                        @endphp
                                        @foreach ($student->bookings->transactions as $transaction )

                                        <tr>
                                            <th scope="row">{{ $cnt }}</th>
                                            <td>{{ $transaction->payment_date }}</td>
                                            <td>{{ $transaction->paid_amount }}</td>
                                            <td>{{ $transaction->pay_type }}</td>
                                            <td>{{ $transaction->payment_date }}</td>
                                            <td>{{ $transaction->status }}</td>
                                        </tr>

                                        @php
                                            $cnt++;
                                        @endphp

                                        @endforeach
                                    </tbody>
                                </table>

                                @endisset

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

                            <div class="tab-pane fade" id="profile-change-password">
                                <h5 class="card-title">{{ isset($student->reports[0]) ? 'Booking History' : 'No Booking History' }}</h5>
                                @isset($student->reports[0])
                                    @foreach ( $student->reports as $report)
                                        <table class="table table-bordered border-primary">

                                            <tr>
                                                <th scope="col">Stop</th>
                                                <td scope="col">{{ $report->stop->stop_name }}</td>
                                                <th scope="col">Bus</th>
                                                <td scope="col">{{ $report->bus->bus_no }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="col">Route</th>
                                                <td scope="col">{{ $report->bus->route->route_name }}</td>
                                                <th scope="col">Class</th>
                                                <td scope="col">{{ $report->class }} Year</td>
                                            </tr>
                                            <tr>
                                                <th scope="col">Start Date</th>
                                                <td scope="col">{{ $report->start_date }}</td>
                                                <th scope="col">End Date</th>
                                                <td scope="col">{{ $report->end_date }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="col">Duration</th>
                                                <td scope="col">{{ $report->duration }}</td>
                                                <th scope="col">Academic Year</th>
                                                <td scope="col">{{ $report->current_academic_year }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="col">Fee</th>
                                                <td scope="col">{{ $report->fee }}</td>
                                                <th scope="col">Total Paid</th>
                                                <td scope="col">{{ $report->total_amount }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="col">Refund</th>
                                                <td scope="col">{{ $report->refund ?? 0 }}</td>
                                                <th scope="col">Payment Status</th>
                                                <td scope="col">{{ $report->payment_status }}</td>
                                            </tr>

                                        </table>

                                        @isset($report->transactions[0])

                                            <h5 class="card-title">Transaction Details</h5>

                                            <table class="table table-bordered border-primary">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Position</th>
                                                        <th scope="col">Age</th>
                                                        <th scope="col">Start Date</th>
                                                        <th scope="col">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $cnt = 1;
                                                    @endphp
                                                    @foreach ($report->transactions as $transactionR )

                                                    <tr>
                                                        <th scope="row">{{ $cnt }}</th>
                                                        <td>{{ $transactionR->payment_date }}</td>
                                                        <td>{{ $transactionR->paid_amount }}</td>
                                                        <td>{{ $transactionR->pay_type }}</td>
                                                        <td>{{ $transactionR->payment_date }}</td>
                                                        <td>{{ $transactionR->status }}</td>
                                                    </tr>

                                                    @php
                                                        $cnt++;
                                                    @endphp

                                                    @endforeach
                                                </tbody>
                                            </table>

                                        @endisset
                                    @endforeach
                                @endisset
                            </div>

                            <div class="tab-pane fade" id="profile-Bookig-cancellation">
                                <h5 class="card-title">Cancellation Details</h5>
                                @isset($student->bookings->cancel)
                                    <table class="table table-bordered border-primary">
                                        <tr>
                                            <th scope="col">Stop</th>
                                            <td scope="col">{{ $student->bookings->stop->stop_name }}</td>
                                            <th scope="col">Bus</th>
                                            <td scope="col">{{ $student->bookings->bus->bus_no }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="col">Route</th>
                                            <td scope="col">{{ $student->bookings->bus->route->route_name }}</td>
                                            <th scope="col">Class</th>
                                            <td scope="col">{{ $student->bookings->class }} Year</td>
                                        </tr>
                                        <tr>
                                            <th scope="col">Start Date</th>
                                            <td scope="col">{{ $student->bookings->start_date }}</td>
                                            <th scope="col">End Date</th>
                                            <td scope="col">{{ $student->bookings->end_date }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="col">Duration</th>
                                            <td scope="col">{{ $student->bookings->duration }}</td>
                                            <th scope="col">Academic Year</th>
                                            <td scope="col">{{ $student->bookings->current_academic_year }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="col">Fee</th>
                                            <td scope="col">{{ $student->bookings->fee }}</td>
                                            <th scope="col">Total Paid</th>
                                            <td scope="col">{{ $student->bookings->total_amount }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="col">Refund</th>
                                            <td scope="col">{{ $student->bookings->refund ?? 0 }}</td>
                                            <th scope="col">Payment Status</th>
                                            <td scope="col">{{ $student->bookings->payment_status }}</td>
                                        </tr>

                                        @isset($student->bookings->verified_by)
                                        <tr>
                                            <th scope="col">Verified By</th>
                                            <td colspan="3" scope="col">{{ $student->bookings->admin->full_name ?? "Admin" }}</td>
                                        </tr>

                                        <tr>
                                            <th scope="col">Comment</th>
                                            <td colspan="3" scope="col">{{ $student->bookings->comment ?? "Admin" }}</td>
                                        </tr>
                                        @endisset

                                        @isset($student->bookings->cancel->file)

                                        <tr>
                                            <th scope="col">Cancellation File</th>
                                            <td colspan="3">
                                                <a href="{{ asset('/storage/' . $student->bookings->cancel->file) }}" target="blank">File</a>
                                            </td>
                                        </tr>

                                        @endisset

                                        <tr>
                                            <th scope="col">Cancellation Reason</th>
                                            <td colspan="3">{{ $student->bookings->cancel->reason }}</td>
                                        </tr>
                                    </table>
                                    @if ($student->bookings->remaining_amount_check == 0 && $student->bookings->cancel->status == 'pending')
                                    {{-- <b class="text-danger"></b> --}}
                                    <div class="alert alert-warning" role="alert">
                                        <strong>Action Required:</strong> To proceed, the value of <code>Remaining Amount</code> must be set to <strong>Yes</strong>. Please update it and try again.
                                    </div>
                                    @elseif ($student->bookings->remaining_amount_check == 1 && $student->bookings->cancel->status == 'pending')
                                        <!-- Settings Form -->
                                        <form method="POST" action="{{ route('cancellation.update', ['id'=> $student->id]) }}">
                                            @csrf

                                            <fieldset class="m-auto mb-3 border border-4 row">
                                                <legend class="m-auto col-form-label col-md-4 fw-bold">Refund Amount : </legend>
                                                <div class="p-2 col-sm-8">
                                                    <input type="number" id="refund" name="refund" min="0" value="{{ old('refund') ?? 0.00 }}" class="form-control">
                                                </div>
                                                @error('refund')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </fieldset>

                                            <div class="mb-3 border border-4 form-floating">
                                                <textarea class="form-control" placeholder="Leave a resolution here" name="resolution" id="resolution" style="height: 100px;"></textarea>
                                                <label for="resolution">Resolutions</label>
                                                @error('resolution')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <fieldset class="m-auto mb-3 border border-4 row ">
                                                <legend class="m-auto col-form-label col-md-4 fw-bold">Status :</legend>
                                                <div class="p-2 col-sm-8">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="status" id="approved" value="approved">
                                                        <label class="form-check-label" for="approved">
                                                            Approved
                                                        </label>
                                                    </div>
                                                    <div class="form-check disabled">
                                                        <input class="form-check-input" type="radio" name="status" id="rejected" value="rejected">
                                                        <label class="form-check-label" for="rejected">
                                                            Rejected
                                                        </label>
                                                    </div>
                                                </div>
                                                @error('status')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </fieldset>

                                            <div class="mt-2 text-center">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    @elseif ($student->bookings->cancel->status == 'approved' || $student->bookings->cancel->status == 'rejected')
                                        @php
                                            $color = $student->bookings->cancel->status == 'rejected' ? 'danger' : 'success';
                                        @endphp
                                        <div class="text-{{ $color }} border border-{{ $color }} border-4 col-md-2 text-center"><b>{{ Str::ucfirst($student->bookings->cancel->status) }}</b></div>


                                    @endif

                                @else

                                    @if ($student->bookings->remaining_amount_check == 1)
                                        <form method="POST" action="{{ route('cancellation.store', ['id'=> $student->id]) }}" enctype="multipart/form-data">
                                            @csrf

                                            <fieldset class="m-auto mb-3 border border-4 row">
                                                <legend class="m-auto col-form-label col-md-4 fw-bold">Refund Amount (OPTIONAL): </legend>
                                                <div class="p-2 col-sm-8">
                                                    <input type="number" id="refund" name="refund" min="0" value="{{ old('refund') ?? 0.00 }}" class="form-control">
                                                </div>
                                                @error('refund')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </fieldset>

                                            <div class="mb-3 border border-4 form-floating">
                                                <textarea class="form-control" placeholder="Leave a reason here" name="reason" id="reason" style="height: 100px;"></textarea>
                                                <label for="reason">Reasons</label>
                                                @error('reason')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <fieldset class="m-auto mb-3 border border-4 row">
                                                <legend class="m-auto col-form-label col-md-4 fw-bold">Reason File (OPTIONAL): </legend>
                                                <div class="p-2 col-sm-8">
                                                    <input type="file" accept="image/*" id="file" name="file" class="form-control">
                                                </div>
                                                @error('file')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </fieldset>

                                            <div class="mb-3 border border-4 form-floating">
                                                <textarea class="form-control" placeholder="Leave a resolution here" name="resolution" id="resolution" style="height: 100px;"></textarea>
                                                <label for="resolution">Resolutions</label>
                                                @error('resolution')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            {{-- <fieldset class="m-auto mb-3 border border-4 row ">
                                                <legend class="m-auto col-form-label col-md-4 fw-bold">Status :</legend>
                                                <div class="p-2 col-sm-8">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="status" id="approved" value="approved">
                                                        <label class="form-check-label" for="approved">
                                                            Approved
                                                        </label>
                                                    </div>
                                                    <div class="form-check disabled">
                                                        <input class="form-check-input" type="radio" name="status" id="rejected" value="rejected">
                                                        <label class="form-check-label" for="rejected">
                                                            Rejected
                                                        </label>
                                                    </div>
                                                </div>
                                                @error('status')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </fieldset> --}}

                                            <div class="mt-2 text-center">
                                                <button type="submit" class="btn btn-primary">Leave</button>
                                            </div>
                                        </form>
                                    @else
                                        <div class="alert alert-warning" role="alert">
                                            <strong>Action Required:</strong> To proceed, the value of <code>Remaining Amount</code> must be set to <strong>Yes</strong>. Please update it and try again.
                                        </div>
                                    @endif

                                @endisset
                            </div>

                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
