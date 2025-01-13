<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')



        <!-- Page Content -->
        <main >

            <div class="container-fluid">
                <div class="row my-10" >
                    <div class="image-container" style="text-align: center;width: 100%">
                        <img src="{{ asset('images/banner.jpg') }}" alt="Description of Image" style="width: 100%;height:400px">
                    </div>
                </div>
                <div class="row my-10 mx-10">
                    <div class="container">
                        <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
                            <!-- Indicators -->
                            <ol class="carousel-indicators">
                                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                <li data-target="#myCarousel" data-slide-to="1"></li>
                                <li data-target="#myCarousel" data-slide-to="2"></li>
                            </ol>
                
                            <!-- Wrapper for slides -->
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="{{ asset('images\sale.png') }}" class="d-block w-70" alt="Los Angeles" style="width:100%;height:350px">
                                    <div class="carousel-caption d-none d-md-block">
                                    </div>
                                </div>
                                @foreach($sales as $sale)
                                <div class="carousel-item">
                                    <a href="/catalogue/{{$sale->game_id}}"><img src="{{ asset($sale->image) }}" class="d-block w-70" alt="Chicago" style="width:100%;height:350px"></a>
                                    <div class="carousel-caption d-none d-md-block">
                                        <h3>{{$sale->name}}</h3>
                                        <s><p>${{$sale->old_price}}</p></s>
                                        <p>${{$sale->new_price}}</p>
                                    </div>
                                </div>
                                @endforeach
                                
                            </div>
                
                            <!-- Left and right controls -->
                            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row my-10 mx-10" >
                    @php
                    $genres = DB::table('genres')->get()
                    @endphp
                    @foreach ($genres as $genre)
                        <div class="col-2 my-10">
                            <div >
                                <a href="/{{ $genre->genre }}">{{ $genre->genre }}</a>
                
                                @php
                                    // Initialize the image path
                                    $imagePath = 'images/default.jpg'; // Default image
                
                                    // Use a switch statement to determine the image based on the genre
                                    switch ($genre->genre) {
                                        case 'Horror':
                                            $imagePath = 'images/horror.jpg';
                                            break;
                                        case 'Role-Playing Games (RPG)':
                                            $imagePath = 'images/rpg.jpg';
                                            break;
                                        case 'Strategy':
                                            $imagePath = 'images/strategy.jpg';
                                            break;
                                        case 'Sports':
                                            $imagePath = 'images/sports.png';
                                            break;
                                        case 'Educational':
                                            $imagePath = 'images/educational.png';
                                            break;
                                        case 'Adventure':
                                            $imagePath = 'images/adventure.jpg';
                                            break;
                                        case 'Racing':
                                            $imagePath = 'images/racing .jpg';
                                            break;
                                        case 'Action':
                                            $imagePath = 'images/action.jpg';
                                            break;
                                        case 'Fighting':
                                            $imagePath = 'images/fighting.jpg';
                                            break;
                                        case 'Card Games':
                                            $imagePath = 'images/card.png';
                                            break;
                                        case 'MMORPG (Massively Multiplayer Online RPG)':
                                            $imagePath = 'images/mmorpg.jpg';
                                            break;
                                        case 'Simulation':
                                            $imagePath = 'images/simulation.jpg';
                                            break;
                                        case 'Shooter':
                                            $imagePath = 'images/shooter.jpg';
                                            break;
                                        case 'Idle Games':
                                            $imagePath = 'images/idle_game.png';
                                            break;
                                        case 'Sandbox':
                                            $imagePath = 'images/sandbox.png';
                                            break;
                                        case 'Platformer':
                                            $imagePath = 'images/platform.png';
                                            break;
                                        case 'Battle Royale':
                                            $imagePath = 'images/battleroyale.png';
                                            break;
                                        case 'Puzzle':
                                            $imagePath = 'images/puzzle.jpg';
                                            break;
                                        default:
                                            $imagePath = 'images/default.jpg'; // Fallback image
                                            break;
                                    }
                                @endphp
                
                                <img src="{{ asset($imagePath) }}" alt="{{ $genres }} Image" style="width: 100%; height: 250px;">
                            </div>
                        </div>
                    @endforeach
                </div>


            </div>
        </main>
    </div>
</body>
<div class="rhf-frame" style="display: block;"> <br>
    <div id="rhf-container">
        <div class="rhf-border">
            <div id="rhf-shoveler"></div>
            <div class="celwidget pd_rd_w-tDv1j content-id-amzn1.sym.f5690a4d-f2bb-45d9-9d1b-736fee412437 pf_rd_p-f5690a4d-f2bb-45d9-9d1b-736fee412437 pf_rd_r-DFV9XFE0QX4ASYV0FCNQ pd_rd_wg-vP5MP pd_rd_r-92810a7c-e433-4e6c-ad66-8dbc43261d1a c-f"
                cel_widget_id="p13n-rvi_desktop-rvi_0" data-csa-op-log-render=""
                data-csa-c-content-id="amzn1.sym.f5690a4d-f2bb-45d9-9d1b-736fee412437"
                data-csa-c-slot-id="desktop-rvi-1" data-csa-c-type="widget" data-csa-c-painter="p13n-rvi-cards"
                data-csa-c-id="1si1zl-gxoe5z-2l0hml-s2xcc5" data-cel-widget="p13n-rvi_desktop-rvi_0">
            </div>
        </div>
    </div> <noscript>
        <div class='rhf-border'>
            <div class='rhf-header'> Your recently viewed items and featured recommendations </div>
            <div class='rhf-footer'>
                <div class='rvi-container'>
                    <div class='ybh-edit'>
                        <div class='ybh-edit-arrow'> &#8250; </div>
                        <div class='ybh-edit-link'> <a href='/gp/history'> View or edit your browsing history </a>
                        </div>
                    </div> <span class='no-rvi-message'> After viewing product detail pages, look here to find an easy
                        way to navigate back to pages you are interested in. </span>
                </div>
            </div>
        </div>
    </noscript>
    <div id="rhf-error" style="display: block;">
        <div class="rhf-border">
            <div class="rhf-header"> Your recently viewed items and featured recommendations </div>
            <div class="rhf-footer">
                <div class="rvi-container">
                    <div class="ybh-edit">
                        <div class="ybh-edit-arrow"> › </div>
                        <div class="ybh-edit-link"> <a href="/gp/history"> View or edit your browsing history </a>
                        </div>
                    </div> <span class="no-rvi-message"> After viewing product detail pages, look here to find an easy
                        way to navigate back to pages you are interested in. </span>
                </div>
            </div>
        </div>
    </div> <br>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</html>
