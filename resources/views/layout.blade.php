<!DOCTYPE html>
<html lang="en">
<head>
    <title>Health and Safety Dashboard</title>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
            crossorigin="anonymous"></script>
    <script src="{{ asset('/js/app.js') }}"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">

</head>

<body>
<!-- Top nav bar -->
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a href="{{ route('dashboard') }}" class="navbar-brand">Health and Safety Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{$_SERVER['REQUEST_URI'] == '/dashboard' ? ' active' : ''}}">Dashboard</a>
                </li>
                @if(Auth::user()->isAdmin())
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ strpos( $_SERVER['REQUEST_URI'], 'forms') != false ? ' active' : ''}}" data-toggle="dropdown" href="#" role="button"
                           aria-haspopup="true" aria-expanded="false">Forms
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{route('forms.create')}}" class="dropdown-item">Create</a>
                            <a href="{{ route('forms.index') }}" class="dropdown-item">Manage</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ strpos( $_SERVER['REQUEST_URI'], 'report') != false ? ' active' : ''}}" data-toggle="dropdown" href="#" role="button"
                           aria-haspopup="true" aria-expanded="false">Submissions
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{route('report')}}" class="dropdown-item">Report</a>
                            <a href="{{ route('report.overdue') }}" class="dropdown-item">Overdue</a>
                            <a href="{{ route('report.upcoming') }}" class="dropdown-item">Upcoming</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ strpos( $_SERVER['REQUEST_URI'], 'forms') != false ? ' active' : ''}}" data-toggle="dropdown" href="#" role="button"
                           aria-haspopup="true" aria-expanded="false">Training
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{route('training.create')}}" class="dropdown-item">Enter Training</a>
                            <a href="{{ route('training.report') }}" class="dropdown-item">Report</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admins') }}" class="nav-link {{$_SERVER['REQUEST_URI'] == '/admins' ? ' active' : ''}}">Admins</a>
                    </li>
                @elseif(Auth::user()->isPrincipal())
                    <li class="nav-item">
                        <a href="{{ route('report') }}" class="nav-link {{$_SERVER['REQUEST_URI'] == '/report' ? ' active' : ''}}">Submissions</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('training.report') }}" class="nav-link {{$_SERVER['REQUEST_URI'] == '/training/report' ? ' active' : ''}}">Training</a>
                    </li>

                @else
                    <li class="nav-item">
                        <a href="{{ route('submissions.index') }}" class="nav-link {{$_SERVER['REQUEST_URI'] == '/submissions' ? ' active' : ''}}">My Submissions</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('training.index') }}" class="nav-link {{$_SERVER['REQUEST_URI'] == '/training' ? ' active' : ''}}">My Training</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('calendar') }}" class="nav-link {{$_SERVER['REQUEST_URI'] == '/calendar' ? ' active' : ''}}">Calendar</a>
                </li>
            </ul>
            <ul class="navbar-nav justify-content-end">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                           aria-haspopup="true" aria-expanded="false">
                            @if(isset($user_avatar))
                                <img src="{{ $user_avatar }}" class="rounded-circle align-self-center mr-2"
                                     alt="user_avatar"
                                     style="width: 32px;">
                            @else
                                <i class="far fa-user-circle fa-lg rounded-circle align-self-center mr-2"
                                   style="width: 32px;"></i>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <h5 class="dropdown-item-text mb-0">{{ $userName }}</h5>
                            <p class="dropdown-item-text text-muted mb-0">{{ $userEmail }}</p>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('profile') }}" class="dropdown-item">Profile</a>
                            <a href="{{ route('signout') }}" class="dropdown-item">Sign Out</a>
                        </div>
                    </li>

            </ul>
        </div>
</nav>

<div class="wrapper">
    <!-- Sidebar -->
        <nav id="sidebar">
            <ul class="list-unstyled components">
                <br/>
                <p>Links to Forms</p>
                @foreach($links as $link)
                    <li>
                        <a href="{{ route('forms.show', $form=$link->id) }}">{{ $link->title }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>
<!-- Page Content -->
    <main role="main" class="container">
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible alert-dismissible fade show" role="alert">
                <p class="mb-3">{{ session('error') }}</p>
                @if(session('errorDetail'))
                    <pre class="alert-pre border bg-light p-2"><code>{{ session('errorDetail') }}</code></pre>
                @endif
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible alert-dismissible fade show" role="alert">
                <p>Check below to  fix errors in your submission</p>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session()->has('message'))
            <div class="alert alert-success alert-dismissible alert-dismissible fade show" role="alert">
                {{ session()->get('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @yield('content')
    </main>
</div>
</body>
</html>
