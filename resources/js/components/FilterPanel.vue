<template>
    <div class="row">
        <div class="col-3 mt-3" v-for="( filter, filter_name ) in filter_data" @click="select_filter( filter_name )">
            <div class="card filter-thumb"  :class="filter_name">
                <img :src="img.url" class="card-img-top p-0" alt="">
                <div>
                    <p class="card-title text-center">{{ filter.label }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: 'FilterPanel',
        props: {
            filter_data: Object,
            img: Object
        },
        data() {
            return {

            }
        },
        created() {
        },
        methods: {
            select_filter: function ( filter_name ) {
                this.$emit( 'ev:select_filter', filter_name );
            }
        }
    }
</script>
