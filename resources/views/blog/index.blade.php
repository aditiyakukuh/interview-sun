@extends('blog.layout')
@section('content')
<div class="row tm-row">
    @if(count($posts) <= 0)
        <h4>no data found</h4>
    @endif
    @foreach ($posts as $key => $post)
    <article class="col-12 col-md-6 tm-post">
        <hr class="tm-hr-primary">
        <a href="{{ route('blog.detail', ['post_id' => $post->id]) }}" class="effect-lily tm-post-link tm-pt-60">
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
@endsection