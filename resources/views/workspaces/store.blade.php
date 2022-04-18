@extends('layouts.app')

@section('content')
    <div class="text-center">
        <h1>ワークスペー用画像アップロード</h1>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            {!! Form::open(['url' => '/upload', 'method' => 'post', 'class' => 'form', 'files' => true]) !!}
                <div class="form-group">
                    {!! Form::label('myfile', 'ファイル名') !!}
                    {!! Form::file('myfile', null) !!}
                </div>

                <div class="text-center">
                    {!! Form::submit('アップロード', ['class' => 'btn btn-primary']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection