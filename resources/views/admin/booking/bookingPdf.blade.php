<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        @stack('header')
        <meta content="" name="description">
        <meta content="" name="keywords">

        <!-- Favicons -->
        <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
        <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

        <!-- Google Fonts -->
        <link href="https://fonts.gstatic.com" rel="preconnect">
        <link
            href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
            rel="stylesheet">

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


        <h1 class="card-title">{{ $title }}</h1>

        <table id="zctb" class="table border table-bordered border-primary table-striped border-3" border="1" width="100%" style="font-size: small">

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

                @isset($booking->transactions[0])
                    <tr>
                        <td class="text-center text-primary" colspan="6"><h5>Current Booking Transactions</h5></td>
                    </tr>
                    @foreach ($booking->transactions as $transaction)
                        <tr>
                            <td ><b>Payment Date</b></td>
                            <td>{{ $transaction->payment_date }}</td>
                            <td><b>Reciept Token</b></td>
                            <td>{{ $transaction->reciept_token }}</td>
                            <td><b>Paid Amount</b></td>
                            <td>{{ $transaction->paid_amount }}</td>
                        </tr>

                        <tr>
                            <td ><b>Pay Type</b></td>
                            <td>{{ $transaction->pay_type }}</td>
                            <td><b>Paid Status</b></td>
                            <td>{{ $transaction->paid_status }}</td>
                            <td><b>Status</b></td>
                            <td>{{ $transaction->status }}</td>
                        </tr>

                    @endforeach

                @endisset

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
        @php
            $color = $booking->status == 'pending' ? 'warning' : ($booking->status == 'rejected' ? 'danger' : 'success');
        @endphp
        <div class="text-{{ $color }} border border-{{ $color }} border-4 col-md-2 text-center" style="margin-top: 5px"><b>{{ Str::ucfirst($booking->status) }}</b></div>

        <!-- Vendor JS Files -->
        <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
        <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
        <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>

        <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
        <script>
            new DataTable('#multi-filter-select', {
                layout: {
                    topStart: {
                        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                    }
                }
            });
        </script>

        <!-- Template Main JS File -->
        <script src="{{ asset('assets/js/main.js') }}"></script>

    </body>

</html>
