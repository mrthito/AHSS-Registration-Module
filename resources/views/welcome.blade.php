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
                        src="{{ env('MAIN_DOMAIN') }}wp-content/uploads/2023/01/surgerysociety_logo.png" alt="logo"
                        onclick="window.location.href='{{ env('MAIN_DOMAIN') }}'">
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
                                <a class="nav-link active" aria-current="page" href="{{ env('MAIN_DOMAIN') }}">Home</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    About
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a href="{{ env('MAIN_DOMAIN') }}mission-statement/"
                                            class="dropdown-item">Mission Statement</a>
                                    </li>
                                    <li>
                                        <a href="{{ env('MAIN_DOMAIN') }}current-executives/"
                                            class="dropdown-item">Current Executive</a>
                                    </li>
                                    <li>
                                        <a href="{{ env('MAIN_DOMAIN') }}hand-surgeon-directory/"
                                            class="dropdown-item">Hand Surgeon Directory</a>
                                    </li>
                                    <li>
                                        <a href="{{ env('MAIN_DOMAIN') }}history/" class="dropdown-item">History</a>
                                    </li>
                                    <li>
                                        <a href="{{ env('MAIN_DOMAIN') }}australian-hand-surgery-societies/"
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
                                            href="{{ env('MAIN_DOMAIN') }}member-requirements/">Member
                                            Requirements</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ env('MAIN_DOMAIN') }}/membership-account/membership-levels/">Member
                                            Join Form</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ env('MAIN_DOMAIN') }}hand-surgery-journal/">Hand
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
                                        <a href="{{ env('MAIN_DOMAIN') }}pfet-programme/" class="dropdown-item">PFET
                                            Programme</a>
                                    </li>
                                    <li>
                                        <a href="{{ env('MAIN_DOMAIN') }}general-fellowship-positions/"
                                            class="dropdown-item">General Fellowship Positions</a>
                                    </li>
                                    <li>
                                        <a href="{{ env('MAIN_DOMAIN') }}victoria/" class="dropdown-item">Victoria</a>
                                    </li>
                                    <li>
                                        <a href="{{ env('MAIN_DOMAIN') }}western-australia/"
                                            class="dropdown-item">Western Australia</a>
                                    </li>
                                    <li>
                                        <a href="{{ env('MAIN_DOMAIN') }}queensland/"
                                            class="dropdown-item">Queensland</a>
                                    </li>
                                    <li>
                                        <a href="{{ env('MAIN_DOMAIN') }}new-south-wales/" class="dropdown-item">New
                                            South Wales</a>
                                    </li>
                                    <li>
                                        <a href="{{ env('MAIN_DOMAIN') }}south-australia/" class="dropdown-item">South
                                            Australia</a>
                                    </li>
                                    <li>
                                        <a href="{{ env('MAIN_DOMAIN') }}new-zealand/" class="dropdown-item">New
                                            Zealand</a>
                                    </li>
                                    <li>
                                        <a href="{{ env('MAIN_DOMAIN') }}journal-club/" class="dropdown-item">Journal
                                            Club</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ env('MAIN_DOMAIN') }}events">Events</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ env('MAIN_DOMAIN') }}blog/">Latest News</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ env('MAIN_DOMAIN') }}#getTouchID">Contact</a>
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
                <livewire:register-form />
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

    @stack('scripts')

    <script>
        Livewire.on('pageChanged', function (){
                var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
                var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                    return new bootstrap.Popover(popoverTriggerEl)
                })
            });
    </script>
</body>

</html>