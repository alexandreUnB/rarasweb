@if(Session::has('erro'))
    <div class="alert alert-danger">
        {{Session::get('erro')}}
    </div>
@elseif(Session::has('success'))
    <div class="alert alert-success">
        {{Session::get('success')}}
    </div>
@endif

@if(isset($errors) && count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Alguns campos precisam da sua atenção</strong><br>
        <ol type="1">
            @foreach($errors->all() as $error)
                <li>{{$error}} <br></li>
            @endforeach
        </ol>
    </div>
@endif