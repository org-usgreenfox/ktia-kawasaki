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
                        @if(!empty($post->image))
                        <img src="{{ '/storage/' . $post->image }} " class="" alt="photo">
                        @endif
                        <div class="p-2 bd-highlight">{{ $post->store_name }}</div>
                        <div class="p-2 bd-highlight">
                            <a href="{{ route('map.show', ['id' => $post->id ]) }}" target="blank">{{ $post->address }}</a>
                        </div>
                        <div class="p-2 bd-highlight">
                            @if(!empty($post->store_url))
                            <a href="{{ $post->store_url }}" target="blank">HP</a>
                            @endif  
                        </div>
                        <div class="p-2 bd-highlight">
                            @if(!empty($post->sns_url))
                            <a href="{{ $post->sns_url }}" target="blank">Instagram</a>
                            @endif
                        </div>
                        <div class="p-2 bd-highlight">{{ $rev_comment }}</div>
                    </div>
                    <div class="btn-group">
                        @foreach($tags as $tag)
                        <form method="GET" action="{{ route('tag.index') }}">
                        <input type="submit" class="btn-outline-dark btn-sm mx-1 p-1" value="{{ $tag }}">
                        <input type="hidden" name="tag" value="{{ $tag }}">
                        </form>
                        @endforeach
                    </div>


                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <form method="GET" action="{{ route('post.edit', ['post' => $post->id ]) }}" >
                    <!-- CROSS Site Request Forgery Protection -->
                    @csrf                    
                    <input type="submit" name="send" value="Edit" class="btn btn-dark mx-1">
                    </form>

                    <form method="POST" action="{{ route('post.destroy', ['post' => $post->id ]) }}" id="delete_{{ $post->id }}" >
                    <a href="#"class="btn btn-danger mx-1" data-id="{{ $post->id }}" onclick="deletePost(this);" >Delete</a>
                    @csrf
                    @method('DELETE')
                    </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
function deletePost(e){
    'use strict';
    if (confirm('本当に削除しますか？')) {
        document.getElementById('delete_' + e.dataset.id).submit();
    }
}
</script>
@endsection
