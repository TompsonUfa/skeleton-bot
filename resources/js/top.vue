<template>
    <div class="table-container">
        <div class="table__header">
            <div class="row">
                <div class="col-12 h-title">Top users</div>
            </div>
            <hr>
            <div class="form-check">
                <input class="form-check-input" type="radio"
                       value="by_season"
                       id="by_season"
                       v-model="by"
                >
                <label class="form-check-label" for="by_season">
                    By season
                </label>
                <div class="col-3 d-inline-block">
                    <select name="selected_season" class="form-select"
                            v-model="selected_season"
                    >
                        <option
                            value="0"
                        >
                            Default
                        </option>
                        <option
                            v-for="season in seasons"
                            :value="season.id"
                        >
                            {{ season.caption }}
                        </option>
                    </select>
                </div>
            </div>
            <hr>
            <div class="form-check mt-3">
                <input class="form-check-input" type="radio"
                       value="by_range"
                       id="by_range"
                       v-model="by"
                >
                <label class="form-check-label" for="by_range">
                    By range
                </label>

                <div class="mt-1 row align-items-center">
                    <div class="col-auto">
                        <label for="date_a" class="col-form-label">Date A</label>
                    </div>
                    <div class="col-auto">
                        <input type="date" class="form-control" name="date_a" id="date_a"
                               v-model="date_a"
                        >
                    </div>
                </div>

                <div class="mt-1 row align-items-center">
                    <div class="col-auto">
                        <label for="date_b" class="col-form-label">Date B</label>
                    </div>
                    <div class="col-auto">
                        <input type="date" class="form-control" name="date_b" id="date_b"
                               v-model="date_b"
                        >
                    </div>
                </div>

            </div>
            <hr>
            <div class="col-auto">
                <button
                    @click="getData()"
                    class="btn btn-primary">Show
                </button>
            </div>
        </div>


        <div class="row">
            <div class="spinner-border text-primary" v-if="isLoading" style="margin: 0 auto" role="status">
                <span class="sr-only"></span>
            </div>
        </div>
        <div class="row mt-5">

            <div class="col-6 max-w-6xl mx-auto sm:px-6 lg:px-8">
                <h6>Top by scores</h6>
                <table class="table w-100">
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Score</th>
                    </tr>
                    <tr
                        v-for="(score, index) in scores"
                        :value="score.id"
                    >
                        <th>{{ index + 1 }}</th>
                        <th>
                            <a target="_blank" :href=getUrl(score.id)>
                                {{ score.first_name }}
                            </a>
                        </th>
                        <th>{{ score.score }}</th>
                    </tr>
                </table>
            </div>


            <div class="col-6 max-w-6xl mx-auto sm:px-6 lg:px-8">
                <h6>Top by referral</h6>
                <table class="table w-100">
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Ref count</th>
                    </tr>
                    <tr
                        v-for="(user, index) in users"
                        :value="user.id"
                    >
                        <th>{{ index + 1 }}</th>
                        <th>
                            <a target="_blank" :href=getUrl(user.id)>
                                {{ user.first_name }}
                            </a>
                        </th>
                        <th>{{ user.ref_count }}</th>
                    </tr>
                </table>
            </div>
        </div>


    </div>

</template>

<script>


export default {
    props: [
        'seasons',
    ],
    data() {
        return {
            by: 'by_season',
            selected_season: 0,
            date_b: null,
            date_a: null,
            isLoading: false,
            scores: {},
            users: {},
        }
    },
    mounted() {
    },
    methods: {
        getUrl(id) {
            return '/users/' + id;
        },
        getData() {
            let data = {};
            data.by = this.by;
            if (data.by === 'by_season') {
                data.selected_season = this.selected_season;
            }
            if (data.by === 'by_range') {
                data.date_a = this.date_a;
                data.date_b = this.date_b;
            }
            this.isLoading = true
            let start_time = new Date().getTime();
            axios.post('/top/data', data)
                .then(res => {
                    this.scores = res.data.scores
                    this.users = res.data.users
                    this.isLoading = false
                    let time = new Date().getTime() - start_time;
                    console.log(time + 'ms - Top');
                })
            return false;
        },
    }
}
</script>

<style lang="css">

</style>
