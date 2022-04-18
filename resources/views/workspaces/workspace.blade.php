@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="mb-2 mr-4">
            <h2>{{ $workspace->workspace_name }}</h2>
        </div>
        <div>
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
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mt-2">
            <img src="{{ $image_url }}" class="rounded img-fluid" alt="ワークスペース画像" width="350">
        </div>
        <div class="ml-1">
            {!! $workspace->comment !!}
        </div>
    </div>

    {{-- 予約状況表示 --}}
    <h4 class="mt-4">予約状況</h4>
    予約したい日付をクリックしてください。<br>
    (<i class='fa-regular fa-circle'></i>：予約可、
    @if(Auth::check())
        <i class="fa-regular fa-circle-check"></i>：あなたの予約日、
    @endif
    <i class="fa-solid fa-xmark"></i>：他のユーザーの予約日)<br>
    <div class="mt-3">
        {!! $workspace->calendar($workspace->id, $workspace_res, $disp_date) !!}
    </div>
    
    {{-- 料金表示 --}}
    <h4 class="mt-4">料金</h4>
    <div>
        {{ $workspace->charge }}円／日（利用時間に関わらず）
    </div>
    
    <h4 class="mt-4">設備</h4>
    <div class="row">
        @foreach($workspace->facilities as $facility)
            <div class="ml-4 text-center">
                <i class='{{ $facility->logo }} fa-2x' style="color:green;"></i> <br>{{ $facility->facility_name }}
            </div>
        @endforeach
    </div>
    
    {{-- 利用時間表示 --}}
    <h4 class="mt-4">利用可能時間</h4>
    <div>
        月～金　{{ $workspace->start_weekday }}～{{ $workspace->end_weekday }}
    </div>
    <div>
        土日　　{{ $workspace->start_weekend }}～{{ $workspace->end_weekend }}
    </div>
    
    <h4 class="mt-4">アクセス</h4>
    <div>
        {{ $workspace->address }}
    </div>
    
    <div class="text-center mt-4">
        <a href="{{ route('workspaces.index', []) }}">ワークスペース一覧へ戻る</a>
    </div>
    <script defer src="https://use.fontawesome.com/releases/v6.1.1/js/all.js"></script>
    
@endsection
