@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Search Tag</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="{{ route('post.index') }}">
                        <button type="button" class="btn btn-dark btn-block">Tap to Top</button>
                    </a>

                    <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">店名</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                        <tr>
                        <th>{{ $post->store_name }}</th>
                        <td>
                            @if(!empty($post->store_url))
                            <a href="{{ $post->store_url }}" target="blank">HP</a>
                            @endif
                        </td>
                        <td>
                            @if(!empty($post->sns_url))
                            <a href="{{ $post->sns_url }}" target="blank">Instagram</a>
                            @endif
                        </td>
                        <td><a href="{{ route('post.show', ['post' => $post->id]) }}">Show more</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
