@extends('layouts.app')

@section('content')
    <div class="text-center">
        <h1>予約確認</h1>
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
                            {!! Form::open(['route' => ['reserve.store', $workspace->id, $date]]) !!}
                                <div class="form-group">
                                    {!! Form::select('headcount', ['1','2','3','4','5','6','7','8','9','10以上'],'0',[]) !!}人
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
                    {!! Form::submit('予約', ['class' => 'btn btn-primary']) !!}
                    {{-- 戻るボタン --}}
                    <a href='{{ route("workspaces.show", [$workspace->id, $disp_date]) }}' class='btn btn-secondary'>戻る</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection