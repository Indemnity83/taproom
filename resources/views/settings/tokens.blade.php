@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Personal Settings</div>

                    <div class="list-group">
                        <a href="{{ route('settings.tokens') }}" class="list-group-item active">
                            Personal access tokens
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <h2>
                    <span>Personal access tokens</span>
                    <button class='btn btn-default pull-right disabled'>Generate new token</button>
                </h2>
                <hr/>

                <p>Tokens you have generated that can be used to access the Taproom API.</p>
                <ul class="list-group">
                    @foreach($tokens as $token)
                        <li class="list-group-item clearfix">
                            <span>{{ $token['description'] }}</span>

                            <span class="pull-right">
                                <small>created {{ $token['created_at']->diffForHumans() }}&nbsp;</small>
                                <div class="btn-group btn-group-xs" role="group">
                                    <button type="button" class="btn btn-default disabled">Edit</button>
                                    <button type="button" class="btn btn-danger disabled">Delete</button>
                                </div>
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@stop