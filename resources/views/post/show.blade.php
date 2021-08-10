@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Bar info</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="d-flex flex-column bd-highlight mb-3">
                        @if(!empty($show_post['post']->image))
                        <img src="{{ '/storage/' . $show_post['post']->image }} " class="" alt="photo">
                        @endif
                        
                        <div class="p-2 bd-highlight">{{ $show_post['post']->store_name }}</div>
                        <div class="p-2 bd-highlight">
                            <a href="{{ route('map.show', ['id' => $show_post['post']->id ]) }}" target="blank">{{ $show_post['post']->address }}</a>
                        </div>
                        <div class="p-2 bd-highlight">
                            @if(!empty($show_post['post']->store_url))
                            <a href="{{ $show_post['post']->store_url }}" target="blank">HP</a>
                            @endif
                        </div>
                        <div class="p-2 bd-highlight">
                            @if(!empty($show_post['post']->sns_url))
                            <a href="{{ $show_post['post']->sns_url }}" target="blank">Instagram</a>
                            @endif
                        </div>
                        <div class="p-2 bd-highlight">{{ $show_post['rev_comment'] }}</div>
                    </div>
                    <div class="btn-group">
                        @foreach($show_post['tags'] as $tag)
                        <form method="GET" action="{{ route('tag.index') }}">
                            <input type="submit" class="btn-outline-dark btn-sm mx-1 p-1" value="{{ $tag }}">
                            <input type="hidden" name="tag" value="{{ $tag }}">
                        </form>
                        @endforeach
                    </div>


                    @auth
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <form method="GET" action="{{ route('review.create', ['id' => $show_post['post']->id ]) }}">
                            <!-- CROSS Site Request Forgery Protection -->
                            @csrf
                            <input type="submit" name="send" value="Create review" class="btn btn-dark mx-1">
                        </form>
                        <form method="GET" action="{{ route('post.edit', ['post' => $show_post['post']->id ]) }}">
                            <!-- CROSS Site Request Forgery Protection -->
                            @csrf
                            <input type="submit" name="send" value="Edit" class="btn btn-dark mx-1">
                        </form>

                        <form method="POST" action="{{ route('post.destroy', ['post' => $show_post['post']->id ]) }}" id="delete_{{ $show_post['post']->id }}">
                            <a href="#" class="btn btn-danger mx-1" data-id="{{ $show_post['post']->id }}" onclick="deletePost(this);">Delete</a>
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                    @endauth

                </div>
            </div>         
            <div class="reviews">
                @if(!empty($show_post['reviews'][0]))
                <h3 class="mt-1 mb-0">Review list</h3>
                @endif
                @foreach($show_post['reviews'] as $review)
                
                <div class="card">
                    <div class="card-body d-flex justify-content-between">
                        <div class="detail">
                            <h5 class="card-title">{{ $review->title }}</h5>
                            <p class="card-text">{{ $review->comment }}</p>
                            <h6 class="card-text">{{ $review->user_name }}</h6>
                        </div>
                        @if(!empty($review->image))
                        <img src="{{ '/storage/' . $review->image }} " class="card-img-top d-inline-block w-25" alt="review_image">
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            
        </div>
    </div>
</div>
<script>
    function deletePost(e) {
        'use strict';
        if (confirm('本当に削除しますか？')) {
            document.getElementById('delete_' + e.dataset.id).submit();
        }
    }
</script>
@endsection