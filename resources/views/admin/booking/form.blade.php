@extends('admin.layouts.main')

@push('header')
    <title>Bookings</title>
@endpush

@section('admin-main')

    <div class="pagetitle">
      <h1>Booking Table</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Bookings</li>
          <li class="breadcrumb-item active">Table</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    @session('error')
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endsession

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $title }}</h5>
                        {{-- <div class="col-md-4">
                            <label for="bus_no" class="form-label">Bus Number</label>
                        </div> --}}
                        <table id="zctb" class="table border table-bordered border-primary table-striped border-3"  width="100%" style="font-size: small">

                            <tbody>

                                <tr>
                                    <td class="text-center text-danger" colspan="6" ><h5>Personal Information</h5></td>
                                </tr>

                                <tr>
                                    <td><b>Reg No.(User PRN)</b></td>
                                    <td>{{ $booking->student->prn }}</td>
                                    <td><b>Full Name</b></td>
                                    <td>{{ $booking->student->full_name }}</td>
                                    <td><b>Email</b></td>
                                    <td>{{ $booking->student->user->email }}</td>
                                </tr>

                                <tr>
                                    <td><b>Course</b></td>
                                    <td>{{ $booking->student->course->coures_full_name }}</td>
                                    <td><b>DOB</b></td>
                                    <td>{{ $booking->student->dob }}</td>
                                    <td><b>Addmission Year</b></td>
                                    <td>{{ $booking->student->admission_year }}</td>
                                </tr>

                                <tr>
                                    <td><b>Contact</b></td>
                                    <td>{{ $booking->student->contact }}</td>
                                    <td><b>WhatsApp No</b></td>
                                    <td>{{ $booking->student->whatsup_no }}</td>
                                    <td><b>Pincode</b></td>
                                    <td>{{ $booking->student->pincode }}</td>
                                </tr>

                                <tr>
                                    <td><b>Guardian Name</b></td>
                                    <td>{{ $booking->student->guardian_name }}</td>
                                    <td><b>Guardian Email</b></td>
                                    <td>{{ $booking->student->guardian_email }}</td>
                                    <td><b>Guardian Contact</b></td>
                                    <td>{{ $booking->student->guardian_contact }}</td>
                                </tr>
                                <tr>
                                    <td ><b>Address</b></td>
                                    <td colspan="5">{{ $booking->student->address }}</td>
                                </tr>

                                <tr>
                                    <td class="text-center text-primary" colspan="6"><h5>Booking</h5></td>
                                </tr>

                                <tr>
                                    <td ><b>Stop</b></td>
                                    <td>{{ $booking->stop->stop_name }}</td>
                                    <td><b>Route</b></td>
                                    <td>{{ $booking->bus->route->route_name }}</td>
                                    <td><b>Bus</b></td>
                                    <td>{{ $booking->bus->bus_no }}</td>
                                </tr>

                                <tr>
                                    <td ><b>Start Date</b></td>
                                    <td>{{ $booking->start_date }}</td>
                                    <td><b>End Date</b></td>
                                    <td>{{ $booking->end_date }}</td>
                                    <td><b>Duration</b></td>
                                    <td>{{ $booking->duration }}</td>
                                </tr>

                                <tr>
                                    <td ><b>Fee</b></td>
                                    <td>{{ $booking->fee }}</td>
                                    <td><b>Class</b></td>
                                    <td>{{ $booking->class }} Year</td>
                                    <td><b>Academic Year</b></td>
                                    <td>{{ $booking->current_academic_year }}</td>
                                </tr>

                                <tr>
                                    <td ><b>Total Paid Amount</b></td>
                                    <td>{{ $booking->total_amount }}</td>
                                    <td><b>Refund</b></td>
                                    <td>{{ $booking->refund ?? 0 }}</td>
                                    <td><b>Payment Status</b></td>
                                    <td>{{ $booking->payment_status }} Paid</td>
                                </tr>

                                @isset($booking->student->reports[0])
                                    <tr>
                                        <td class="text-center text-primary" colspan="6"><h5>Booking History</h5></td>
                                    </tr>
                                    @foreach ($booking->student->reports as $report)
                                        <tr>
                                            <td ><b>Stop</b></td>
                                            <td>{{ $report->stop->stop_name }}</td>
                                            <td><b>Route</b></td>
                                            <td>{{ $report->bus->route->route_name }}</td>
                                            <td><b>Bus</b></td>
                                            <td>{{ $report->bus->bus_no }}</td>
                                        </tr>

                                        <tr>
                                            <td ><b>Start Date</b></td>
                                            <td>{{ $report->start_date }}</td>
                                            <td><b>End Date</b></td>
                                            <td>{{ $report->end_date }}</td>
                                            <td><b>Duration</b></td>
                                            <td>{{ $report->duration }}</td>
                                        </tr>

                                        <tr>
                                            <td ><b>Fee</b></td>
                                            <td>{{ $report->fee }}</td>
                                            <td><b>Class</b></td>
                                            <td>{{ $report->class }} Year</td>
                                            <td><b>Academic Year</b></td>
                                            <td>{{ $report->current_academic_year }}</td>
                                        </tr>

                                        <tr>
                                            <td ><b>Total Paid Amount</b></td>
                                            <td>{{ $report->total_amount }}</td>
                                            <td><b>Refund</b></td>
                                            <td>{{ $report->refund ?? 0 }}</td>
                                            <td><b>Payment Status</b></td>
                                            <td>{{ $report->payment_status }} Paid</td>
                                        </tr>
                                    @endforeach

                                @endisset

                            </tbody>
                        </table>

                        @if ( $booking->status == 'pending' )
                            <form method="post" action="{{ isset($booking) ? route($url, ['id'=>$id]) : route($url) }}" class="row g-3">
                                @csrf
                                {{-- <div class="col-md-4">
                                    <input type="radio" id="approved" name="status" value="approved" required>
                                    <label for="approved">Approved</label><br>

                                    <input type="radio" id="reject" name="status" value="reject">
                                    <label for="reject">Rejected</label><br>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div> --}}

                                <fieldset class="row mt-3 mb-3 d-flex justify-content-center">
                                    <legend class="col-form-label col-md-1 pt-0">Status</legend>
                                    <div class="col-sm-2">

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="approved" value="approved">
                                        <label class="form-check-label" for="approved">
                                            Approved
                                        </label>
                                    </div>
                                    <div class="form-check disabled">
                                        <input class="form-check-input" type="radio" name="status" id="reject" value="reject">
                                        <label class="form-check-label" for="rejected">
                                            Rejected
                                        </label>
                                    </div>
                                    </div>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </fieldset>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                </div>
                            </form><!-- End Multi Columns Form -->
                        @else
                            @php
                                $color = $booking->status == 'rejected' ? 'danger' : 'success';
                            @endphp
                            <div class="text-{{ $color }} border border-{{ $color }} border-4 col-md-2 text-center"><b>{{ Str::ucfirst($booking->status) }}</b></div>

                        @endif


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
