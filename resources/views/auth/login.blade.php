@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-5 col-xs-offset-3">
                <div class="panel panel-primary panel-login">
                    <div class="panel-heading text-center"><h4><strong>Login</strong></h4></div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                            {!! csrf_field() !!}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                {{--<label class="col-xs-4 control-label"></label>--}}

                                <div class="col-xs-8 col-xs-offset-2">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                           placeholder="E-Mail" minlength="8" maxlength="40">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                {{--<label class="col-xs-4 control-label"></label>--}}

                                <div class="col-xs-8 col-xs-offset-2">
                                    <input type="password" class="form-control" name="password" placeholder="Password">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-sign-in"></i> Login
                                    </button>

                                </div>

                            </div>
                            <div class="row">

                                <div class="checkbox col-xs-6">
                                    <label>
                                        <input type="checkbox" name="remember"> Lembrar
                                    </label>
                                </div>

                                <div class="col-xs-6 text-right">
                                    <a class="btn btn-link" href="{{ url('/password/reset') }}">Esqueceu a senha ?</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
