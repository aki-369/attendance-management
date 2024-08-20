@extends('layouts.app')

@section('title', 'Login')

@section('css')
<link rel="stylesheet" href="{{asset('css/login.css')}}" />
@endsection

@section('content')
<div class="container">
    <div class="login-form">
        <div class="form__heading">
            <h1 class="form__heading-title">ログイン</h1>
        </div>
        <div class="form__content">
            <form action="/login" method="post">
                @csrf
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
                    @error('password')
                        <p class="error-message">{{$message}}</p>
                    @enderror                    
                </div>
                <div class="form__button">
                    <button class="form__button-submit" type="submit">ログイン</button>
                </div>
            </form>
            <div class="register__link">
                <p class="register__link-text">アカウントをお持ちでない方はこちら</p>
                <a href="register" class="register__link-url">会員登録</a>
            </div>            
        </div>
    </div>
</div>
@endsection
