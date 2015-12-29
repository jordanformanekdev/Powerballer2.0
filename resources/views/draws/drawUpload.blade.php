@extends('layouts.app')

@section('content')

    <div>
        @if (count($draws) > 0)
            You may update file
        @else
            You may upload a file
        @endif
    </div>

@endsection