@extends('layouts.app')

@section('title', 'Register')

@section('css')
<link rel="stylesheet" href="{{asset('css/register.css')}}" />
@endsection

@section('content')
<div class="container">
    <div class="register-form">
        <div class="form__heading">
            <h1 class="form__heading-title">会員登録</h1>
        </div>
        <div class="form__content">
            <form action="/register" method="post">
                @csrf
                <div class="form__item">
                    <input type="text" name="name" placeholder="名前" value="{{old('name')}}">
                    @error('name')
                        <p class="error-message">{{$message}}</p>
                    @enderror
                </div>
                <div class="form__item">
                    <input type="email" name="email" placeholder="メールアドレス" value="{{old('email')}}">
                    @if($errors->has('email'))
                        @foreach($errors->get('email') as $error)
                            @error('email')
                                <p class="error-message">{{$message}}</p>
                            @enderror
                        @endforeach
                    @endif
                </div>
                <div class="form__item">
                    <input type="password" name="password" placeholder="パスワード">
                        @if($errors->has('password'))
                            @foreach($errors->get('password') as $error)
                                @error('password')
                                    <p class="error-message">{{$message}}</p>
                                @enderror
                            @endforeach
                        @endif
                </div>
                <div class="form__item">
                    <input type="password" name="password_confirmation" placeholder="確認用パスワード">
                        @error('password_confirmation')
                            <p class="error-message">{{$message}}</p>
                        @enderror
                </div>
                <div class="form__button">
                    <button class="form__button-submit" type="submit">会員登録</button>
                </div>
            </form>
            <div class="login__link">
                <p class="login__link-text">アカウントをお持ちの方はこちら</p>
                <a href="login" class="login__link-url">ログイン</a>
            </div>
        </div>
    </div>
</div>
@endsection
