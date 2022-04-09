@extends('layouts.app')

@section('content')
    @if (Auth::check())
        <h2>お気に入りワークスペース一覧</h2>
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
                        <td><a href="{{ route('workspaces.show', [$workspace->id]) }}" class="nav-link">詳細へ</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <h2>ワークスペース一覧</h2>
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