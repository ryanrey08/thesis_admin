<template>
    <div class="w-100">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md">
                        <div class="d-flex justify-content-between">
                            <h1 class="m-0 text-dark">Create Collection</h1>
                            <button class="btn btn-primary no-border" @click="saveCollection"><i class="fa fa-fw fa-save"></i>Save</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-sm-12">

                        <div class="card">
                            <div class="card-body">                

                                <div class="form-group">
                                    <div class="row">

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="">Title</label>
                                                <input class="form-control" type="text" name="name" placeholder="e.g (BTS Collection, Under P250, Korean Experience...)" v-model="collection.name">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <label for="productdesc">Image</label>
                                
                                <div class="row text-center" >
                                    <div class="col-sm-6">
                                        <div :class="[collection.displayImage == null ? ' w-100 border-info pt-2 opacity' : 'w-100 border-info pt-2']" style="height: 250px; border: dashed; cursor: pointer;" @click="addDP">
                                            <img :src="collection.displayImage == null ? '/img/designs/svg/pictures.svg' : collection.displayImage" class="w-75 h-100">
                                            <input id="displayImage" name="displayImage" type="file" @change="uploadDP" hidden/>
                                        </div>
                                        <div class="small blue">{{ collection.displayImage == null ? 'Add' : 'Change' }} Display Image</div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div :class="[collection.coverImage == null ? 'w-100 border-info pt-2 opacity' : 'w-100 border-info pt-2']" style="height: 250px; border: dashed; cursor: pointer;" @click="addCP">
                                            <img :src="collection.coverImage == null ? '/img/designs/svg/pictures.svg' : collection.coverImage" class="w-75 h-100">
                                            <input id="coverImage" name="coverImage" type="file" @change="uploadCP" hidden/>
                                        </div>
                                        <div class="small blue">{{ collection.coverImage == null ? 'Add' : 'Change' }} Cover Image</div>
                                    </div>
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

import { VueEditor } from 'vue2-editor';


export default {
    components: {
        VueEditor, 
    },

    data() {

        return {

            


        }

    },

    methods: {

        addDP: function() {
            document.getElementById('displayImage').click();
        },

        addCP: function() {
            document.getElementById('coverImage').click();
        },

        uploadDP: function(e) {
            let image = e.target.files[0];

            let reader = new FileReader();

            reader.onloadend = files => {

                this.collection.displayImage = reader.result;
                console.log(reader.result.length);
            };

            reader.readAsDataURL(image);
        },

        uploadCP: function(e) {
            let image = e.target.files[0];

            let reader = new FileReader();

            reader.onloadend = files => {

                this.collection.coverImage = reader.result;
                console.log(reader.result.length);
            };

            reader.readAsDataURL(image);
        },

        saveCollection: function() {
            

            this.collection.post('/api/attributes/collections/add')
            .then(() => {
                this.loadCollections();
            })
            .catch(({error}) => { console.log(error.message); });
        },
    },

    created() {
        $('[data-toggle="tooltip"]').tooltip('hide'); 
    }
};

</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style scoped>

    ::-webkit-scrollbar {
        width: 3px;
    }


    ::-webkit-scrollbar-track {
        background: #f1f1f1; 
    }

    ::-webkit-scrollbar-thumb {
        background: -webkit-gradient(linear,left bottom,left top,color-stop(0,#dc3545),color-stop(1,#e4606d));
    }


    ::-webkit-scrollbar-thumb:hover {
        background: #555; 
    }

    .card-header {
        background: #ffffff;
    }

    .card-footer {
        background: #ffffff;
    }

    .info-box {
        cursor: pointer;
    }

    .info-box::focus {
        background: yellow;
    }

    .info-box-description {
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .info-box-item {
        display: block;
        font-weight: 700;
    }


    .f-10 {
        font-size: 10px;
    }

    .opacity {
        opacity: .5;
    }

</style>









