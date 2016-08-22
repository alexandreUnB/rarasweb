@extends('layouts.admin')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Editando Papéis</h3>

    <form action="/admin/roles/update/{{$role->id}}" method="post">

        {{csrf_field()}}

        {{method_field('put')}}

        <div class="row">
            <div class="form-group col-xs-4">
                <label for="label">Descrição do Papel</label>
                <input type="text" name="label" class="form-control" value="{{$role->label}}"
                       autofocus required minlength="5" maxlength="45">
            </div>

            <div class="form-group col-xs-4">
                <label for="name">Slug do Papel</label>
                <input type="text" name="name" class="form-control" value="{{$role->name}}"
                       required minlength="5" maxlength="45">
            </div>

            <div class="form-group col-xs-4">
                <label for="disorderSpecialties">Permissões do Papel</label>

                {{--<div class="panel panel-default panel-body fixed-panel">--}}
                    {{--@foreach($specialties as $specialty)--}}
                        {{--{{$checked = ""}}--}}

                        {{--@forelse($disorderSpecialties as $disorderSpecialty)--}}
                            {{--@if($specialty->id == $disorderSpecialty->id)--}}
                                {{--<span class="hide">{{$checked = "checked"}}</span>--}}
                                {{--@break--}}
                            {{--@endif--}}
                        {{--@empty--}}
                        {{--@endforelse--}}

                        {{--<input type="checkbox" name="disorderSpecialties[]" value="{{$specialty->id}}" {{$checked}}>--}}
                        {{--{{$specialty->name}} - {{$specialty->cbo}}<br>--}}
                    {{--@endforeach--}}
                {{--</div>--}}

                <div class="panel panel-default panel-body fixed-panel">
                    @foreach($permissions as $permission)
                        {{$checked = ""}}
                        @forelse($permissionRoles as $permissionRole)
                                @if($permission->id == $permissionRole->id)
                                    <span class="hide">{{$checked = "checked"}}</span>
                                    @break
                                @endif
                            @empty
                        @endforelse
                        <input type="checkbox" name="permissions[]" value="{{$permission->id}}" {{$checked}}>
                        {{$permission->label}}<br>
                    @endforeach
                </div>
            </div>
        </div>

        <hr />

        <div id="actions" class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="/admin/roles " class="btn btn-default">Voltar</a>
            </div>
        </div>
    </form>

@endsection