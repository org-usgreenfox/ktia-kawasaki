@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create new Review</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @foreach ($errors->all() as $error)
                        <div class="alert alert-success" role="alert">
                            <li>{{$error}}</li>
                        </div>
                    @endforeach

                    <form method="POST" action="{{ route('review.store', ['post_id' => $id ]) }}" enctype="multipart/form-data">
                    
                    <!-- CROSS Site Request Forgery Protection -->
                    @csrf

                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" id="store_name">
                    </div>

                    <div class="form-group">
                        <label>Comment</label>
                        <input type="text" class="form-control" name="comment" id="address">
                    </div>

                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control-file" name="image" id="image">
                    </div>

                    <input type="submit" name="send" value="Submit" class="btn btn-dark btn-block">
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection