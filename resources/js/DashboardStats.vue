<template>
    <div>
        <div class="spinner-border text-primary" v-if="isLoading" style="margin: 0 auto" role="status">
            <span class="sr-only"></span>
        </div>
        <h6 class="mt-1">System metric</h6>
        <table class="w-100">
            <tr>
                <td>Users(all):</td>
                <td>{{data.users_count}}</td>
            </tr>
<!--            <tr>-->
<!--                <td>Users who passed the captcha:</td>-->
<!--                <td>{{data.users_captcha_count}}</td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td>Users without captcha:</td>-->
<!--                <td>{{data.users_no_captcha_count}}</td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td>Users who subscribe captcha tg channel:</td>-->
<!--                <td>{{data.users_subscribe_captcha_count}}</td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td>Users by referral:</td>-->
<!--                <td>{{data.referral_users_count}}</td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td>Banned users:</td>-->
<!--                <td>{{data.banned_users_count}}</td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td>Users who subscribe token tg channel:</td>-->
<!--                <td>{{data.users_subscribe_token_channel_count}}</td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td>Users in the game:</td>-->
<!--                <td>{{data.game_users_count}}</td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td>Total sum of user scores in season:</td>-->
<!--                <td>{{data.total_game_scores}}</td>-->
<!--            </tr>-->
        </table>

    </div>
</template>

<script>

export default {
    data() {
        return {
            data: {
                users_count: 0,
                users_captcha_count: 0,
                users_no_captcha_count: 0,
                referral_users_count: 0,
                banned_users_count: 0,
                users_subscribe_token_channel_count: 0,
                users_subscribe_captcha_count: 0,
                game_users_count: 0,
                total_game_scores: 0,
            },
            isLoading: false
        }
    },
    mounted() {
        this.getData()
    },
    computed: {},
    methods: {
        getData() {
            this.isLoading = true
            let start_time = new Date().getTime();
            axios.post('/charts/dashboard-stats')
                .then(res => {
                    this.data = res.data;
                    this.isLoading = false
                    let time = new Date().getTime() - start_time;
                    console.log(time + 'ms - Chart dashboard-stats');
                })
        },

    }
}
</script>

<style lang="css">

</style>
