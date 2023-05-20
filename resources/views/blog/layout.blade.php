<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Blog Interview</title>
	<link rel="stylesheet" href="{{ asset('blog/fontawesome/css/all.min.css') }}"> <!-- https://fontawesome.com/ -->
	<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet"> <!-- https://fonts.google.com/ -->
    <link href="{{ asset('blog/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('blog/css/templatemo-xtra-blog.css') }}" rel="stylesheet">
<!--
    
TemplateMo 553 Xtra Blog

https://templatemo.com/tm-553-xtra-blog

-->
</head>
<body>
	<header class="tm-header" id="tm-header">
        <div class="tm-header-wrapper">
            <button class="navbar-toggler" type="button" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="tm-site-header">
                {{-- <div class="mb-3 mx-auto tm-site-logo"><i class="fas fa-times fa-2x"></i></div>             --}}
                <h1 class="text-center">Blog Interview</h1>
            </div>
            <nav class="tm-nav" id="tm-nav">            
                <ul>
                    <li class="tm-nav-item"><a href="{{ route('blog.index') }}" class="tm-nav-link">
                        <i class="fas fa-home"></i>
                        All Categories
                    </a></li>
                    @foreach ($categories as $category)
                    <li class="tm-nav-item"><a href="{{ route('blog.byCategory', ['category_id' => $category->id]) }}" class="tm-nav-link">
                        <i class="fas fa-pen"></i>
                        {{ $category->name }}
                    </a></li>
                    @endforeach
                    <li class="tm-nav-item"><a href="{{ route('blog.myPages') }}" class="tm-nav-link">
                        <i class="fas fa-home"></i>
                        My Pages
                    </a></li>
                    <form action="{{ route('logout') }}" method="POST" style="padding-left: 10px">
                        @csrf
                        <li class="tm-nav-item"> <button type="submit"  class="tm-nav-link">Logout</button></li>
                       
                    </form>
                </ul>
            </nav>
          
        </div>
    </header>
    <div class="container-fluid">
        <main class="tm-main">
            <!-- Search form -->
            {{-- <div class="row tm-row">
                <div class="col-12">
                    <form method="GET" class="form-inline tm-mb-80 tm-search-form">                
                        <input class="form-control tm-search-input" name="query" type="text" placeholder="Search..." aria-label="Search">
                        <button class="tm-search-button" type="submit">
                            <i class="fas fa-search tm-search-icon" aria-hidden="true"></i>
                        </button>                                
                    </form>
                </div>                
            </div>   --}}

            @yield('content')
            
            <footer class="row tm-row">
                <hr class="col-12">
                {{-- <div class="col-md-6 col-12 tm-color-gray">
                    Design: <a rel="nofollow" target="_parent" href="https://templatemo.com" class="tm-external-link">TemplateMo</a>
                </div>
                <div class="col-md-6 col-12 tm-color-gray tm-copyright">
                    Copyright 2020 Xtra Blog Company Co. Ltd.
                </div> --}}
            </footer>
        </main>
    </div>
    
    <script src="{{ asset('blog/js/jquery.min.js') }}"></script>
    <script src="{{ asset('blog/js/templatemo-script.js') }}"></script>
</body>
</html>