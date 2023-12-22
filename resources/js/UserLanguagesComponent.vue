<template>
    <div>
        <div class="spinner-border text-primary" v-if="isLoading" style="margin: 0 auto" role="status">
            <span class="sr-only"></span>
        </div>
        <h6 class="mt-1">User languages</h6>
        <Doughnut
            :data="datacollection"
            :height="400"
            v-if="datacollection != null"
        ></Doughnut>
    </div>
</template>

<script>
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js'
import { Doughnut } from 'vue-chartjs'

ChartJS.register(ArcElement, Tooltip, Legend)

export default {
    components: {
        Doughnut,
    },
    data() {
        return {
            datacollection: null,
            avgSum: 0,
            startDate: "",
            endDate: "",
            isLoading: true
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
            axios.post('/charts/user-languages')
                .then(res => {
                    this.avgSum = res.data.avg;
                    this.datacollection = res.data
                    this.isLoading = false
                    let time = new Date().getTime() - start_time;
                    console.log(time + 'ms - Chart user-growth');
                })
        },

    }
}
</script>

<style lang="css">

</style>
