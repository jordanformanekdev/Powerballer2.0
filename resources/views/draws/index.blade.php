@extends('layouts.app')


@section('content')

    @if($data)
        <div class="container-fluid" style="padding: 0px;">

            {{--Red Ball Matrix--}}
            <div class="container-fluid pull-right" style="padding: 0px;">
                @include('draws.redBallMatrix', ['redBallMatrix' => $data['redBallMatrix']])

                {{--Information related to draw--}}
                @include('draws.drawInfo', ['drawInfo' => $data['drawInfo']])
            </div>

            {{--White Ball Matrix--}}
            <div class="container-fluid pull-right" style="padding: 0px;">
                @include('draws.whiteBallMatrix', ['whiteBallMatrix' => $data['whiteBallMatrix']])
            </div>

        </div>
    @else
        we do not have a current draw
    @endif
@endsection