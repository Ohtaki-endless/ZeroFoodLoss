@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">いいねしたユーザー</h5>
                </div>
                
                <div class="card-body">
                    @if($post->users()->exists())
                    	いいね数：{{ $post->users()->count() }}
                    	いいねしたユーザー：
                    	@foreach ($post->users as $user)
                    	    {{ $user->name }}
                    	@endforeach
                    @else
                    	いいね数：０
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection