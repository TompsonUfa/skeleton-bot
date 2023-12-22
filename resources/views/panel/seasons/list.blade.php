@extends('layouts.panel')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="table-container">
                    <div class="table__header">
                        <div class="row">
                            <div class="col-12 mb-3 h-title">Seasons</div>
                        </div>
                        <div class="row">
                            <div class="col-12 ">
                            <a class="btn btn-success btn-custom mb-2" href="{{route('seasons.add')}}">+ Add</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive scrollbar">
                        <table class="table table-bordered fs--1 mb-0 mt-3">
                            <thead class="thead">
                                <tr>
                                    <th>#</th>
                                    <th>Caption</th>
                                    <th>Is active</th>
                                    <th>Start at</th>
                                    <th>Stop at</th>
                                    <th>Stop at(info)</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                @foreach($seasons as $season)
                                    <tr>
                                        <td>
                                            {{$loop->index + 1}}
                                        </td>
                                        <td>
                                            {{$season->caption}}
                                        </td>
                                        <td>
                                            {{$season->is_active ? 'Active' : ''}}
                                        </td>
                                        <td>
                                            {{$season->start_at ? $season->start_at->format('H:i d.m.Y'): null}}
                                        </td>
                                        <td>
                                            {{$season->stop_at ? $season->stop_at->format('H:i d.m.Y'):null}}
                                        </td>
                                        <td>
                                            {{$season->stop_at_info ? $season->stop_at_info->format('d.m.Y'):null}}
                                        </td>
                                        <td class="text-right">
                                            <a href="{{route('seasons.active', $season->id)}}" class="btn btn-custom-info">
                                                Set Active
                                            </a>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{route('seasons.detail', $season->id)}}" class="btn btn-custom-info">
                                                Edit
                                            </a>
                                        </td>
                                        <td class="text-right">
                                            @if (!empty($season->export_path))
                                            <a href="{{route('seasons.export', $season->id)}}" class="btn btn-custom-info">
                                                Export
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
