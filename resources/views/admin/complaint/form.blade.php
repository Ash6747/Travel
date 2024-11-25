@extends('admin.layouts.main')

@push('header')
    <title>Complaint</title>
@endpush

@section('admin-main')

    <div class="pagetitle">
      <h1>Complaint Details</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Complaint</li>
          <li class="breadcrumb-item active">Details</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    @session('error')
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-octagon me-1"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endsession
    @session('status')
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i>
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endsession

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
                        <div class="d-flex align-items-center">
                            <h5 class="card-title">{{ $title }}</h5>

                            {{-- <a class="ms-auto" href="{{ route('complaint.pdf', ['id' => $id]) }}" title="Download Pdf">
                                <button class="btn btn-dark rounded-pill">
                                    <i class="ri ri-download-line"></i>
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </button>
                            </a> --}}
                        </div>
                        <table id="zctb" class="table border table-bordered border-primary table-striped border-3"  width="100%" style="font-size: small">

                            <tbody>

                                <tr>
                                    <td class="text-center text-danger" colspan="6" ><h5>Personal Information</h5></td>
                                </tr>

                                <tr>
                                    <td><b>Reg No.(User PRN)</b></td>
                                    <td>{{ $complaint->student->prn }}</td>
                                    <td><b>Full Name</b></td>
                                    <td>{{ $complaint->student->full_name }}</td>
                                    <td><b>Email</b></td>
                                    <td>{{ $complaint->student->user->email }}</td>
                                </tr>

                                <tr>
                                    <td><b>Course</b></td>
                                    <td>{{ $complaint->student->course->coures_full_name }}</td>
                                    <td><b>DOB</b></td>
                                    <td>{{ $complaint->student->dob }}</td>
                                    <td><b>Addmission Year</b></td>
                                    <td>{{ $complaint->student->admission_year }}</td>
                                </tr>

                                <tr>
                                    <td><b>Contact</b></td>
                                    <td>{{ $complaint->student->contact }}</td>
                                    <td><b>WhatsApp No</b></td>
                                    <td>{{ $complaint->student->whatsup_no }}</td>
                                    <td><b>Pincode</b></td>
                                    <td>{{ $complaint->student->pincode }}</td>
                                </tr>

                                <tr>
                                    <td><b>Guardian Name</b></td>
                                    <td>{{ $complaint->student->guardian_name }}</td>
                                    <td><b>Guardian Email</b></td>
                                    <td>{{ $complaint->student->guardian_email }}</td>
                                    <td><b>Guardian Contact</b></td>
                                    <td>{{ $complaint->student->guardian_contact }}</td>
                                </tr>
                                <tr>
                                    <td ><b>Address</b></td>
                                    <td colspan="5">{{ $complaint->student->address }}</td>
                                </tr>

                                <tr>
                                    <td class="text-center text-primary" colspan="6"><h5>Current Booking</h5></td>
                                </tr>

                                <tr>
                                    <td ><b>Stop</b></td>
                                    <td>{{ $complaint->student->bookings->stop->stop_name }}</td>
                                    <td><b>Route</b></td>
                                    <td>{{ $complaint->student->bookings->bus->route->route_name }}</td>
                                    <td><b>Bus</b></td>
                                    <td>{{ $complaint->bus->bus_no }}</td>
                                </tr>

                                <tr>
                                    <td ><b>Start Date</b></td>
                                    <td>{{ $complaint->student->bookings->start_date }}</td>
                                    <td><b>End Date</b></td>
                                    <td>{{ $complaint->student->bookings->end_date }}</td>
                                    <td><b>Duration</b></td>
                                    <td>{{ $complaint->student->bookings->duration }}</td>
                                </tr>

                                <tr>
                                    <td ><b>Fee</b></td>
                                    <td>{{ $complaint->student->bookings->fee }}</td>
                                    <td><b>Class</b></td>
                                    <td>{{ $complaint->student->bookings->class }} Year</td>
                                    <td><b>Academic Year</b></td>
                                    <td>{{ $complaint->student->bookings->current_academic_year }}</td>
                                </tr>

                                <tr>
                                    <td ><b>Total Paid Amount</b></td>
                                    <td>{{ $complaint->student->bookings->total_amount }}</td>
                                    <td><b>Refund</b></td>
                                    <td>{{ $complaint->student->bookings->refund ?? 0 }}</td>
                                    <td><b>Payment Status</b></td>
                                    <td>{{ $complaint->student->bookings->payment_status }} Paid</td>
                                </tr>

                                <tr>
                                    <td class="text-center text-primary" colspan="6"><h5>Complaint Details</h5></td>
                                </tr>

                                <tr>
                                    <td ><b>Driver Name</b></td>
                                    <td>{{ $complaint->driver->full_name }}</td>
                                    <td><b>Route</b></td>
                                    <td>{{ $complaint->bus->route->route_name }}</td>
                                    <td><b>Bus</b></td>
                                    <td>{{ $complaint->bus->bus_no }}</td>
                                </tr>

                                <tr>
                                    <td ><b>Driver Licence Number</b></td>
                                    <td>{{ $complaint->driver->license_number }}</td>
                                    <td ><b>Driver Licence expiration</b></td>
                                    <td>{{ $complaint->driver->license_exp }}</td>
                                    <td ><b>Driver Contact</b></td>
                                    <td>{{ $complaint->driver->contact }}</td>
                                </tr>

                                <tr>
                                    <td ><b>Driver Address</b></td>
                                    <td colspan="2">{{ $complaint->driver->address }}</td>
                                    <td ><b>Driver Pincode</b></td>
                                    <td>{{ $complaint->driver->pincode }}</td>
                                    <td>{{ $complaint->driver->status }}</td>
                                </tr>

                                <tr>
                                    <td><b>Complaint</b></td>
                                    <td colspan="3">{{ $complaint->details }}</td>
                                    <td><b>Driver Address</b></td>
                                    <td>
                                        @isset($complaint->complaint_file)
                                            <a href="{{ asset('/storage/' . $complaint->complaint_file) }}" target="blank">File</a>
                                        @endisset
                                    </td>
                                </tr>

                                @isset($complaint->admin)
                                <tr>
                                    <td class="text-center text-primary" colspan="6"><h5>Verified By</h5></td>
                                </tr>
                                <tr>
                                    <td ><b>Admin Name</b></td>
                                    <td colspan="2">{{ $complaint->admin->full_name }}</td>
                                    <td><b>Admin What's up No.</b></td>
                                    <td colspan="2">{{ $complaint->admin->whatsup_no }}</td>
                                </tr>
                                @isset($complaint->resolution)
                                <tr>
                                    <td><b>Comment</b></td>
                                    <td colspan="5">{{ $complaint->resolution }}</td>
                                </tr>
                                @endisset

                                @endisset

                            </tbody>
                        </table>

                        @if ( $complaint->status == 'pending' )
                            <a class="badge rounded-pill bg-warning text-dark" href="{{ route('complaint.status', ['id' => $complaint->id])}}">
                                <i class="bi bi-exclamation-triangle me-1"></i> Start Working On Complaint
                            </a>
                        @elseif ($complaint->status == 'progress')
                        <form method="post" action="{{ isset($complaint) ? route($url, ['id'=>$id]) : route($url) }}" class="row g-3">
                            @csrf

                            <div class="mb-3 form-floating">
                                <textarea class="form-control" placeholder="Leave a resolution here" name="resolution" id="resolution" style="height: 100px;"></textarea>
                                <label for="resolution">Resolutions</label>
                                @error('resolution')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form><!-- End Multi Columns Form -->

                        @else
                            @php
                                $color = $complaint->status == 'rejected' ? 'danger' : 'success';
                            @endphp
                            <div class="text-{{ $color }} border border-{{ $color }} border-4 col-md-2 text-center"><b>{{ Str::ucfirst($complaint->status) }}</b></div>

                        @endif


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
