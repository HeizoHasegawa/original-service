@extends('layouts.app')

@section('content')
    @if (Auth::check())
        <h2 class="pl-4 bg-info text-white">予約済み一覧</h2>
        @if($workspace_res->isEmpty())
            本日以降で予約されたワークスペースはありません。
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>ワークスペース名</th><th>住所</th><th>予約日</th><th></th>
                    </tr>
                </thead>
                <tbody>
                    {{-- 予約一覧を表示 --}}
                    @foreach($workspace_res as $res)
                        <tr>
                            <td>{{ $res->workspace_name }}</td>
                            <td>{{ $res->address }}</td>
                            <td>{{ $res->date }}</td>
                            <td><a href="{{ route('workspaces.show', [$res->workspace_id]) }}" class="nav-link">詳細へ</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $workspace_res->links() }}
        @endif

        <h2 class="mt-5 pl-4 bg-info text-white">お気に入り一覧</h2>
        @if($favorites->isEmpty())
            お気に入り登録されたワークスペースはありません。
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>ワークスペース名</th><th>住所</th><th></th>
                    </tr>
                </thead>
                <tbody>
                    {{-- ワークスペース一覧を表示 --}}
                    @foreach($favorites as $workspace)
                        <tr>
                            <td>{{ $workspace->workspace_name }}</td>
                            <td>{{ $workspace->address }}</td>
                            <td><a href="{{ route('workspaces.show', [$workspace->workspace_id]) }}" class="nav-link">詳細へ</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $favorites->links() }}
        @endif
    @else
        <div class="text-center">
            <img src="{{ $image_url }}" class="img-fluid" alt="会社ロゴ" />
            <h3>WorkspaceRservations</h3>
            快適なワークスペースを提供します。
        </div>
    @endif


    <h2 class="mt-5 pl-4 bg-info text-white">ワークスペース一覧</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ワークスペース名</th><th>住所</th><th></th>
            </tr>
        </thead>
        <tbody>
            {{-- ワークスペース一覧を表示 --}}
            @foreach($workspaces as $workspace)
                <tr>
                    <td>{{ $workspace->workspace_name }}</td>
                    <td>{{ $workspace->address }}</td>
                    <td><a href="{{ route('workspaces.show', [$workspace->id]) }}" class="nav-link">詳細へ</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- ページネーションのリンク --}}
    {{ $workspaces->links() }}
@endsection