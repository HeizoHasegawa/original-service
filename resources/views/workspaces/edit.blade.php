@extends('layouts.app')

@section('content')
    <div class="text-center mb-4">
        <h1>予約変更・取り消し</h1>
        利用場所、利用日を変更する場合は「予約取り消し」した後に、新規で予約してください。
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3">

            <table class="table borderless">
                <tbody>
                    <tr>
                        <td>利用場所</td>
                        <td>{{ $workspace->workspace_name }}</td>
                    </tr>
                    <tr>
                        <td>利用日</td>
                        <td>{{ $date }}</td>
                    </tr>
                    <tr>
                        <td>利用人数</td>
                        <td>
                            {!! Form::open(['route' => ['reserve.update', $workspace->id, $date]]) !!}
                                <div class="form-group">
                                    {!! Form::select('headcount', ['1','2','3','4','5','6','7','8','9','10以上'],$headcount,[]) !!}人
                                </div>
                        </td>
                    </tr>
                    <tr>
                        <td>利用料金</td>
                        <td>{{ $workspace->charge }}円</td>
                    </tr>
                </tbody>                
            </table>
                <div class="text-center">
                        {!! Form::submit('予約変更', ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}
            
                    {{-- 戻るボタン --}}
                    <a href='{{ route("workspaces.show", [$workspace->id]) }}' class='btn btn-secondary'>戻る</a>
                    {{-- 予約取り消しボタン --}}
                    {!! Form::open(['route' => ['reserve.destroy', $workspace->id, $date], 'method' => 'delete']) !!}
                        {!! Form::submit('予約取り消し', ['class' => 'btn btn-danger mt-4']) !!}
                    {!! Form::close() !!}
                </div>

        </div>
    </div>
@endsection