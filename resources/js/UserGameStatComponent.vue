<template>
    <div class="game-launch d-flex justify-content-center flex-column">

        <Line :data="datacollection" :height="200" v-if="datacollection != null"/>

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
    components: { Line },
    props: {
        data: String,
    },
    data() {
        return {
            datacollection: null,
        }
    },
    mounted() {
        this.datacollection = JSON.parse( this.data )
    }
}
</script>

<style lang="css">
</style>
