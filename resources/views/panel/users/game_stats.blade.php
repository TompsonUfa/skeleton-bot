@extends('layouts.panel') @section('content')
    <div class="container-fluid">
        <div class="table-container">
            <div class="row">
                <div class="col-12 h-title">Game stats</div>
            </div>
            <div class="table-responsive scrollbar">

                @foreach($data as $item)
                    <user-game-stat-component
                        data="{{$item}}"
                    ></user-game-stat-component>
                @endforeach

            </div>
        </div>
    </div>
@endsection

