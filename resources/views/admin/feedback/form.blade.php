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
                                    <td class="text-center text-danger" colspan="6"><h5>Feedback For</h5></td>
                                </tr>

                                <tr>
                                    <td ><b>Driver Name</b></td>
                                    <td>{{ $feedback->driver->full_name }}</td>
                                    <td><b>Route</b></td>
                                    <td>{{ $feedback->bus->route->route_name }}</td>
                                    <td><b>Bus</b></td>
                                    <td>{{ $feedback->bus->bus_no }}</td>
                                </tr>

                                <tr>
                                    <td ><b>Driver Contact</b></td>
                                    <td>{{ $feedback->driver->contact }}</td>
                                    <td><b>License</b></td>
                                    <td>{{ $feedback->driver->license_number }}</td>
                                    <td><b>Driver Status</b></td>
                                    <td>{{ $feedback->driver->status }}</td>
                                </tr>

                                <tr>
                                    <td class="text-center text-primary" colspan="6"><h5>Feedback Details</h5></td>
                                </tr>

                                <!-- Feedback Questions -->
                                @php
                                    $questions = [
                                        'How easy is it to book a bus for your desired duration (1, 6, or 12 months)?' => ['Very easy', 'Somewhat easy', 'Neutral', 'Somewhat difficult', 'Very difficult'],
                                        'How clear are the instructions when booking a bus?' => ['Very clear', 'Mostly clear', 'Neutral', 'Somewhat unclear', 'Very unclear'],
                                        'How satisfied are you with the admin approval process for your bus booking?' => ['Very satisfied', 'Satisfied', 'Neutral', 'Dissatisfied', 'Very dissatisfied'],
                                        'How would you rate the GPS tracking feature for monitoring the bus\'s location?' => ['Excellent', 'Good', 'Average', 'Below average', 'Poor'],
                                        'How accurate are the real-time notifications about bus arrival and delays?' => ['Very accurate', 'Mostly accurate', 'Neutral', 'Somewhat inaccurate', 'Very inaccurate'],
                                        'How convenient is the attendance marking process for the bus rides?' => ['Very convenient', 'Convenient', 'Neutral', 'Inconvenient', 'Very inconvenient'],
                                        'How would you rate the overall user experience of the bus management system?' => ['Excellent', 'Good', 'Average', 'Below average', 'Poor'],
                                        'How likely are you to recommend this bus system to other students?' => ['Very likely', 'Likely', 'Neutral', 'Unlikely', 'Very unlikely'],
                                        'How often do you experience delays or issues with the bus arriving on time?' => ['Never', 'Rarely', 'Sometimes', 'Often', 'Always'],
                                        'How easy is it to view and track your past trips?' => ['Very easy', 'Easy', 'Neutral', 'Difficult', 'Very difficult'],
                                        'How satisfied are you with the duration options (1, 6, 12 months) available for bus bookings?' => ['Very satisfied', 'Satisfied', 'Neutral', 'Dissatisfied', 'Very dissatisfied'],
                                        'How clear are the bus route and schedule details provided?' => ['Very clear', 'Mostly clear', 'Neutral', 'Somewhat unclear', 'Very unclear'],
                                        'How responsive is the system if you need help with booking or any issues?' => ['Very responsive', 'Responsive', 'Neutral', 'Slow response', 'No response'],
                                        'How would you rate the speed of the system (e.g., booking, checking trip history)?' => ['Very fast', 'Fast', 'Average', 'Slow', 'Very slow'],
                                        'How would you rate your overall satisfaction with the bus management system?' => ['Very satisfied', 'Satisfied', 'Neutral', 'Dissatisfied', 'Very dissatisfied'],
                                    ];
                                @endphp

                                @foreach ($questions as $index => $options)
                                <tr>
                                    <td colspan="6"><b>{{ $loop->iteration }}. {{ $index }}</b></td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <ol>
                                            @foreach ($options as $option)
                                            <li>{{ $option }}</li>
                                            @endforeach
                                        </ol>
                                    </td>
                                    <td colspan="3"><b>-> {{ Str::upper($feedback->{'question_' . $loop->iteration}) }}</b></td>
                                </tr>
                                {{-- <tr>
                                    <td colspan="6"><b>-> {{ Str::upper($feedback->{'question_' . $loop->iteration}) }}</b></td>
                                </tr> --}}
                                @endforeach

                            </tbody>
                        </table>
{{--
                        Here are 10-15 feedback questions tailored for students using your Bus Management System, each with 5 possible answer options for each question:

                        ### 1. **How easy is it to book a bus for your desired duration (1, 6, or 12 months)?**
                        - Very easy
                        - Somewhat easy
                        - Neutral
                        - Somewhat difficult
                        - Very difficult

                        ### 2. **How clear are the instructions when booking a bus?**
                        - Very clear
                        - Mostly clear
                        - Neutral
                        - Somewhat unclear
                        - Very unclear

                        ### 3. **How satisfied are you with the admin approval process for your bus booking?**
                        - Very satisfied
                        - Satisfied
                        - Neutral
                        - Dissatisfied
                        - Very dissatisfied

                        ### 4. **How would you rate the GPS tracking feature for monitoring the bus's location?**
                        - Excellent
                        - Good
                        - Average
                        - Below average
                        - Poor

                        ### 5. **How accurate are the real-time notifications about bus arrival and delays?**
                        - Very accurate
                        - Mostly accurate
                        - Neutral
                        - Somewhat inaccurate
                        - Very inaccurate

                        ### 6. **How convenient is the attendance marking process for the bus rides?**
                        - Very convenient
                        - Convenient
                        - Neutral
                        - Inconvenient
                        - Very inconvenient

                        ### 7. **How would you rate the overall user experience of the bus management system?**
                        - Excellent
                        - Good
                        - Average
                        - Below average
                        - Poor

                        ### 8. **How likely are you to recommend this bus system to other students?**
                        - Very likely
                        - Likely
                        - Neutral
                        - Unlikely
                        - Very unlikely

                        ### 9. **How often do you experience delays or issues with the bus arriving on time?**
                        - Never
                        - Rarely
                        - Sometimes
                        - Often
                        - Always

                        ### 10. **How easy is it to view and track your past trips?**
                        - Very easy
                        - Easy
                        - Neutral
                        - Difficult
                        - Very difficult

                        ### 11. **How satisfied are you with the duration options (1, 6, 12 months) available for bus bookings?**
                        - Very satisfied
                        - Satisfied
                        - Neutral
                        - Dissatisfied
                        - Very dissatisfied

                        ### 12. **How clear are the bus route and schedule details provided?**
                        - Very clear
                        - Mostly clear
                        - Neutral
                        - Somewhat unclear
                        - Very unclear

                        ### 13. **How responsive is the system if you need help with booking or any issues?**
                        - Very responsive
                        - Responsive
                        - Neutral
                        - Slow response
                        - No response

                        ### 14. **How would you rate the speed of the system (e.g., booking, checking trip history)?**
                        - Very fast
                        - Fast
                        - Average
                        - Slow
                        - Very slow

                        ### 15. **How would you rate your overall satisfaction with the bus management system?**
                        - Very satisfied
                        - Satisfied
                        - Neutral
                        - Dissatisfied
                        - Very dissatisfied

                        These questions should help gather detailed feedback from students on their experience with the system. Would you like to adjust or add more specific questions? --}}


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
