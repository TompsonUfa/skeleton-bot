@extends('layouts.panel') @section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="table-container">
                <div class="table__header">
                    <div class="row">
                        <div class="col-12 mb-2 h-title">{{ $user->username ?? $user->first_name }} user referrals</div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            Count: {{ $count }}
                        </div>
                    </div>

                    <form>
                        <div class="row g-3 align-items-center">
                            <div class="col-5">
                                <input
                                    type="text"
                                    id="se"
                                    name="se"
                                    class="form-control"
                                    placeholder="Enter username, id, first or last name."
                                    value="{{ $_GET['se'] ?? '' }}"
                                />
                            </div>
                            <div class="col-7">
                                <button type="submit" class="btn btn-custom btn-primary">
                                    Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive scrollbar">
                    <table class="table table-bordered fs--1 mb-0 mt-4">
                        <thead class="thead">
                            <tr>
                                <th>#</th>
                                <th>Referral name</th>
                                <th>Join date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            @foreach($referrals as $referral)
                            <tr>
                                <td>
                                    {{  $loop->iteration + $referrals->firstItem() - 1}}
                                </td>
                                <td>
                                    {{$referral->first_name}}
                                </td>
                                <td>
                                    {{$referral->referral_at}}
                                </td>
                                <td>
                                    <a
                                        class="btn btn-custom-info"
                                        href="{{route('users.detail', $referral->id)}}"
                                        >Detail</a
                                    >
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $referrals->withQueryString()->links() }}
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <button
                        class="btn btn-sm btn-falcon-default me-1"
                        type="button"
                        title="Previous"
                        data-list-pagination="prev"
                    >
                        <span class="fas fa-chevron-left"></span>
                    </button>
                    <ul class="pagination mb-0"></ul>
                    <button
                        class="btn btn-sm btn-falcon-default ms-1"
                        type="button"
                        title="Next"
                        data-list-pagination="next"
                    >
                        <span class="fas fa-chevron-right"> </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
