@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Link Device</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/link') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('token') ? ' has-error' : '' }}">
                                <label for="token" class="col-md-4 control-label">Code</label>

                                <div class="col-md-6">
                                    <input id="token" type="text" class="form-control" name="token"
                                           value="{{ old('token') }}">

                                    @if ($errors->has('token'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('token') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-link"></i> Link Device
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop