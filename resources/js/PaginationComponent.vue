<template>
    <nav v-if="data.total > data.per_page">
        <ul class="pagination">
            <li class="page-item"
                aria-disabled="true"
                aria-label="pagination.previous"
                v-bind:class="{
                    'disabled': data.current_page === 1
                }"
            >
                <a class="page-link"
                   rel="prev"
                   aria-label="pagination.prev"
                   @click="changePage(data.current_page - 1)"
                >&lsaquo;</a>
            </li>

            <template v-for="page in getLinks()">
                <li v-if="data.current_page === parseInt(page.label)" class="page-item active" aria-current="page">
                    <span class="page-link">{{page.label}}</span>
                </li>

                <li v-else-if="page.label === '...'" class="page-item disabled" aria-disabled="true">
                    <span class="page-link">...</span>
                </li>

                <li v-else-if="page.label !== '&laquo; Previous' && page.label !== 'Next &raquo;'"
                    class="page-item">
                    <a class="page-link" @click="changePage(page.label)">{{ page.label }}</a>
                </li>
            </template>


            <li class="page-item"
                v-bind:class="{
                    'disabled': data.current_page === data.last_page
                }"
            >
                <a class="page-link"
                   rel="next"
                   aria-label="pagination.next"
                   @click="changePage(data.current_page + 1)"
                >&rsaquo;</a>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    name: 'PaginationComponent',
    props: {
        data: {
            type: Object,
            default: {
                per_page: 15,
                total: 0,
                last_page: 0
            }
        },
    },
    data() {
        return {
            paginationData: {},
            show: true
        }
    },
    mounted() {
        this.paginationData = this.data;
    },
    methods: {
        getLinks() {
            return this.paginationData.links;
        },
        changePage(page) {
            this.$emit('change', page);
        }
    },
    watch: {
        data: {
            handler: function (newValue) {
                this.paginationData = newValue;
            }
        }
    },
}
</script>

<style lang="sass" scoped>
.page-link
    cursor: pointer

</style>
