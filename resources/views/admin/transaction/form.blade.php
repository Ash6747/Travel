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

    @session('status')
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-octagon me-1"></i>
        {{ session('status') }}
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
                                    <td>{{ $transaction->student->prn }}</td>
                                    <td><b>Full Name</b></td>
                                    <td>{{ $transaction->student->full_name }}</td>
                                    <td><b>Email</b></td>
                                    <td>{{ $transaction->student->user->email }}</td>
                                </tr>

                                <tr>
                                    <td><b>Course</b></td>
                                    <td>{{ $transaction->student->course->coures_full_name }}</td>
                                    <td><b>DOB</b></td>
                                    <td>{{ $transaction->student->dob }}</td>
                                    <td><b>Addmission Year</b></td>
                                    <td>{{ $transaction->student->admission_year }}</td>
                                </tr>

                                <tr>
                                    <td><b>Contact</b></td>
                                    <td>{{ $transaction->student->contact }}</td>
                                    <td><b>WhatsApp No</b></td>
                                    <td>{{ $transaction->student->whatsup_no }}</td>
                                    <td><b>Pincode</b></td>
                                    <td>{{ $transaction->student->pincode }}</td>
                                </tr>

                                <tr>
                                    <td><b>Guardian Name</b></td>
                                    <td>{{ $transaction->student->guardian_name }}</td>
                                    <td><b>Guardian Email</b></td>
                                    <td>{{ $transaction->student->guardian_email }}</td>
                                    <td><b>Guardian Contact</b></td>
                                    <td>{{ $transaction->student->guardian_contact }}</td>
                                </tr>
                                <tr>
                                    <td ><b>Address</b></td>
                                    <td colspan="5">{{ $transaction->student->address }}</td>
                                </tr>

                                <tr>
                                    <td class="text-center text-primary" colspan="6"><h5>Booking</h5></td>
                                </tr>

                                <tr>
                                    <td ><b>Stop</b></td>
                                    <td>{{ $transaction->booking->stop->stop_name }}</td>
                                    <td><b>Route</b></td>
                                    <td>{{ $transaction->booking->bus->route->route_name }}</td>
                                    <td><b>Bus</b></td>
                                    <td>{{ $transaction->booking->bus->bus_no }}</td>
                                </tr>

                                <tr>
                                    <td ><b>Start Date</b></td>
                                    <td>{{ $transaction->booking->start_date }}</td>
                                    <td><b>End Date</b></td>
                                    <td>{{ $transaction->booking->end_date }}</td>
                                    <td><b>Duration</b></td>
                                    <td>{{ $transaction->booking->duration }}</td>
                                </tr>

                                <tr>
                                    <td ><b>Fee</b></td>
                                    <td>{{ $transaction->booking->fee }}</td>
                                    <td><b>Class</b></td>
                                    <td>{{ $transaction->booking->class }} Year</td>
                                    <td><b>Academic Year</b></td>
                                    <td>{{ $transaction->booking->current_academic_year }}</td>
                                </tr>

                                <tr>
                                    <td ><b>Total Paid Amount</b></td>
                                    <td>{{ $transaction->booking->total_amount }}</td>
                                    <td><b>Refund</b></td>
                                    <td>{{ $transaction->booking->refund ?? 0 }}</td>
                                    <td><b>Payment Status</b></td>
                                    <td>{{ $transaction->booking->payment_status }} Paid</td>
                                </tr>

                                <tr>
                                    <td class="text-center text-primary" colspan="6"><h5>Transaction Details</h5></td>
                                </tr>

                                <tr>
                                    <td ><b>Payment Date</b></td>
                                    <td>{{ $transaction->payment_date }}</td>
                                    <td><b>Reciept Token</b></td>
                                    <td>{{ $transaction->reciept_token }}</td>
                                    <td><b>Paid Amount</b></td>
                                    <td>{{ $transaction->paid_amount }}</td>
                                </tr>
                                <tr>
                                    <td ><b>Pay type</b></td>
                                    <td>{{ $transaction->pay_type }}</td>
                                    <td><b>Paid Status</b></td>
                                    <td>{{ $transaction->paid_status }}</td>
                                    <td><b>Reciept File</b></td>
                                    <td>
                                        @isset($transaction->reciept_file)
                                            <a href="{{ asset('/storage/' . $transaction->reciept_file) }}" target="blank">File</a>
                                        @endisset
                                    </td>
                                </tr>

                                @isset($transaction->admin)
                                <tr>
                                    <td class="text-center text-primary" colspan="6"><h5>Verified By</h5></td>
                                </tr>
                                <tr>
                                    <td ><b>Admin Name</b></td>
                                    <td>{{ $transaction->admin->full_name }}</td>
                                    <td><b>Admin What's up No.</b></td>
                                    <td>{{ $transaction->admin->whatsup_no }}</td>
                                    {{-- <td><b>Bus</b></td>
                                    <td>{{ $transaction->booking }}</td> --}}
                                </tr>
                                @endisset

                            </tbody>
                        </table>
                        @if ( $transaction->status == 'pending' )
                            <form method="post" action="{{ route($url, ['id'=>$id])}}" class="mt-3 row g-3">
                                @csrf
                                {{-- <div>
                                    <th >Student Details Confirm </th>
                                    <div>
                                        <input type="radio" value="1" name="alluserDetailsCheck" {{ $transaction->alluserDetailsCheck ? 'checked' : '' }}> Yes
                                        <input type="radio" value="0" name="alluserDetailsCheck" {{ !$transaction->alluserDetailsCheck ? 'checked' : '' }}> No
                                    </div>
                                </div> --}}

                                <fieldset class="m-auto border border-4 row">
                                    <legend class="pt-0 col-form-label col-md-4 fw-bold">Student Details Confirm</legend>
                                    <div class="col-md-4">
                                        Above Details
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <input type="radio" value="1" name="alluserDetailsCheck" {{ $transaction->alluserDetailsCheck ? 'checked' : '' }}>
                                            <label class="form-check-label" for="alluserDetailsCheck_yes">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check disabled">
                                            <input type="radio" value="0" name="alluserDetailsCheck" {{ !$transaction->alluserDetailsCheck ? 'checked' : '' }}>
                                            <label class="form-check-label" for="alluserDetailsCheck_no">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                    @error('alluserDetailsCheck')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </fieldset>

                                {{-- <div>
                                    <th>Payment Date: </th>
                                    <div>{{ $transaction->payment_date }}</div>
                                </div>
                                <div>
                                    <th>Payment Date Confirm </th>
                                    <div>
                                        <input type="radio" value="1" name="payment_date_check" {{ $transaction->payment_date_check ? 'checked' : '' }}> Yes
                                        <input type="radio" value="0" name="payment_date_check" {{ !$transaction->payment_date_check ? 'checked' : '' }}> No
                                    </div>
                                </div> --}}

                                <fieldset class="m-auto border border-4 row">
                                    <legend class="pt-0 col-form-label col-md-4 fw-bold">Payment Date Confirm</legend>
                                    <div class="col-md-4">
                                        {{ $transaction->payment_date }}                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <input type="radio" value="1" name="payment_date_check" {{ $transaction->payment_date_check ? 'checked' : '' }}>
                                            <label class="form-check-label" for="payment_date_check_yes">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check disabled">
                                            <input type="radio" value="0" name="payment_date_check" {{ !$transaction->payment_date_check ? 'checked' : '' }}>
                                            <label class="form-check-label" for="payment_date_check_no">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                    @error('payment_date_check')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </fieldset>

                                {{-- <div>
                                    <th>Receipt No: </th>
                                    <div>{{ $transaction->reciept_token }}</div>
                                </div>
                                <div>
                                    <th>Receipt Number/ID Confirm </th>
                                    <div>
                                        <input type="radio" value="1" name="reciept_token_check" {{ $transaction->reciept_token_check ? 'checked' : '' }}> Yes
                                        <input type="radio" value="0" name="reciept_token_check" {{ !$transaction->reciept_token_check ? 'checked' : '' }}> No
                                    </div>
                                </div> --}}

                                <fieldset class="m-auto border border-4 row">
                                    <legend class="pt-0 col-form-label col-md-4 fw-bold">Receipt Number/ID Confirm</legend>
                                    <div class="col-md-4">
                                        {{ $transaction->reciept_token }}                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <input type="radio" value="1" name="reciept_token_check" {{ $transaction->reciept_token_check ? 'checked' : '' }}>
                                            <label class="form-check-label" for="reciept_token_check_yes">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check disabled">
                                            <input type="radio" value="0" name="reciept_token_check" {{ !$transaction->reciept_token_check ? 'checked' : '' }}>
                                            <label class="form-check-label" for="reciept_token_check_no">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                    @error('reciept_token_check')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </fieldset>

                                {{-- <div>
                                    <th>Paid Amount: </th>
                                    <div>{{ $transaction->paid_amount }}</div>
                                </div>
                                <div>
                                    <th>Paid Amount Confirm </th>
                                    <div>
                                        <input type="radio" value="1" name="paid_amount_check" {{ $transaction->paid_amount_check ? 'checked' : '' }}> Yes
                                        <input type="radio" value="0" name="paid_amount_check" {{ !$transaction->paid_amount_check ? 'checked' : '' }}> No
                                    </div>
                                </div> --}}

                                <fieldset class="m-auto border border-4 row">
                                    <legend class="pt-0 col-form-label col-md-4 fw-bold">Paid Amount Confirm</legend>
                                    <div class="col-md-4">
                                        {{ $transaction->paid_amount }}                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <input type="radio" value="1" name="paid_amount_check" {{ $transaction->paid_amount_check ? 'checked' : '' }}>
                                            <label class="form-check-label" for="paid_amount_check_yes">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check disabled">
                                            <input type="radio" value="0" name="paid_amount_check" {{ !$transaction->paid_amount_check ? 'checked' : '' }}>
                                            <label class="form-check-label" for="paid_amount_check_no">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                    @error('paid_amount_check')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </fieldset>

                                {{-- <div>
                                    <th>Payment Type </th>
                                    <div>{{ $transaction->pay_type }}</div>
                                </div>
                                <div>
                                    <th>Payment Type Confirm </th>
                                    <div>
                                        <input type="radio" value="1" name="pay_type_check" {{ $transaction->pay_type_check ? 'checked' : '' }}> Yes
                                        <input type="radio" value="0" name="pay_type_check" {{ !$transaction->pay_type_check ? 'checked' : '' }}> No
                                    </div>
                                </div> --}}

                                <fieldset class="m-auto border border-4 row">
                                    <legend class="pt-0 col-form-label col-md-4 fw-bold">Payment Type Confirm</legend>
                                    <div class="col-md-4">
                                        {{ $transaction->pay_type }}                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <input type="radio" value="1" name="pay_type_check" {{ $transaction->pay_type_check ? 'checked' : '' }}>
                                            <label class="form-check-label" for="pay_type_check_yes">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check disabled">
                                            <input type="radio" value="0" name="pay_type_check" {{ !$transaction->pay_type_check ? 'checked' : '' }}>
                                            <label class="form-check-label" for="pay_type_check_no">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                    @error('pay_type_check')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </fieldset>

                                {{-- <div>
                                    <th>File (if any)</th>
                                    <div>
                                        <a href="{{ asset('/storage/' . $transaction->reciept_file) }}" target="blank">File</a>
                                    </div>
                                </div>
                                <div>
                                    <th>Reciept File Confirm </th>
                                    <div>
                                        <input type="radio" value="1" name="reciept_file_check" {{ $transaction->reciept_file_check ? 'checked' : '' }}> Yes
                                        <input type="radio" value="0" name="reciept_file_check" {{ !$transaction->reciept_file_check ? 'checked' : '' }}> No

                                    </div>
                                </div> --}}

                                <fieldset class="m-auto border border-4 row">
                                    <legend class="pt-0 col-form-label col-md-4 fw-bold">Reciept File Confirm</legend>
                                    <div class="col-md-4">
                                        <a href="{{ asset('/storage/' . $transaction->reciept_file) }}" target="blank">File</a>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <input type="radio" value="1" id="reciept_file_check" name="reciept_file_check" {{ $transaction->reciept_file_check ? 'checked' : '' }}>
                                            <label class="form-check-label" for="reciept_file_check_yes">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check disabled">
                                            <input type="radio" value="0" id="reciept_file_check" name="reciept_file_check" {{ !$transaction->reciept_file_check ? 'checked' : '' }}>
                                            <label class="form-check-label" for="reciept_file_check_no">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                    @error('reciept_file_check')
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

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form><!-- End Multi Columns Form -->
                        @else
                            @php
                                $color = $transaction->status == 'rejected' ? 'danger' : 'success';
                            @endphp
                            <div class="text-{{ $color }} border border-{{ $color }} border-4 col-md-2 text-center"><b>{{ Str::ucfirst($transaction->status) }}</b></div>

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
