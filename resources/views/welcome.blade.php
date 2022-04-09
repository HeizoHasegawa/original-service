@extends('layouts.app')

@section('content')
    @if (Auth::check())
        ようこそ！！　{{ Auth::user() -> name }}さん
    @else
        <div class="center jumbotron">
            <div class="text-center">
                <h1>WorkspaceReservations</h1>
            </div>
        </div>
        快適に働ける空間を提供します。
    @endif
    @include('workspaces.index')
@endsection
