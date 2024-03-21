@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">
        @include('conversations.users', ['users' => $users, 'unread' => $unread  ])
        <div class="col-md-9">
            <div class="card">

                <div class="card-header"> 
                    @if($user->picture)
                         <img src="{{ asset('storage/' .$user->picture) }}" alt="" class="mr-3 mt-3 rounded-circle" style="width:80px; height:auto;">
       @endif
                 <b>{{ $user->name }}</b>
                </div>
                <div class="card-body conversations">
                @if($messages->hasMorePages())
                    <div class="text-center">
                        <a href="{{ $messages->nextPageUrl() }}" class="btn btn-light">
                            Voir les messages precedents
                        </a>
                    </div>
                @endif

                @foreach (array_reverse($messages->items()) as $message)
                    <div class="row">
                        <div class="col-md-10 {{ $message->from->id !== $user->id ? 'offset-md-2 text-right' : '' }}">

                            <p>
                                <strong>{{ $message->from->id !== $user->id ? 'Moi' : $message->from->name }}</strong><br>
                                {!! nl2br(e($message->content)) !!}
                            </p>

                        </div>
                    </div>
                    <hr>
                @endforeach

                    <form action="" method="post">
                        {{ csrf_field() }}
                        <div class="form-group ">
                            <textarea name="content" class="form-control {{ $errors->has('content') ? 'is-invalid' : ' ' }}" placeholder="entrez le message ici"></textarea>
                            @if ($errors->has('content'))
                            <div class="invalid-feedback">{{ implode(',', $errors->get('content')) }}</div>
                            @endif
                        </div>
                        <button class="btn btn-primary" type="submit">Envoyer</button>
                    </form>
                </div>
            </div>
    </div>

</div>

</div>

@endsection

