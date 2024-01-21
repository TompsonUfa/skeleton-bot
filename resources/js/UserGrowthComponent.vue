<template>
    <div class="user-growth d-flex justify-content-center flex-column">
        <h6 class="mt-1">User growth</h6>

        <div class="d-flex mb-4 ml-3 flex-column flex-md-row">
            <input type="date" class="form-control m-1" style="width: 10rem; color: #8785AA" v-model="startDate">
            <input type="date" class="form-control m-1" style="width: 10rem; color: #8785AA" v-model="endDate">
            <button class="btn btn-primary m-1" style="width: 10rem;" :class="disabledShow?'btn-secondary':''"
                    :disabled="disabledShow" @click="showInRange($event)">Show
            </button>
        </div>

        <div class="flex mb-4 ml-3">
            <button class="btn m-1"
                    @click="currentWeek($event)">Last 7 days
            </button>
            <button class="btn m-1 act1"
                    @click="currentMonth($event)">Last 30 days
            </button>
            <button class="btn m-1"
                    @click="fillData($event)">All time
            </button>
        </div>

        <div class="spinner-border text-primary" v-if="isLoading" style="margin: 0 auto" role="status">
            <span class="sr-only"></span>
        </div>

        <Line :data="datacollection" :height="300" v-if="datacollection != null"/>
    </div>
</template>

<script>
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
} from 'chart.js'
import { Line } from 'vue-chartjs'

ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
)

export default {
    components: {
        Line
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
        this.currentMonth()
    },
    computed: {
        disabledShow: function () {
            if (!this.startDate || !this.endDate) {
                return true
            } else {
                return false
            }
        }
    },
    methods: {
        getData(data = {}) {
            this.isLoading = true
            let start_time = new Date().getTime();
            axios.post('/charts/user-growth', data)
                .then(res => {
                    this.avgSum = res.data.avg;
                    this.datacollection = res.data
                    this.isLoading = false
                    let time = new Date().getTime() - start_time;
                    console.log(this.datacollection)
                    console.log(time + 'ms - Chart user-growth');
                })
        },
        makeActive(target) {
            let actEl = document.querySelector('.user-growth .act1')
            if (actEl) {
                actEl.classList.remove('act1')
            }
            target.classList.add('act1')
        },
        showInRange(e) {
            if (e) {
                this.makeActive(e.currentTarget)
            }
            this.getData({range: 'true', start_date: this.startDate, end_date: this.endDate})
        },
        currentMonth(e) {
            if (e) {
                this.makeActive(e.currentTarget)
            }
            this.getData({current_month: 'true'});
        },
        currentWeek(e) {
            if (e) {
                this.makeActive(e.currentTarget)
            }
            this.getData({current_week: 'true'});
        },
        currentDay(e) {
            if (e) {
                this.makeActive(e.currentTarget)
            }
            this.getData({current_day: 'true'});
        },
        fillData(e) {
            if (e) {
                this.makeActive(e.currentTarget)
            }
            this.getData();
        }
    }
}
</script>

<style lang="css">

</style>
