<header class="mb-4">
    <nav class="navbar navbar-expand-sm navbar-dark bg-primary">
        {{-- トップページへのリンク --}}
        <a class="navbar-brand" href="/">WorkspaceReservations</a>

        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
                @if (Auth::check())
                    {{-- ログアウトへのリンク --}}
                    <li class="nav-item"><a href="{{ route('logout.get', []) }}" class="nav-link">ログアウト</a></li>
                @else
                    {{-- 会員登録ページへのリンク --}}
                    <li class="nav-item"><a href="{{ route('signup.get', []) }}" class="nav-link">会員登録</a></li>
                    {{-- ログインページへのリンク --}}
                    <li class="nav-item"><a href="{{ route('login.get', []) }}" class="nav-link">ログイン</a></li>
                @endif
            </ul>
        </div>
    </nav>
</header>