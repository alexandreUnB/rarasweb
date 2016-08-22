@extends('layouts.admin')

@section('content')

    @include('layouts.alerts')

    <h3 class="page-header">Adicionar Papel</h3>

    <form action="/admin/roles/store" method="post">

        {{csrf_field()}}

        <div class="row">
            <div class="form-group col-xs-4">
                <label for="label">Descrição do Papel</label>
                <input type="text" name="label" class="form-control" value="{{old('label')}}"
                       autofocus required minlength="5" maxlength="45">
            </div>

            <div class="form-group col-xs-4">
                <label for="name">Slug do Papel</label>
                <input type="text" name="name" class="form-control" value="{{old('name')}}"
                       required minlength="3" maxlength="5">
            </div>

            <div class="form-group col-xs-4">
                <label for="disorderSpecialties">Permissões do Papel</label>
                <div class="panel panel-default panel-body fixed-panel">
                    @foreach($permissions as $permission)
                        {{$checked = ""}}

                        @if(old('permissions'))
                            @foreach(old('permissions') as $rolePermission)
                                @if($permision->id == $rolePermission)
                                    <span class="hide">{{$checked = "checked"}}</span>
                                    @break
                                @endif
                            @endforeach
                        @endif

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
                <a href="/admin/roles" class="btn btn-default">Voltar</a>
            </div>
        </div>
    </form>

@endsection