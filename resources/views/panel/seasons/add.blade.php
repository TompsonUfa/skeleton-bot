@extends('layouts.panel')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="table-container">
                    <div class="table__header">
                        <span>Add season</span>
                    </div>
                    <form method="post" action="{{ route('seasons.add_') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="d-flex mt-3">
                            <div class="w-50 pr-2">
                                <label for="caption" class="form-label">Caption</label>
                                <input type="text" class="form-control" name="caption" id="caption" required>
                            </div>
                        </div>

                        <div class="d-flex mt-3">
                            <div class="w-50 pr-2">
                                <label for="stop_at_info" class="form-label">Stop at(info)</label>
                                <input type="date" class="form-control" name="stop_at_info" id="stop_at_info" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-4">Add season</button>

                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
