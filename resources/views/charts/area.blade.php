@extends('layouts.main')

@section('content')
    <div id="poll_div"></div>
    {{--// With Lava class alias--}}
    {{--Lava::render('BarChart', 'Food Poll', 'poll_div');--}}

    {{--// With Blade Templates--}}
    {{--@barchart('Food Poll', 'poll_div')--}}

    {!! $lava->render('ColumnChart', 'Finances', 'poll_div') !!}

@endsection