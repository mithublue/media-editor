/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');
import Vue from 'vue';
import axios from 'axios';
import CropPanel from './components/CropPanel.vue';
import FilterPanel from './components/FilterPanel.vue';
import MediaLibrary from './components/MediaLibrary.vue';
import AdjustFilterPanel from './components/AdjustFilterPanel.vue';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: {
        CropPanel,
        FilterPanel,
        MediaLibrary,
        AdjustFilterPanel
    },
    data: {
        noti_msg: '',
        all_applied_data: [],
        base_url: base_url,
        active_tab: null,
        current_image: null,
        gallery_images: [],
        selected_file: null,

        selected_filter: null,
        selected_flip: null,
        selected_rotate: null,
        selected_ratio: null,

        filter_data: {
            original: {
                label: 'Original',
                style: {}
            },
            greyScale: {
                label: 'GreyScale',
                style: {
                    filter: 'grayscale(1.0)'
                }
            },
            sepia: {
                label : 'Sepia',
                style: {
                    filter: 'sepia(1.0)'
                }
            },
            invert: {
                label: 'Invert',
                style: {
                    filter: 'invert(1.0)'
                }
            },
            duotone: {
                label: 'Duotone',
                style: {}
            },
            warm: {
                label: 'Warm',
                style: {}
            },
            cool: {
                label: 'Cool',
                style: {}
            },
            dramatic: {
                label: 'Dramatic',
                style: {}
            },
        },
        crop_data: {
            flip: {
                none: 'None',
                horizontal: 'Flip Horizontal',
                vertical: 'Flip Vertical',
            },
            rotate: {
                deg0: '0 deg',
                deg30: '30 deg',
                deg60: '60 deg',
                deg90: '90 deg',
                deg180: '180 deg',
            },
            ratio: {
                r_16_9: '16:9',
                r_10_7: '10:7',
                r_7_5: '7:5',
                r_4_3: '4:3',
                r_5_3: '5:3',
                r_3_2: '3:2',
            },
        },
        adjusted_filter: {}
    },
    methods: {
        make_active : function ( tabName ) {
            this.active_tab = tabName;
        },
        set_current_image: function ( image ) {
            this.reset_style();
            if( image ) {
                this.current_image = image;
                this.apply_style();
            }
        },
        apply_style: function () {
            if( typeof this.all_applied_data[this.current_image.name] !== 'undefined' ) {
                var sel_applied_data = this.all_applied_data[this.current_image.name];
                this.selected_filter = typeof sel_applied_data.filter !== 'undefined' ? sel_applied_data.filter : '';
                this.selected_flip = typeof sel_applied_data.flip !== 'undefined' ? sel_applied_data.flip : '';
                this.selected_rotate = typeof sel_applied_data.rotate !== 'undefined' ? sel_applied_data.rotate : '';
                this.selected_ratio = typeof sel_applied_data.ratio !== 'undefined' ? sel_applied_data.ratio : '';
                this.adjusted_filter = typeof sel_applied_data.adjusted_filter !== 'undefined' ? sel_applied_data.adjusted_filter : {};
            } else {
                this.reset_style();
            }
        },
        reset_style: function () {
            this.selected_filter = '';
            this.selected_flip = '';
            this.selected_rotate = '';
            this.selected_ratio = '';
            this.selected_ratio = '';
            this.adjusted_filter = {};
        },
        insert_style: function () {
            Vue.set(this.all_applied_data, this.current_image.name, {
                'filter' : this.selected_filter,
                'flip' : this.selected_flip,
                'rotate' : this.selected_rotate,
                'ratio' : this.selected_ratio,
                'adjusted_filter' : this.adjusted_filter
            })
        },
        get_images: function () {
            var _this = this;
            axios.get( base_url + '?action=get-images')
                .then( function (res) {
                    _this.all_applied_data = res.data.image_data;
                    _this.gallery_images = res.data.images;
                })
        },
        select_filter: function ( filter_name ) {
            this.selected_filter = filter_name;
        },
        select_flip: function ( type ) {
            this.selected_flip = type;
        },
        select_rotate: function ( type ) {
            this.selected_rotate = type;
        },
        select_ratio: function ( type ) {
            this.selected_ratio = type;
        },

        //uploader
        on_file_selected: function (event) {
            this.selected_file = event.target.files[0];
        },
        on_upload: function () {
            var _this = this;
            var fd = new FormData;
            //console.log(this.selected_file.name);
            fd.append('image', this.selected_file, this.selected_file.name);
            axios.post( base_url + '?action=upload', fd, {
                onUploadProgress: function ( uploadEvent ) {
                    //console.log( 'Upload progress' + Math.round( uploadEvent.loaded / uploadEvent.total * 100 ) + '%');
                }
            } )
                .then(function (res) {
                    if ( !res.data.success ) return;
                    _this.show_notification( 'Image uploaded successfully !');
                    _this.get_images();
                })
        },

        save_image: function () {
            var _this = this;
            var sel_applied_data = this.save_modification();
            //save in dir
            var fd = new FormData;
            fd.append( 'imgObj', JSON.stringify( this.current_image ) );
            fd.append( 'applied_data', JSON.stringify( sel_applied_data ) );
            axios.post( base_url + '?action=save-image', fd )
                .then(function (res) {
                    _this.insert_style();
                    console.log('qwewqe');
                    _this.show_notification( 'Image saved successfully !');
                });
        },
        save_modification: function () {
            var sel_applied_data = {
                flip: this.selected_flip,
                rotate: this.selected_rotate,
                ratio: this.selected_ratio,
                filter: this.selected_filter,
                adjusted_filter: this.adjusted_filter
            }
            //console.log(sel_applied_data);
            return sel_applied_data;
        },
        adjust_filter: function (style) {
            this.adjusted_filter = style;
        },
        is_revartable: function () {
            if( typeof this.all_applied_data[this.current_image.name] !== 'undefined' ) return true;
            return false;
        },
        revart_image: function () {
            this.reset_style();
            this.insert_style();
            this.show_notification( 'Image revarted !');
        },
        set_filters: function(filters) {
            this.adjusted_filter = filters;
        },
        show_notification: function (msg) {
            var _this = this;
            _this.noti_msg = msg;
            setTimeout(function () {
                _this.noti_msg = ''
            },3000);
        }
    },
    created: function () {
        this.active_tab = 'adjust';
    },
    mounted: function () {
        this.get_images();
    }
});
