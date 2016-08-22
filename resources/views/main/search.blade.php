@extends('layouts.main')
@section('content')

    <div class="row text-center" id="central">
        <div class="col-md-offset-4 col-md-4 centro">
            <form class="" role="search" action="/disorders/search">
                <img  class="google" src="/assets/img/RarasWeb.png" width="400">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Nome da desordem ou Orphanumber"
                           name="search" autofocus>
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection