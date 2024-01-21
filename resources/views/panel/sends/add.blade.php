@extends('layouts.panel')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="table-container">
                    <div class="info__header">
                        <span>Add send</span>
                    </div>
                    <form method="post" action="{{ route('sends.add_') }}"
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
                                    <td><input type="text" class="form-control" name="caption" id="caption" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label class="form-check-label" for="flexCheckDefault">
                                            Is active
                                        </label></td>
                                    <td><input class="form-check-input"
                                               type="checkbox"
                                               value="1"
                                               id="is_active"
                                               name="is_active"
                                        ></td>
                                </tr>
                                <tr>
                                    <td><label for="publish_at" class="form-label">Publish date(UTC)</label></td>
                                    <td><input type="date" class="form-control" name="publish_at_d" id="publish_at_d"
                                               required></td>
                                </tr>
                                <tr>
                                    <td><label for="publish_at_t" class="form-label">Publish time(UTC)</label></td>
                                    <td><input type="time" class="form-control" name="publish_at_t" id="publish_at_t"
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
                                                   id="recipients_all" checked>
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


                        @include('units.add')
                        <button type="submit" class="btn btn-custom btn-primary">Add send</button>

                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
