@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">followed</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="d-flex flex-column bd-highlight mb-3">
                        @foreach ($followed_users as $followed_user)
                        <div class="p-2 bd-highlight">{{ $followed_user->name }}</div>
                        @endforeach
                    </div>
                    


                   

                </div>
            </div>         
            
            
        </div>
    </div>
</div>
@endsection