<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo Imager_Config()->config('root_url'); ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo Imager_Config()->config('root_url'); ?>assets/css/style.css">
</head>
<body>
<div id="app" v-cloak>
    <div class="header">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="logo">
                        IMAGEFOLIO
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="body">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-name mb-3" v-if="current_image">
                        <h4 v-if="current_image">{{ current_image.name }}</h4>
                        <a href="javascript:" class="btn btn-primary btn-sm" @click="current_image = null">Bact to Library</a>
                        <a href="javascript:" class="btn btn-primary btn-sm" @click="save_image">Save</a>
                        <template v-if="is_revartable()">
                            <a href="javascript:" class="btn btn-primary btn-sm" @click="revart_image" >Revart</a>
                        </template>
                    </div>
                </div>
                <div class="col-sm-12">
                    <!--image-canvas-->
                    <div class="image-canvas"  v-if="current_image">
                        <div class="card">
                            <div class="card-body row">
                                <div class="col-sm-6 content-container">
                                    <div>
                                        <div :class="selected_ratio">
                                            <div :class="[selected_filter,selected_rotate]" class="img-wrapper">
                                                <div class="oh">
                                                    <img id="image" :src="current_image.url" alt=""
                                                         :class="[selected_flip]"
                                                         :style='adjusted_filter'
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nav-container mt-3">
                                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link" @click="make_active('adjust')" :class="{ active: active_tab == 'adjust' }" href="javascript:">
                                                    Adjust
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" @click="make_active('filter')" :class="{ active: active_tab == 'filter' }"  href="javascript:">
                                                    Filter
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" @click="make_active('crop')" :class="{ active: active_tab == 'crop' }"  href="javascript:">
                                                    Crop
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-content" id="pills-tabContent">
                                        <!--Adjust-->
                                        <div class="tab-pane fade" :class="{ 'show active' : active_tab == 'adjust' }">
                                            <adjust-filter-panel
                                                    :adjusted_filter="adjusted_filter"
                                                    @ev:set_filters="set_filters"
                                            ></adjust-filter-panel>
                                        </div>
                                        <!--Adjust ends-->
                                        <div class="tab-pane fade" :class="{ 'show active' : active_tab == 'crop' }">
                                            <crop-panel
                                                    :crop_data="crop_data"
                                                    @ev:select_flip="select_flip"
                                                    @ev:select_rotate="select_rotate"
                                                    @ev:select_ratio="select_ratio"
                                            ></crop-panel>
                                        </div>
                                        <div class="tab-pane fade" :class="{ 'show active' : active_tab == 'filter' }">
                                            <filter-panel
                                                    :img="current_image"
                                                    :filter_data="filter_data"
                                                    @ev:select_filter="select_filter"
                                            ></filter-panel>
                                        </div>
                                    </div>
                                </div>
                                <!--single image ends-->
                            </div>
                        </div>
                    </div>

                    <!--media library-->
                    <div v-if="!current_image">
                        <media-library
                                :images="gallery_images"
                                @ev:set_current_image="set_current_image"
                        ></media-library>
                        <!--file upload-->
                        <div class="card upload-container">
                            <div class="card-body">
                                <div class="col-sm-11 container">
                                    <div class="row">
                                        <div class="col-sm-2 uploader-label">
                                            Upload
                                        </div>
                                        <div class="col-sm-10 uploader">
                                            <input type="file" name="image" @change="on_file_selected">
                                            <button @click="on_upload">Upload</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var base_url = '<?php echo Imager_Config()->config('root_url'); ?>';
</script>
<script src="<?php echo Imager_Config()->config( 'root_url' ); ?>assets/js/app.js"></script>
</body>
</html>