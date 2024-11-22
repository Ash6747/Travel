@extends('admin.layouts.main')

@push('header')
    <title>Trip History</title>
@endpush

@section('admin-main')

    <div class="pagetitle">
      <h1>Trip History</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Trip</li>
          <li class="breadcrumb-item active">History</li>
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
                        <div class="d-flex align-items-center">
                            <h5 class="card-title">{{ $title }}</h5>

                            {{-- <a class="ms-auto" href="{{ route('bookings.pdf', ['id' => $id]) }}" title="Download Pdf">
                                <button class="btn btn-dark rounded-pill">
                                    <i class="ri ri-download-line"></i>
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </button>
                            </a> --}}
                        </div>
                        <table id="zctb" class="table border table-bordered border-primary table-striped border-3"  width="100%" style="font-size: small">

                            <tbody>

                                <tr>
                                    <td class="text-center text-danger" colspan="6" ><h5>Driver Information</h5></td>
                                </tr>

                                <tr>
                                    <td><b>License Number</b></td>
                                    <td>{{ $triphistory->driver->license_number }}</td>
                                    <td><b>Full Name</b></td>
                                    <td>{{ $triphistory->driver->full_name }}</td>
                                    <td><b>Email</b></td>
                                    <td>{{ $triphistory->driver->user->email }}</td>
                                </tr>

                                <tr>
                                    <td><b>Contact</b></td>
                                    <td>{{ $triphistory->driver->contact }}</td>
                                    <td><b>WhatsApp No</b></td>
                                    <td>{{ $triphistory->driver->whatsup_no }}</td>
                                    <td><b>Pincode</b></td>
                                    <td>{{ $triphistory->driver->pincode }}</td>
                                </tr>

                                <tr>
                                    <td ><b>Address</b></td>
                                    <td colspan="5">{{ $triphistory->driver->address }}</td>
                                </tr>

                                <tr>
                                    <td class="text-center text-primary" colspan="6"><h5>Trip Information</h5></td>
                                </tr>

                                <tr>
                                    <td ><b>Bus</b></td>
                                    <td>{{ $triphistory->trip->bus->bus_no }}</td>
                                    <td><b>Route</b></td>
                                    <td>{{ $triphistory->trip->bus->route->route_name }}</td>
                                    <td><b>Expected Distance</b></td>
                                    <td>{{ $triphistory->trip->expected_distance }}</td>
                                </tr>

                                <tr>
                                    <td><b>Morning Time</b></td>
                                    <td colspan="2">
                                        <b>Start :</b> {{ $triphistory->trip->expected_morning_start_time }}
                                        <br>
                                        <b>End :</b> {{ $triphistory->trip->expected_morning_end_time }}
                                    </td>
                                    <td><b>Evening Time</b></td>
                                    <td colspan="2">
                                        <b>Start :</b> {{ $triphistory->trip->expected_evening_start_time }}
                                        <br>
                                        <b>End :</b> {{ $triphistory->trip->expected_evening_end_time }}
                                    </td>
                                    {{-- <td><b>Duration</b></td>
                                    <td>{{ $booking->duration }}</td> --}}
                                </tr>

                                <tr>
                                    <td class="text-center text-primary" colspan="6"><h5>Trip History</h5></td>
                                </tr>

                                <tr>
                                    <td><b>Start Time</b></td>
                                    <td>
                                        {{ $triphistory->created_at }}
                                    </td>
                                    <td><b>End Time</b></td>
                                    <td>
                                        {{ $triphistory->updated_at }}
                                    </td>
                                    <td><b>Phase</b></td>
                                    <td>{{ $triphistory->phase? 'Morning' : 'Evening' }}</td>
                                </tr>

                                <tr>
                                    <td><b>Start Meter Reading</b></td>
                                    <td>
                                        {{ $triphistory->start_meter_reading }}
                                    </td>
                                    <td><b>End Meter Reading</b></td>
                                    <td>
                                        {{ $triphistory->end_meter_reading }}
                                    </td>
                                    <td><b>Traveled Distance</b></td>
                                    <td>{{ $triphistory->distance_traveled }}</td>
                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
