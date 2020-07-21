<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 input-filters">
                <div class="row">

                </div>
                <div class="row">
                    <div class="col-md-6 container">
                        <div class="row">
                            <div class="col">Warmth</div>
                            <div class="col"><input type="range" v-model="sepia" max="1" min="0" step="0.01" @change="set_filters" /></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col">Contrast</div>
                            <div class="col"><input type="range" v-model="contrast" max="1" min="0" step="0.01" @change="set_filters" /></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col">Highlight</div>
                            <div class="col"><input type="range" v-model="brightness" max="3" min="0" step="0.01" @change="set_filters" /></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col">Saturate</div>
                            <div class="col"><input type="range" v-model="saturate" max="1" min="0" step="0.01" @change="set_filters" /></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col">Blur</div>
                            <div class="col"><input type="range" v-model="blur" max="50" min="0" step="0.1" @change="set_filters" /></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'AdjustFilterPaanel',
        props:{
            adjusted_filter: Object
        },
        data: function () {
            return {
                sepia: 0,
                saturate: 1,
                brightness: 1,
                contrast: 1,
                blur: 0,
                suffix: {
                    hueRotate: 'deg',
                    blur: 'px'
                }
            }
        },
        computed: {
            filters() {
                return { filter: Object.entries(this._data).filter(item => typeof(item[1]) !== 'object').map(item => `${this.toDash(item[0])}(${item[1]}${this.suffix[item[0]] || ''})`).join(' ') }
            }
        },
        methods: {
            toDash: (str) => str.replace( /([a-z])([A-Z])/g, '$1-$2' ).toLowerCase(),
            set_filters() {
                this.$emit( 'ev:set_filters', this.filters );
            }
        },
        mounted() {
            if( typeof this.adjusted_filter.filter !== 'undefined' ) {
                var filter_fragments = this.adjusted_filter.filter.split(' ');
                console.log(filter_fragments);
                this.sepia = parseInt(filter_fragments[0].replace(/[^0-9]/g,''));
                this.saturate = parseInt(filter_fragments[1].replace(/[^0-9]/g,''));
                this.brightness = parseInt(filter_fragments[2].replace(/[^0-9]/g,''));
                this.contrast = parseInt(filter_fragments[3].replace(/[^0-9]/g,''));
                this.blur = parseInt(filter_fragments[4].replace(/[^0-9]/g,''));
            }
        }
    };
</script>