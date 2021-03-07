<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.partials.head')
</head>


<body class="hold-transition skin-blue sidebar-mini">

<div id="wrapper">

@include('admin.partials.topbar')
@include('admin.partials.sidebar')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            @if(isset($siteTitle))
                <h3 class="page-title">
                    {{ $siteTitle }}
                </h3>
            @endif

            <div class="row">
                <div class="col-md-12">

                    @include('admin.layouts.flash-message')

                    @yield('content')

                </div>
            </div>
        </section>
    </div>
</div>

{!! Form::open(['route' => 'auth.logout', 'style' => 'display:none;', 'id' => 'logout']) !!}
<button type="submit">Logout</button>
{!! Form::close() !!}

@include('admin.partials.javascripts')
</body>
</html>
