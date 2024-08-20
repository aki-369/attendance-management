<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atte - @yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/common.css')}}"/>
    @yield('css')
</head>
<body>
    <header>
        <div class="header__inner">
            <div class="header__logo">
                <a href="" class="header__logo">
                    Atte
                </a>
            </div>
            @if(Auth::check())
                <div class="header__nav">
                    <a href="/" class="header__nav-item">ホーム</a>
                    <a href="attendance" class="header__nav-item">日付一覧</a>
                    <form action="/logout" method="post">
                    @csrf
                        <button class="header__nav-item logout">ログアウト</button>
                    </form>
                </div>
            @endif
        </div>
    </header>
    <main>
        @yield('content')
    </main>
    <footer class="footer__inner">
        <p class="footer__logo">
            Atte,inc.
        </p>
    </footer>
</body>
</html>