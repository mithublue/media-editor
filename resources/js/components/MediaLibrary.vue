<template>
    <div>
        <h2 class="mb-4 mt-4">Media Library</h2>
        <div class="card">
            <div class="card-body">
                <div class="col-sm-11 container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="mt-4">{{ images.length }} items</h4>
                        </div>
                        <div class="col-3 mt-3" v-for="( image, key ) in images">
                            <div class="card" @click="set_current_image(image)">
                                <img :src="image.url" class="card-img-top p-0" alt="...">
                                <div>
                                    <p class="card-title text-center">{{ image.name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    export default {
        name: 'MediaLibrary',
        props: {
            images: Array
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
            set_current_image: function ( image ) {
                this.$emit( 'ev:set_current_image', image )
            }
        }
    }
</script>
