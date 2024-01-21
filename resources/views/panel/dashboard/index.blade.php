@extends('layouts.panel')

@section('content')
    <div class="container-fluid">
        <div class="row row-cols-2 g-2">

            <div class="col pr-1">
                <div class="table-container h-100">
                    <dashboard-stats-component></dashboard-stats-component>
                </div>
            </div>

{{--            <div class="col pl-1">--}}
{{--                <div class="table-container">--}}
{{--                    <user-languages-chart-component></user-languages-chart-component>--}}
{{--                </div>--}}
{{--            </div>--}}

        </div>

{{--        <div class="row mt-2">--}}
{{--            <div class="col">--}}
{{--                <div class="table-container">--}}
{{--                    <user-growth-chart-component></user-growth-chart-component>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="row mt-2">--}}
{{--            <div class="col">--}}
{{--                <div class="table-container">--}}
{{--                    <game-launch-chart-component></game-launch-chart-component>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

    </div>
@endsection
