@extends('layouts.app')

@section('title', 'Stamp')

@section('css')
<link rel="stylesheet" href="{{asset('css/index.css')}}" />
@endsection

@section('content')
<div class="container">
    <div class="message">
        @if(session('status'))
            <p class="message-text">{{Auth::user()->name . '、' . session('status')}}</p>
        @endif
    </div>
    <div class="attendance-item">
        <form action="{{ route('clockIn') }}" method="post">
            @csrf
            <div class="clock-in">
                <button class="{{ $attendance && !$attendance->clock_out ? 'disabled' : 'clock-in__button'}}" 
                {{ $attendance && !$attendance->clock_out ? 'disabled' : '' }}>
                勤務開始
                </button>
                <!-- 
                $attendance が存在し、かつ $attendance->clock_out が未記録 (null) の場合は、'disabled' クラスを適用し、ボタンを無効にします。それ以外の場合は 'clock-in__button' クラスを適用し、ボタンを有効にします。
                -->
            </div>
        </form>
        <form action="{{ route('clockOut') }}" method="post">
            @csrf
            <div class="clock-out">
                <button class="{{ !$attendance || !$attendance->clock_in || $attendance->clock_out ? 'disabled' : 'clock-out__button'}}" 
                {{ !$attendance || !$attendance->clock_in || $attendance->clock_out ? 'disabled' : '' }}>
                勤務終了
                </button>
                <!--
                $attendance が存在しない、または $attendance->clock_in が未記録 (null)、または $attendance->clock_out が記録済み (null でない) の場合は'disabled' クラスを適用し、ボタンを無効にします。それ以外の場合は 'clock-out__button' クラスを適用し、ボタンを有効にします。
                -->
            </div>
        </form>    
    </div>
    <div class="break-item">
        <form action="{{ route('breakStart') }}" method="post">
            @csrf
            <div class="break-start">
                <button class="{{ !$attendance || !$attendance->clock_in || $attendance->clock_out || ($break && !$break->break_end) ? 'disabled' : 'break-start__button' }} " 
                {{ !$attendance || !$attendance->clock_in || $attendance->clock_out || ($break && !$break->break_end)  ? 'disabled' : '' }}>休憩開始</button>
                <!--
                $attendance が存在しない、または $attendance->clock_in が未記録 (null)、または $attendance->clock_out が記録済み (null でない)、
                または $break が存在し、かつ $break->break_end が未記録 (null) の場合は、'disabled' クラスを適用し、ボタンを無効にします。それ以外の場合は 'break-start__button' クラスを適用し、ボタンを有効にします。
                -->
            </div>
        </form>
        <form action="{{ route('breakEnd') }}" method="post">
            @csrf
            <div class="break-end">
                <button class="{{ !$break || !$break->break_start || $break->break_end ? 'disabled' : 'break-end__button' }}" 
                {{ !$break || !$break->break_start || $break->break_end ? 'disabled' : '' }}>休憩終了</button>
                <!--
                $break が存在しない、または$break が存在しても break_start が未記録(null)、$break が存在して break_start が記録されていても、break_end が既に記録されている場合は、'disabled' クラスを適用し、ボタンを無効にします。それ以外の場合は 'break-end__button' クラスを適用し、ボタンを有効にします。
                -->
            </div>
        </form>
    </div>
</div>
@endsection
