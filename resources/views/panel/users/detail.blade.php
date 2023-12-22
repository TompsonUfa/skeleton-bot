@extends('layouts.panel') @section('content')
    <div class="container-fluid">
        <div class="table-container">
            <div class="row">
                <div class="col-12 h-title">Users detail</div>
            </div>
            <div class="table-responsive scrollbar">
                <table class="table table-bordered fs--1 mb-0 mt-4">
                    <tbody class="tbody">
                    <tr>
                        <td><label for="tid" class="form-label">Telegram id</label></td>
                        <td>
                            <input
                                    type="text"
                                    value="{{$user->tid}}"
                                    class="form-control"
                                    id="tid"
                                    readonly
                            />
                        </td>
                    </tr>
                    <tr>
                        <td><label for="username" class="form-label">Username</label></td>
                        <td>
                            <input
                                    type="text"
                                    value="{{$user->username}}"
                                    class="form-control"
                                    id="username"
                                    readonly
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="first_name" class="form-label">First name</label>
                        </td>
                        <td>
                            <input
                                    type="text"
                                    value="{{$user->first_name}}"
                                    class="form-control"
                                    id="first_name"
                                    readonly
                            />
                        </td>
                    </tr>
                    <tr>
                        <td><label for="last_name" class="form-label">Last name</label></td>
                        <td>
                            <input
                                    type="text"
                                    value="{{$user->last_name ?? ''}}"
                                    class="form-control"
                                    id="last_name"
                                    readonly
                            />
                        </td>
                    </tr>


                    <tr>
                        <td><label for="ref_count" class="form-label">Total number of referrals</label></td>
                        <td>
                            <input
                                    type="text"
                                    value="{{$totalReferralCount}}"
                                    class="form-control"
                                    id="ref_count"
                                    readonly
                            />
                        </td>
                    </tr>

                    <tr>
                        <td><label for="ref_count" class="form-label">Number of referrals this season</label></td>
                        <td>
                            <input
                                type="text"
                                value="{{$seasonReferralCount}}"
                                class="form-control"
                                id="ref_count"
                                readonly
                            />
                        </td>
                    </tr>

                    <tr>
                        <td><label for="points_count" class="form-label">Total points</label></td>
                        <td>
                            <input
                                type="text"
                                value="{{$totalPoints}}"
                                class="form-control"
                                id="points_count"
                                readonly
                            />
                        </td>
                    </tr>

                    <tr>
                        <td><label for="season_points_count" class="form-label">Points this season</label></td>
                        <td>
                            <input
                                type="text"
                                value="{{$seasonPoints}}"
                                class="form-control"
                                id="season_points_count"
                                readonly
                            />
                        </td>
                    </tr>

                    <tr>
                        <td><a href="{{route('users.game_stats', $user->id)}}">Game stats</a></td>
                        <td></td>
                    </tr>


                    </tbody>
                </table>


                <br>

                @if($user->is_banned == 1)
                    <a class="btn btn-custom-info"
                       href="{{route('users.unban', $user->id)}}">Unban user</a>
                @else
                    <a class="btn btn-custom-info"
                       href="{{route('users.ban', $user->id)}}">Ban user</a>
                @endif



            </div>
        </div>

        <a class="btn btn-success btn-custom my-3" href="{{ route('users.referrals', $user->id) }}">View referrals</a>

    </div>
@endsection
