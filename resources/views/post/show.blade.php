@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $show_post['post']->store_name }}</div>

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
                        <div class="p-2 bd-highlight">
                            <a href="{{ route('map.show', ['id' => $show_post['post']->id ]) }}" target="blank"><i class="fas fa-map-marked-alt mr-2"></i>{{ $show_post['post']->address }}</a>
                        </div>
                        @if(!empty($show_post['post']->store_url))
                            <div class="p-2 bd-highlight">
                                <a href="{{ $show_post['post']->store_url }}" target="blank"><i class="fas fa-home mr-2"></i>HP</a>
                            </div>
                        @endif
                        @if(!empty($show_post['post']->sns_url))
                            <div class="p-2 bd-highlight">
                                <a href="{{ $show_post['post']->sns_url }}" target="blank"><i class="fab fa-instagram mr-2"></i>Instagram</a>
                            </div>
                        @endif
                        <div class="p-2 bd-highlight">{{ $show_post['rev_comment'] }}</div>
                    </div>
                    <div class="p-2 btn-group text-align-center">
                        <i class="fas fa-tags mr-2"></i>
                        @foreach($show_post['tags'] as $tag)
                        <a class="btn-outline-dark btn-sm mx-1 p-1" href="{{ route('tag.index', ['tag' => $tag]) }}">#{{ $tag }}</a>
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

                        <form method="POST" action="{{ route('post.destroy', ['post' => $show_post['post']->id ]) }}" id="delete_store_{{ $show_post['post']->id }}">
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
                            <h5 class="card-title">{{ $review->title }}
                                @if ($review->user_id === Auth::user()->id)
                                <a href="{{ route('review.edit', ['id' => $review->id]) }}"><i class="fas fa-pen-square ml-2"></i></a>
                                <form method="POST" action="{{ route('review.destroy', ['id' => $review->id]) }}" id="delete_review_{{ $review->id }}">
                                    <a href="#" data-id="{{ $review->id }}" onclick="deleteReview(this);"><i class="fas fa-trash-alt"></i></a>
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endif
                            </h5>
                            <p class="card-text">{{ $review->comment }}</p>
                            <h6 class="card-text">
                                <a href="{{ route('user.show', ['id' => $review->user_id]) }}">{{ $review->user_name }}</a>
                            </h6>
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
            document.getElementById('delete_store_' + e.dataset.id).submit();
        }
    }
    function deleteReview(e) {
        'use strict';
        if (confirm('本当に削除しますか？')) {
            document.getElementById('delete_review_' + e.dataset.id).submit();
        }
    }
</script>
@endsection