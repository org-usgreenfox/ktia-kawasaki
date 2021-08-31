@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Bar info</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('post.update', ['post' => $post->id ]) }}" enctype="multipart/form-data">
                    <!-- CROSS Site Request Forgery Protection -->
                    @csrf      
                    @method('put')              
                    <div class="form-group">
                        <label>Store</label>
                        <input type="text" class="form-control" name="store_name" id="store_name" value="{{ $post->store_name }}">
                    </div>

                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" name="address" id="address" value="{{ $post->address }}">
                    </div>

                    <div class="form-group">
                        <label>Store URL</label>
                        <input type="text" class="form-control" name="store_url" id="store_url" value="{{ $post->store_url }}">
                    </div>

                    <div class="form-group">
                        <label>SNS URL</label>
                        <input type="text" class="form-control" name="sns_url" id="sns_url" value="{{ $post->sns_url }}">
                    </div>

                    <div class="form-group">
                        <label>Tag</label>
                        <textarea class="form-control" name="comment" id="comment" rows="4">{{ $post->comment }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="image">Store Image（変更する場合は選択してください）</label>
                        <input type="file" class="form-control-file" name="image" id="image">
                    </div>

                    <input type="submit" name="send" value="Update" class="btn btn-dark btn-block">
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
