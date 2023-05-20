@extends('blog.layout')
@section('content')
<div class="row tm-row">
    <div class="col-12">
        <hr class="tm-hr-primary tm-mb-55">
        <img src="https://picsum.photos/200/300?random={{ $post->id }}" alt="Image" class="img-fluid" style="width: 954px; height: 535px;">      
    </div>
</div>
<div class="row tm-row">
    <div class="col-lg-8 tm-post-col">
        <div class="tm-post-full">                    
            <div class="mb-4">
                <h2 class="pt-2 tm-color-primary tm-post-title">{{ $post->title }}</h2>
                <p class="tm-mb-40">{{ $post->created_at->format('F d, Y') }} posted by {{ $post->user->name ?? "" }}</p>
                <p>
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
                </div>  
            </div>
        </div>
    </div>
    <aside class="col-lg-4 tm-aside-col">
        <div class="tm-post-sidebar">
            <hr class="mb-3 tm-hr-primary">
            <h2 class="mb-4 tm-post-title tm-color-primary">Categories</h2>
            <ul class="tm-mb-75 pl-5 tm-category-list">
                @foreach ($categories as $category)
                <li><a href="{{ route('blog.byCategory', ['category_id' => $category->id]) }}" class="tm-color-primary">{{ $category->name }}</a></li>
                @endforeach
            </ul>
            <hr class="mb-3 tm-hr-primary">
            <h2 class="tm-mb-40 tm-post-title tm-color-primary">Related Posts</h2>
            @foreach ($related_posts as $related_post)
            <a href="{{ route('blog.detail', ['post_id' => $related_post->id]) }}" class="d-block tm-mb-40">
                <figure>
                    <img src="https://picsum.photos/200/300?random={{ $related_post->id }}" alt="Image" class="mb-3 img-fluid" style="max-height: 104px; width: 240px">
                    <figcaption class="tm-color-primary">{{ $related_post->title }}</figcaption>
                </figure>
            </a>
            @endforeach
        </div>                    
    </aside>
</div>
@endsection