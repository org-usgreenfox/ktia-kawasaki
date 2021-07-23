@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create new Tap</div>

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

                    <form method="POST" action="{{ route('post.store') }}">
                    
                    <!-- CROSS Site Request Forgery Protection -->
                    @csrf

                    <div class="form-group">
                        <label>Store</label>
                        <input type="text" class="form-control" name="store_name" id="store_name">
                    </div>

                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" name="address" id="address">
                    </div>

                    <div class="form-group">
                        <label>Store URL</label>
                        <input type="text" class="form-control" name="store_url" id="store_url">
                    </div>

                    <div class="form-group">
                        <label>SNS URL</label>
                        <input type="text" class="form-control" name="sns_url" id="sns_url">
                    </div>

                    <div class="form-group">
                        <label>Tag</label>
                        <textarea class="form-control" name="comment" id="comment" rows="4"></textarea>
                    </div>

                    <input type="submit" name="send" value="Submit" class="btn btn-dark btn-block">
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
