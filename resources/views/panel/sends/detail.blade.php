@extends('layouts.panel')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="table-container">
                    <div class="info__header">
                        <span>Detail of the send</span>
                    </div>

                    <form method="post" action="{{route('sends.detail_', $send->id)}}"
                          id="send-add" enctype="multipart/form-data">

                        @csrf

                        <div class="table-responsive scrollbar">
                            <table class="table table-bordered fs--1 mb-0 mt-4">
                                <thead class="thead">
                                <tr>
                                    <th>Name</th>
                                    <th>Options</th>
                                </tr>
                                </thead>
                                <tbody class="tbody">
                                <tr>
                                    <td><label for="caption" class="form-label">Caption</label></td>
                                    <td><input type="text" class="form-control" name="caption" id="caption"
                                               value="{{$send->caption}}" required></td>
                                </tr>
                                <tr>
                                    <td><label class="form-check-label" for="flexCheckDefault">
                                            Is active
                                        </label>
                                    </td>
                                    <td><input class="form-check-input"
                                               type="checkbox"
                                               value="1"
                                               id="is_active"
                                               name="is_active"
                                            {{$send->is_active?'checked':null}}>
                                        <a href="{{route('sends.stop', $send->id)}}" class="btn btn-danger">Stop
                                            mailing</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="" class="form-label">Created at</label></td>
                                    <td><input type="text" class="form-control"
                                               value="{{$send->created_at->format('H:i d.m.Y')}}"
                                               readonly></td>
                                </tr>
                                <tr>
                                    <td><label for="" class="form-label">Created at</label></td>
                                    <td><input type="text" class="form-control"
                                               value="{{$send->created_at->format('H:i d.m.Y')}}"
                                               readonly></td>
                                </tr>
                                <tr>
                                    <td><label for="publish_at_d" class="form-label">Publish date(UTC)</label></td>
                                    <td><input type="date" class="form-control" name="publish_at_d" id="publish_at_d"
                                               value="{{$send->publish_at ? $send->publish_at->format('Y-m-d'): null}}"
                                               required></td>
                                </tr>
                                <tr>
                                    <td><label for="publish_at_t" class="form-label">Publish time(UTC)</label></td>
                                    <td><input type="time" class="form-control" name="publish_at_t" id="publish_at_t"
                                               value="{{$send->publish_at ? $send->publish_at->format('H:i'): null}}"
                                               required></td>
                                </tr>
                                <tr>
                                    <td><b>Recipients</b></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="recipients"
                                                   value="all"
                                                   id="recipients_all"
                                                {{$send->recipients['type']=='all'?' checked':null}}
                                            >
                                            <label class="form-check-label" for="recipients_all">
                                                All users
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        Count: {{$count_users}}
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>


                        @include('units.edit', [
                            'units' => $send->units_()
                        ])

                        @if ($send->is_publish == 0)
                            <button type="submit" class="btn btn-primary">Save send</button>
                        @endif

                    </form>

                    <div class="mt-5">
                        <a href="{{route('sends.delete_messages', $send->id)}}" class="btn btn-danger">
                            Remove all messages!
                        </a>
                        <small>Delete sent messages </small>
                    </div>

                </div>


            </div>
        </div>
    </div>
@endsection
