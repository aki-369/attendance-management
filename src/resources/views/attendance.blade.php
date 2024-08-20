@extends('layouts.app')

@section('title', 'Attendance')

@section('css')
<link rel="stylesheet" href="{{asset('css/attendance.css')}}" />
@endsection

@section('content')
<div class="container">
    @php
        // データの存在する日付を取得してソート
        $datesWithDataSorted = $datesWithData->sort()->values();

        // 現在表示している日付のインデックスを取得
        $currentIndex = $datesWithDataSorted->search($date);
    
        // 前日と翌日の日付を取得
        $prevDate = $currentIndex > 0 ? $datesWithDataSorted[$currentIndex - 1] : null;
        $nextDate = $currentIndex < $datesWithDataSorted->count() - 1 ? $datesWithDataSorted[$currentIndex + 1] : null;
    @endphp

    <div class="attendance__date">
        <div class="attendance__date-nav">
            @if (($prevDate)) 
                <a href="{{ url()->current() }}?date={{ $prevDate }}">＜</a>
            @endif
        </div>
        <h2 class="attendance__date-text">{{ $date }}</h2>
        <div class="attendance__date-nav">
            @if ($nextDate)
                <a href="{{ url()->current() }}?date={{ $nextDate }}">＞</a>
            @endif
        </div>
    </div>

    <table class="attendance__table">
        <thead class="table__header">
            <tr class="table__row">
                <th class="table__header-item">名前</th>
                <th class="table__header-item">勤務開始</th>
                <th class="table__header-item">勤務終了</th>
                <th class="table__header-item">休憩時間</th>
                <th class="table__header-item">勤務時間</th>
            </tr>
        </thead>
        <tbody  class="table__body">
            @foreach ($attendances as $attendance)
            <tr class="table__row">
                <td class="table__body-item">{{ $attendance->user->name }}</td>
                <td class="table__body-item">{{ date('H:i:s', strtotime($attendance->clock_in)) }}</td>
                <td class="table__body-item">{{ date('H:i:s', strtotime($attendance->clock_out)) }}</td>
                <td class="table__body-item">
                    @if($attendance->breaks->count() > 0)
                        {{ $attendance->breaks->first()->total_break_duration }}
                    @else
                        -
                    @endif
                </td>
                <td class="table__body-item">{{ $attendance->work_duration }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- ページネーションリンク -->
    <div class="pagination">
        {{ $attendances->appends(['date' => $date])->links() }}
    </div>
</div>
@endsection
