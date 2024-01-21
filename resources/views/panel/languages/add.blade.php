@extends('layouts.panel')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="table-container">
                    <div class="info__header">
                        <span>Add language</span>
                    </div>
                    <form method="post" action="{{ route('languages.add_') }}" enctype="multipart/form-data">
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
                                    <td><label for="code" class="form-label">Code</label></td>
                                    <td><input type="text" class="form-control" name="code" id="code"
                                               required>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="caption" class="form-label">Caption</label></td>
                                    <td><input type="text" class="form-control" name="caption" id="caption"
                                               required>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>

                        <button type="submit" class="btn btn-custom btn-primary">Add</button>

                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
