@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                
                <div class="card-body">
                    <h5 class="card-title">いいねしたユーザー</h5>
                </div>
                
                @if($post->users()->exists())
                    <div class="card-body">
                        いいね数：{{ $post->users()->count() }}
                    </div>
                
                    <ul class="list-group list-group-flush">
                        @foreach ($post->users as $user)
                            <li class="list-group-item">{{ $user->name }}</li>
                        @endforeach
                    </ul>
                @else
                    <div class="card-body">
                        いいね数：０
                    </div>
                @endif
                
                <div class="card-body">
                    <a href="/posts/{{ $post->id }}" class="card-link">戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection