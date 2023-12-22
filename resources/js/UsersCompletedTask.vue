<template>
    <div>
        <div class="table__header">
            <span>Users who completed this task</span>
        </div>
        <div class="spinner-border text-primary" v-if="isLoading" style="margin: 0 auto" role="status">
            <span class="sr-only"></span>
        </div>
        <div class="table-responsive scrollbar">
            <table class="table table-bordered fs--1 mb-0 mt-4">
                <thead class="thead">
                <tr>
                    <th>#</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Username</th>
                    <th>Completed at (UTC+3)</th>
                </tr>
                </thead>
                <tbody class="tbody">

                <tr v-for="(user, index) in data.data">
                    <td>
                        {{ data.from + index }}
                    </td>
                    <td>
                        {{ user.first_name }}
                    </td>
                    <td>
                        {{ user.last_name }}
                    </td>
                    <td>
                        {{ user.username }}
                    </td>
                    <td>
                        {{ user.completed_at }}
                    </td>
                </tr>
                </tbody>
            </table>
            <pagination-component
                :data="data"
                @change="onChangePage"
            ></pagination-component>
        </div>
    </div>
</template>

<script>

export default {
    props: [
        'task'
    ],
    data() {
        return {
            data: {},
            avgSum: 0,
            startDate: "",
            endDate: "",
            isLoading: true,
            currentPage: 1
        }
    },
    mounted() {
        this.getData()
    },
    computed: {},
    methods: {
        onChangePage(page) {
            this.currentPage = page;
            this.getData();
        },
        getData() {
            this.isLoading = true
            let start_time = new Date().getTime();
            axios.post('/tasks/' + this.task.id + '/users?page='+this.currentPage)
                .then(res => {
                    this.data = res.data;
                    this.isLoading = false;
                    let time = new Date().getTime() - start_time;
                    console.log(time + 'ms - Chart user-completed-task');
                })
        },

    }
}
</script>

<style lang="css">

</style>
