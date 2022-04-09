@extends('layouts.app')

@section('content')
    <h2>{{ $workspace->workspace_name }}</h2>
    
    @if (Auth::check())
        @if (Auth::user()->is_favorite($workspace->id))
            {{-- お気に入り解除ボタンのフォーム --}}
            {!! Form::open(['route' => ['workspace.unfavorite', $workspace->id], 'method' => 'delete']) !!}
                {!! Form::submit('お気に入りを解除', ['class' => "btn btn-danger"]) !!}
            {!! Form::close() !!}
        @else
            {{-- お気に入り解除ボタンのフォーム --}}
            {!! Form::open(['route' => ['workspace.favorite', $workspace->id]]) !!}
                {!! Form::submit('お気に入りに登録', ['class' => "btn btn-primary"]) !!}
            {!! Form::close() !!}
        @endif
    @endif
    
    <img src="http://static.techacademy.jp/magazine/wp-content/themes/ta-magazine/images/logo-magazine.png" alt="ワークスペース写真">
    <div>
        {{ $workspace->comment }}
    </div>

    <h4>予約状況</h4>
    予約したい日付をクリックしてください。<br>
    <br>カレンダー<br>
    {{!! $workspace->calendar() !!}}

    <h4>料金</h4>
    <div>
        {{ $workspace->charge }}円／日（利用時間に関わらず）
    </div>
    
    <h4>設備</h4>
    <div>
        @foreach($workspace->facilities as $facility)
            <i class='{{ $facility->logo }} fa-2x'></i> {{ $facility->facility_name }}<br>
        @endforeach
    </div>
    
    <h4>利用可能時間</h4>
    <div>
        月～金　{{ $workspace->start_weekday }}～{{ $workspace->end_weekday }}
    </div>
    <div>
        土日　　{{ $workspace->start_weekend }}～{{ $workspace->end_weekend }}
    </div>
    
    <h4>アクセス</h4>
    <div>
        {{ $workspace->address }}
    </div>
        <script defer src="https://use.fontawesome.com/releases/v6.1.1/js/all.js"></script>
    
@endsection
