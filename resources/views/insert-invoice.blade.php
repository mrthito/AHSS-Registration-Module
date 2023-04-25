<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>surgerysociety</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .form-control {
            border-radius: 0px !important;
        }

        footer {
            bottom: 0;
            position: fixed;
            width: 100%;
            z-index: 999;
        }

        .body {
            min-height: 800px;
        }

        .m-b-150 {
            margin-bottom: 150px;
        }

        .input-group .btn {
            border-radius: 0px !important;
        }

        .select2-selection__rendered {
            line-height: 41px !important;
        }

        .select2-container .select2-selection--single {
            height: 45px !important;
        }

        .select2-selection__arrow {
            height: 44px !important;
        }

        /* below 960 px, make footer position relative */
        @media (max-width: 960px) {
            footer {
                position: relative;
            }

            .m-b-150 {
                margin-bottom: 50px;
            }

            .body {
                min-height: auto;
            }
        }

        .mouse-link {
            cursor: pointer;
        }
    </style>

    @livewireStyles
</head>

<body>
    <header>
        <div class="container pt-3 mb-2">
            <div class="row align-items-center">
                <div class="col-6">
                    <img class="img-fluid mouse-link"
                        src="https://surgerysociety.unipegasusinfotechsolutions.com/wp-content/uploads/2023/01/surgerysociety_logo.png"
                        alt="logo"
                        onclick="window.location.href='https://surgerysociety.unipegasusinfotechsolutions.com/'">
                </div>
                <div class="col-6 login text-end">
                    <h6>
                        <img class="img-fluid" src="https://secure.gravatar.com/avatar/?s=300&d=mm&r=g" alt="">
                        <a class="text-dark" href="">Login</a> / <a class="text-dark" href="">Register</a>
                    </h6>
                </div>
            </div>
        </div>
        <div>
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav m-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page"
                                    href="https://surgerysociety.unipegasusinfotechsolutions.com/">Home</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    About
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a href="https://surgerysociety.unipegasusinfotechsolutions.com/mission-statement/"
                                            class="dropdown-item">Mission Statement</a>
                                    </li>
                                    <li>
                                        <a href="https://surgerysociety.unipegasusinfotechsolutions.com/current-executives/"
                                            class="dropdown-item">Current Executive</a>
                                    </li>
                                    <li>
                                        <a href="https://surgerysociety.unipegasusinfotechsolutions.com/hand-surgeon-directory/"
                                            class="dropdown-item">Hand Surgeon Directory</a>
                                    </li>
                                    <li>
                                        <a href="https://surgerysociety.unipegasusinfotechsolutions.com/history/"
                                            class="dropdown-item">History</a>
                                    </li>
                                    <li>
                                        <a href="https://surgerysociety.unipegasusinfotechsolutions.com/australian-hand-surgery-societies/"
                                            class="dropdown-item">Australian State Hand Surgery Societies</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Membership
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item"
                                            href="https://surgerysociety.unipegasusinfotechsolutions.com/member-requirements/">Member
                                            Requirements</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="https://surgerysociety.unipegasusinfotechsolutions.com//membership-account/membership-levels/">Member
                                            Join Form</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="https://surgerysociety.unipegasusinfotechsolutions.com/hand-surgery-journal/">Hand
                                            Surgery Journal</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Fellowships & Training
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a href="https://surgerysociety.unipegasusinfotechsolutions.com/pfet-programme/"
                                            class="dropdown-item">PFET Programme</a>
                                    </li>
                                    <li>
                                        <a href="https://surgerysociety.unipegasusinfotechsolutions.com/general-fellowship-positions/"
                                            class="dropdown-item">General Fellowship Positions</a>
                                    </li>
                                    <li>
                                        <a href="https://surgerysociety.unipegasusinfotechsolutions.com/victoria/"
                                            class="dropdown-item">Victoria</a>
                                    </li>
                                    <li>
                                        <a href="https://surgerysociety.unipegasusinfotechsolutions.com/western-australia/"
                                            class="dropdown-item">Western Australia</a>
                                    </li>
                                    <li>
                                        <a href="https://surgerysociety.unipegasusinfotechsolutions.com/queensland/"
                                            class="dropdown-item">Queensland</a>
                                    </li>
                                    <li>
                                        <a href="https://surgerysociety.unipegasusinfotechsolutions.com/new-south-wales/"
                                            class="dropdown-item">New South Wales</a>
                                    </li>
                                    <li>
                                        <a href="https://surgerysociety.unipegasusinfotechsolutions.com/south-australia/"
                                            class="dropdown-item">South Australia</a>
                                    </li>
                                    <li>
                                        <a href="https://surgerysociety.unipegasusinfotechsolutions.com/new-zealand/"
                                            class="dropdown-item">New Zealand</a>
                                    </li>
                                    <li>
                                        <a href="https://surgerysociety.unipegasusinfotechsolutions.com/journal-club/"
                                            class="dropdown-item">Journal Club</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="https://surgerysociety.unipegasusinfotechsolutions.com/events">Events</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="https://surgerysociety.unipegasusinfotechsolutions.com/blog/">Latest News</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="https://surgerysociety.unipegasusinfotechsolutions.com/#getTouchID">Contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>


    <section class="body">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-12">
                    @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{Session::get('success')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong>
                        @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <form action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <select class="form-select form-select-lg" aria-label="Default select example"
                                name="user_id">
                                <option value="">Select User</option>
                                @forelse($users as $user)
                                <option value="{{$user->ID}}" {{old('user_id')==$user->ID ? 'selected' : ''}}>
                                    {{$user->display_name}} :: {{$user->user_email}}
                                </option>
                                @empty
                                <option value="">No User Found</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="mb-4">
                            <select class="form-select form-select-lg" aria-label="Default select example"
                                name="level_id">
                                <option value="">Select Level</option>
                                @forelse($levels as $level)
                                <option value="{{$level->id}}" {{old('level_id')==$level->id ? 'selected' : ''}}>
                                    {{$level->name}} :: ${{round($level->initial_payment, 2)}}
                                </option>
                                @empty
                                <option value="">No Levels Found</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="mb-4">
                            <select class="form-select form-select-lg" aria-label="Default select example" name="year">
                                <option value="">Select Year</option>
                                @foreach([2020, 2021, 2022, 2023, 2024, 2025] as $year)
                                <option value="{{$year}}" {{old('year')==$year ? 'selected' : '' }}>{{$year}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <select class="form-select form-select-lg" aria-label="Default select example"
                                name="payment">
                                <option value="">Select Term</option>
                                <option value="initial" {{old('payment')=='initial' ? 'selected' : '' }}>Initial Payment
                                </option>
                                <option value="billing" {{old('payment')=='billing' ? 'selected' : '' }}>Billing
                                </option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container py-4">
            <div class="row align-items-center">
                <div class="col-lg-4 col-12 text-center">
                    <p>ABN 64388980516</p>
                </div>
                <div class="col-lg-4 col-12 text-center py-4"><i class="fa-brands fa-instagram"></i></div>
                <div class="col-lg-4 col-12 ">
                    <ul class="p-0">
                        <li>Privacy</li>
                        <li>Security</li>
                        <li>Terms & Conditions</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
        integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @stack('scripts')

    <script>
        $(document).ready(function () {
            $('select').select2();
        });
    </script>
</body>

</html>