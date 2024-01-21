@extends('layouts.panel')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="table-container">
                    <div class="table__header">
                        <span>Content</span>
                    </div>
                    <form method="post" action="{{route('content_')}}"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="table-responsive scrollbar">
                            <table class="table  fs--1 mb-0 mt-4">
                                <tbody class="tbody">


                                <tr>
                                    <td><b>Macros</b></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>__name__</td>
                                    <td>User name</td>
                                </tr>
                                <tr>
                                    <td>__lastname__</td>
                                    <td>User last name</td>
                                </tr>
                                <tr>
                                    <td>__username__</td>
                                    <td>Telegram username</td>
                                </tr>
                                <tr>
                                    <td>__wallet__</td>
                                    <td>Personal wallet</td>
                                </tr>
                                <tr>
                                    <td>__referral_link__</td>
                                    <td>Personal referral link</td>
                                </tr>
                                <tr>
                                    <td>__referral_count__</td>
                                    <td>Personal count of referral users</td>
                                </tr>
                                <tr>
                                    <td>__referral_count_without_wallet__</td>
                                    <td>Personal count of referral users without wallet</td>
                                </tr>
                                <tr>
                                    <td>__referral_count_only_captcha__</td>
                                    <td>Personal count of referral users with only captcha</td>
                                </tr>
                                <tr>
                                    <td>__referral_top__</td>
                                    <td>Top 10 referral users</td>
                                </tr>
                                <tr>
                                    <td>__referral_position__</td>
                                    <td>Personal position in top</td>
                                </tr>
                                <tr>
                                    <td>__referral_need__</td>
                                    <td>How many referrals are needed for enter to top</td>
                                </tr>
                                <tr>
                                    <td>__user_points__</td>
                                    <td>User's points total</td>
                                </tr>
                                <tr>
                                    <td>__user_points_in_season__</td>
                                    <td>User's total points this season</td>
                                </tr>

                                @foreach($macro as $k => $v)
                                    <tr>
                                        <td>{{$k}}</td>
                                        <td>
                                            <textarea class="form-control" rows="6" name="macro[{{$k}}]">{{$v}}</textarea>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

                            <button type="submit" class="btn btn-primary mt-4">Save</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
