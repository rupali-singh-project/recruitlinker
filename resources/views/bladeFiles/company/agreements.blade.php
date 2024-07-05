<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Job Portal</title>
    <!-- base:css -->
    <link rel="stylesheet" href="{{asset('public/assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/vendors/base/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset('public/assets/css/style.css')}}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{asset('public/assets/images/favicon.png')}}" />
    <link rel="stylesheet" href="{{asset('public/assets/vendors/summernote/summernote.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/vendors/sweetalerts/dist/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/css\maps\horizontal-layout-light/style.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif
        }

        p {
            margin: 0
        }

        .container {
            max-width: 100%;
            margin: 10px auto;
            background-color: #e8eaf6;
            padding: 35px;
        }

        .box-right {
            padding: 30px 25px;
            background-color: white;
            border-radius: 15px
        }

        .box-left {
            padding: 20px 20px;
            background-color: white;
            border-radius: 15px
        }

        .textmuted {
            color: #7a7a7a
        }

        .bg-green {
            background-color: #d4f8f2;
            color: #06e67a;
            padding: 3px 0;
            display: inline;
            border-radius: 25px;
            font-size: 11px
        }

        .p-blue {
            font-size: 14px;
            color: #1976d2
        }

        .fas.fa-circle {
            font-size: 12px
        }

        .p-org {
            font-size: 14px;
            color: #fbc02d
        }

        .h7 {
            font-size: 15px
        }

        .h8 {
            font-size: 12px
        }

        .h9 {
            font-size: 10px
        }

        .bg-blue {
            background-color: #dfe9fc9c;
            border-radius: 5px
        }

        .form-control {
            box-shadow: none !important
        }

        .card input::placeholder {
            font-size: 14px
        }

        ::placeholder {
            font-size: 14px
        }

        input.card {
            position: relative
        }

        .far.fa-credit-card {
            position: absolute;
            top: 10px;
            padding: 0 15px
        }

        .fas,
        .far {
            cursor: pointer
        }

        .cursor {
            cursor: pointer
        }

        .btn.btn-primary {
            box-shadow: none;
            height: 40px;
            padding: 11px
        }

        .bg.btn.btn-primary {
            background-color: transparent;
            border: none;
            color: #1976d2
        }

        .bg.btn.btn-primary:hover {
            color: #539ee9
        }

        @media(max-width:320px) {
            .h8 {
                font-size: 11px
            }

            .h7 {
                font-size: 13px
            }

            ::placeholder {
                font-size: 10px
            }
        }
    </style>
    @yield('styles')
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12 mb-2 text-right">
                <form action="{{url('logout')}}">
                    <button class="btn btn-warning"><i class="fas fa-log-out"></i>Logout</button>
                </form>
            </div>
        </div>
        <div class="row m-0">
            <div class="col-md-12 col-12">
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="row box-right">
                            <div class="col-md-8 ps-0 ">
                                <p class="h1 fw-bold d-flex"> <span class=" fa fa-inr textmuted pe-1 h6 align-text-top mt-1"></span>User Agreements </p>
                                <!-- <p class="ms-3 px-2 bg-green">Latest</p> -->
                            </div>

                        </div>
                    </div>
                    <div class="col-12 px-0 mb-4">
                        <div class="box-right">

                            <div class="bg-blue p-2">
                                <div class="h8 textmuted">
                                    <p>Terms and Conditions</p>

                                    <p>These Terms and Conditions ("Agreement") govern your use of our job searching website ("Website") operated by [Company Name] ("Company", "we", "us", or "our"). This Agreement sets forth the legally binding terms and conditions for your use of the Website at [website URL].</p>

                                    <p>
                                        By accessing or using the Website in any manner, including, but not limited to, visiting or browsing the Website or contributing content or other materials to the Website, you agree to be bound by these Terms and Conditions. Capitalized terms are defined in this Agreement.
                                    <ul>

                                        <li>
                                            <p>Intellectual Property</p>
                                            <p>The Website and its original content, features, and functionality are owned by [Company Name] and are protected by international copyright, trademark, patent, trade secret, and other intellectual property or proprietary rights laws.</p>
                                        </li>

                                        <li>
                                            <p>Termination</p>
                                            <p>We may terminate your access to the Website, without cause or notice, which may result in the forfeiture and destruction of all information associated with you. All provisions of this Agreement that by their nature should survive termination shall survive termination, including, without limitation, ownership provisions, warranty disclaimers, indemnity, and limitations of liability.</p>
                                        </li>
                                        <li>
                                            <p>Links To Other Sites</p>
                                            <p>Our Website may contain links to third-party sites that are not owned or controlled by [Company Name]. We have no control over and assume no responsibility for the content, privacy policies, or practices of any third-party sites or services. We strongly advise you to read the terms and conditions and privacy policy of any third-party site that you visit.</p>
                                        </li>
                                        <li>
                                            <p>Governing Law</p>

                                            <p>This Agreement (and any further rules, policies, or guidelines incorporated by reference) shall be governed and construed in accordance with the laws of [Country], without giving effect to any principles of conflicts of law.</p>
                                        </li>
                                        <li>
                                            <p>Changes To This Agreement</p>

                                            <p>We reserve the right, at our sole discretion, to modify or replace these Terms and Conditions by posting the updated terms on the Website. Your continued use of the Website after any such changes constitutes your acceptance of the new Terms and Conditions.</p>
                                        </li>
                                    </ul>
                                    </p>
                                    <p>
                                        Please review this Agreement periodically for changes.

                                        If you have any questions about this Agreement, please contact us.
                                    </p>
                                </div>
                            </div>
                            <form action="{{url('account/agreements/update')}}" metod="POST" id="user_agreement_form">
                                <p class="mt-2">
                                    <input type="checkbox" name="accept_agreements" required>I accept these terms & conditions.
                                </p>
                                <button type="submit" class="btn btn-success btn-sm">Update</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script>

    </script>
</body>

</html>