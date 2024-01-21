@extends('layouts.panel') @section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="table-container">
                    <div class="table__header">
                        <div class="row">
                            <div class="col-12 mb-2 h-title">Languages</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-0">
                            <a class="btn btn-success btn-custom" href="{{route('languages.add')}}">+ Add</a>
                        </div>
                    </div>

                    <div class="table-responsive scrollbar">
                        <table class="table table-bordered fs--1 mb-0 mt-4">
                            <thead class="thead">
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Caption</th>
                                <th>Is active</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody class="tbody">
                            @foreach($languages as $item)
                                <tr>
                                    <td>
                                        {{$loop->index + 1}}
                                    </td>
                                    <td>
                                        {{$item['code']}}
                                    </td>
                                    <td>
                                        {{$item['caption']}}
                                    </td>
                                    <td>
                                        {{$item['is_active']?'True':'False'}}
                                    </td>
                                    <td>
                                        <a
                                                class="btn btn-custom-info"
                                                href="{{route('languages.detail', $item['code'])}}"
                                        >Detail</a>
                                    </td>
                                    <td>
                                        <a
                                            class="btn btn-custom-info"
                                            href="{{route('languages.notifications', $item['code'])}}"
                                        >Notifications</a>
                                    </td>
                                    <td>

{{--                                        <a href="#" class="btn btn-outline-dark"--}}
{{--                                           onclick="event.preventDefault();--}}
{{--                                                   confirm('Remove?') ?--}}
{{--                                                   document.getElementById('delete-form-{{$item['code']}}').submit(): null; "--}}
{{--                                        >--}}
{{--                                            Remove--}}
{{--                                        </a>--}}
{{--                                        <form id="delete-form-{{$item['code']}}"--}}
{{--                                              action="{{ route('languages.delete_', $item['code']) }}" method="POST"--}}
{{--                                              class="d-none">--}}
{{--                                            @csrf--}}
{{--                                        </form>--}}
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
