<template>
    <div>
        <div class="row mt-3">
            <div class="col-2">Flip</div>
            <div class="col">
                <a href="javascript:" class="btn btn-outline-secondary btn-sm"
                   v-for="( label, type ) in  crop_data.flip"
                   @click="select_flip(type)"
                >{{ label }}</a>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-2">Rotate</div>
            <div class="col">
                <a href="javascript:" class="btn btn-outline-secondary btn-sm"
                   v-for="( label, type ) in  crop_data.rotate"
                   @click="select_rotate(type)"
                >{{ label }}</a>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-2">Ratio</div>
            <div class="col">
                <a href="javascript:" class="btn btn-outline-secondary btn-sm"
                   v-for="( label, type ) in  crop_data.ratio"
                   @click="select_ratio(type)"
                >{{ label }}</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'CropPanel',
        props: {
            crop_data: Object
        },
        data() {
            return {
            }
        },
        created() {
        },
        watch: {

        },
        computed: {

        },
        methods: {
            select_flip: function ( type ) {
                this.$emit( 'ev:select_flip', type );
            },
            select_rotate: function ( type ) {
                this.$emit( 'ev:select_rotate', type );
            },
            select_ratio: function ( type ) {
                this.$emit( 'ev:select_ratio', type );
            }
        }
    }
</script>
