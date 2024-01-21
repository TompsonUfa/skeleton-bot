@extends('layouts.panel')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="table-container">
                    <div class="table__header">
                        <div class="row">
                            <div class="col-12 mb-2 h-title">
                                Sends
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-0">
                                <a class="btn btn-success btn-custom" href="{{route('sends.add')}}">+ Add</a>
                            </div>
                        </div>

                    </div>
                    <div class="table-responsive scrollbar">
                        <table class="table table-bordered fs--1 mb-0 mt-4">
                            <thead class="thead">
                            <tr>
                                <th>#</th>
                                <th>Caption</th>
                                <th>Is active</th>
                                <th>Publish at(UTC)</th>
                                <th>Is sent</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody class="tbody">
                            @foreach($sends as $send)
                                <tr>
                                    <td>
                                        {{$loop->iteration}}
                                    </td>
                                    <td>
                                        {{$send->caption}}
                                    </td>
                                    <td>
                                        {{$send->is_active ? 'Active' : 'No'}}
                                    </td>
                                    <td>
                                        {{$send->publish_at->format('H:i d.m.Y')}}
                                    </td>
                                    <td>
                                        {{$send->is_publish ? 'True' : ''}}
                                    </td>
                                    <td class="text-right">
                                        <a href="{{route('sends.detail', $send->id)}}" class="btn btn-custom-info">
                                            Detail
                                        </a>
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
