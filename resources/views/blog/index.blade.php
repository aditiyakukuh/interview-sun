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
                <div class="mb-3 mx-auto tm-site-logo"><i class="fas fa-times fa-2x"></i></div>            
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
            <div class="tm-mb-65">
                <a rel="nofollow" href="https://fb.com/templatemo" class="tm-social-link">
                    <i class="fab fa-facebook tm-social-icon"></i>
                </a>
                <a href="https://twitter.com" class="tm-social-link">
                    <i class="fab fa-twitter tm-social-icon"></i>
                </a>
                <a href="https://instagram.com" class="tm-social-link">
                    <i class="fab fa-instagram tm-social-icon"></i>
                </a>
                <a href="https://linkedin.com" class="tm-social-link">
                    <i class="fab fa-linkedin tm-social-icon"></i>
                </a>
            </div>
            <p class="tm-mb-80 pr-5 text-white">
                Xtra Blog is a multi-purpose HTML template from TemplateMo website. Left side is a sticky menu bar. Right side content will scroll up and down.
            </p>
        </div>
    </header>
    <div class="container-fluid">
        <main class="tm-main">
            <!-- Search form -->
            <div class="row tm-row">
                <div class="col-12">
                    <form method="GET" class="form-inline tm-mb-80 tm-search-form">                
                        <input class="form-control tm-search-input" name="query" type="text" placeholder="Search..." aria-label="Search">
                        <button class="tm-search-button" type="submit">
                            <i class="fas fa-search tm-search-icon" aria-hidden="true"></i>
                        </button>                                
                    </form>
                </div>                
            </div>            
            <div class="row tm-row">
                @if(count($posts) <= 0)
                    <h4>no data found</h4>
                @endif
                @foreach ($posts as $key => $post)
                <article class="col-12 col-md-6 tm-post">
                    <hr class="tm-hr-primary">
                    <a href="post.html" class="effect-lily tm-post-link tm-pt-60">
                        <div class="tm-post-link-inner">
                            <img src="https://picsum.photos/200/300?random={{ $key }}" alt="Image" class="img-fluid" style="max-height: 244px;">                            
                        </div>
                        <span class="position-absolute tm-new-badge">{{ $post->category->name }}</span>
                        <h2 class="tm-pt-30 tm-color-primary tm-post-title">{{ $post->title }}</h2>
                    </a>                    
                    <p class="tm-pt-30">
                        {{ $post->content }}
                    </p>
                    <div class="d-flex justify-content-between tm-pt-45">
                        <div>
                            @foreach ($post->tags as $tag)
                            <a href="{{ route('blog.byTag', ['tag_id' => $tag->id]) }}" class="tm-color-primary">{{ $tag->name }}</a>
                            @if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                        </div>
                        <span class="tm-color-primary">{{ $post->created_at->format('F d, Y') }}</span>
                    </div>           
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span>by {{ $post->user->name ?? "" }}</span>
                    </div>
                </article>
                @endforeach
        
            </div>
            {{-- <div class="row tm-row tm-mt-100 tm-mb-75">
                <div class="tm-prev-next-wrapper">
                    <a href="#" class="mb-2 tm-btn tm-btn-primary tm-prev-next disabled tm-mr-20">Prev</a>
                    <a href="#" class="mb-2 tm-btn tm-btn-primary tm-prev-next">Next</a>
                </div>
                <div class="tm-paging-wrapper">
                    <span class="d-inline-block mr-3">Page</span>
                    <nav class="tm-paging-nav d-inline-block">
                        <ul>
                            <li class="tm-paging-item active">
                                <a href="#" class="mb-2 tm-btn tm-paging-link">1</a>
                            </li>
                            <li class="tm-paging-item">
                                <a href="#" class="mb-2 tm-btn tm-paging-link">2</a>
                            </li>
                            <li class="tm-paging-item">
                                <a href="#" class="mb-2 tm-btn tm-paging-link">3</a>
                            </li>
                            <li class="tm-paging-item">
                                <a href="#" class="mb-2 tm-btn tm-paging-link">4</a>
                            </li>
                        </ul>
                    </nav>
                </div>                
            </div>             --}}
            <div class="row tm-row tm-mt-100 tm-mb-75">
                <div class="tm-prev-next-wrapper">
                    <a href="{{ $posts->previousPageUrl() }}" class="mb-2 tm-btn tm-btn-primary tm-prev-next {{ $posts->previousPageUrl() ? '' : 'disabled' }}">Prev</a>
                    <a href="{{ $posts->nextPageUrl() }}" class="mb-2 tm-btn tm-btn-primary tm-prev-next {{ $posts->nextPageUrl() ? '' : 'disabled' }}">Next</a>
                </div>
                <div class="tm-paging-wrapper">
                    <span class="d-inline-block mr-3">Page</span>
                    <nav class="tm-paging-nav d-inline-block">
                        <ul>
                            @for ($i = 1; $i <= $posts->lastPage(); $i++)
                                <li class="tm-paging-item {{ $posts->currentPage() === $i ? 'active' : '' }}">
                                    <a href="{{ $posts->url($i) }}" class="mb-2 tm-btn tm-paging-link">{{ $i }}</a>
                                </li>
                            @endfor
                        </ul>
                        
                    </nav>
                </div>                
            </div>
            
            <footer class="row tm-row">
                <hr class="col-12">
                <div class="col-md-6 col-12 tm-color-gray">
                    Design: <a rel="nofollow" target="_parent" href="https://templatemo.com" class="tm-external-link">TemplateMo</a>
                </div>
                <div class="col-md-6 col-12 tm-color-gray tm-copyright">
                    Copyright 2020 Xtra Blog Company Co. Ltd.
                </div>
            </footer>
        </main>
    </div>
    
    <script src="{{ asset('blog/js/jquery.min.js') }}"></script>
    <script src="{{ asset('blog/js/templatemo-script.js') }}"></script>
</body>
</html>