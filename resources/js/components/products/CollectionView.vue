<template>  
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-12">


                <div class="form-group">
                    <div class="row">

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="">{{ collection.description }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <label for="">Image</label>

                <div class="row text-center" >
                    <div class="col-sm-6">
                        <div class="w-100 border-info pt-2":class="[collection.display_image == null ? 'opacity' : '']" style="height: 250px; border: dashed; cursor: pointer;">
                            <img :src="collection.display_image == null ? '/img/designs/svg/pictures.svg' : collection.display_image" class="w-75 h-100">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="w-100 border-info pt-2":class="[collection.cover_image == null ? 'opacity' : '']" style="height: 250px; border: dashed; cursor: pointer;">
                            <img :src="collection.cover_image == null ? '/img/designs/svg/pictures.svg' : collection.cover_image" class="w-75 h-100">
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
</template>

<script>    
        export default{
            data(){
                return{
                    collection_id: null,
                    collection : new Form({
                        description: null,
                        display_image: null,
                        cover_image: null

                    })
                }
            },

            methods: {
                    getCollection: function() {
                        axios.get('/api/collections/getCollection/' + this.collection_id).then(( data ) => {
                             this.collection.fill(data.data);
                        });
                    }
            },

            created() {
                this.collection_id = this.$route.params.collectionID;
                this.getCollection();
            }
        };
</script>