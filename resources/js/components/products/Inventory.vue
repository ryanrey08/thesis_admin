<template>

    <div class="container-fluid">
        <div class="jumbotron">
            <h1>Inventory</h1>
        </div>


        <div class="content">
            <div class="container-fluid">
                <div class="row mt-2">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-hover no-border">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>
                                            <!-- <select v-model="filter" class="custom-select">
                                                <option v-for="(filter, index) in filters" :key="index" :value="filter">{{ filter }}</option>
                                            </select> -->
                                        </th>
                                        <th></th>
                                        <th></th>
                                        <th colspan="2">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <button class="search-button-text border border-0 rounded-left " @click.prevent="">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </div>
                                                <input v-model="searchQuery" class="form-control border border-0 rounded-right" placeholder="Search" aria-label="Search">
                                            </div>
                                        </th>
                                        
                                    </tr>
                                </thead>
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="text-center w-15">#</th>
                                        <th class="text-center w-35">Item</th>
                                        <th class="text-center w-20">Price</th>
                                        <th class="text-center w-15">Quantity</th>
                                        <th class="text-center w-15">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="items.length == 0">
                                        <td colspan="5" align="center">
                                            <div class="overlay" style="font-size: 25px; font-weight: bolder;">
                                                <i class="fa fa-spinner fa-spin red"></i>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr v-else v-for="item in filteredItems" :key="item.id">
                                        <td class="text-center">{{ item.id }}</td>
                                        <td class="text-center small">{{ item.name }}</td>
                                        <td class="text-center">{{ item.price }}</td>
                                        <td class="text-center">{{ item.quantity }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-warning btn-sm" @click="editItem(item)" trigger="hover" data-toggle="tooltip" title="Edit Item"><i class="fas fa-pencil-alt"></i></button>
                                            <!-- <button class="btn btn-success btn-sm" trigger="hover" data-toggle="tooltip" title="Post Product"><i class="fas fa-check"></i></button> -->
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="editItem" aria-modal="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content r">
                        <div class="modal-header">
                            <h6 class="modal-title">{{ item.name }}</h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <h4 class="small"></h4>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="amount">Price</label>
                                        <input type="number" class="form-control" v-model="item.price" min="0">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="amount">Quantity</label>
                                        <input type="number" class="form-control" v-model="item.quantity" min="0">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" @click.prevent="updateItem(item.id)">Save Changes</button>
                        </div>

                    </div>

                </div>

            </div>
        </div>

    </div>


</template>

<script>

    export default {

        data() {
            return {

                // Data Handlers
                items: [],


                // Watched Data
                item: new Form({
                    id: null,
                    productID: null,
                    name: null,
                    price: null,
                    quantity: null,
                    combination: null,
                }),
                
                // filteredProducts: [],
                filters: ["All", "Unpublished", "Published"],



                filter: "",
                searchQuery: "",
            }
        },
        computed: {
            filteredItems (){
                if(this.searchQuery){
                    return this.items.filter((item)=>{
                        if( (item.id.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1) || (item.price.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1) || (item.quantity.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1) || (item.name.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1)) {
                            return item.name;
                        }
                    })
                }else{
                    return this.items;
                }
            }
        },

        methods: {
            editItem: function(item) {
                this.item.reset();
                this.item.fill(item);
                $('#editItem').modal('show');
            },

            updateItem: function(id) {
                this.$Progress.start();
                this.item.put('/api/inventory/'+ id)
                    .then(() => {
                        this.$Progress.finish();
                        $('#editItem').modal('hide');
                        Toast.fire({
                            type: 'success',
                            title: 'Item Updated Successfully'
                        });
                        this.loadItems();
                    })
                    .catch(({error}) => {
                        this.$Progress.fail();
                        Swal.fire(
                            'Failed', "There's something wrong.",
                            'warning'
                        );
                        console.log(error.message);
                    });

            },

            loadItems: function() {

                axios.get('/api/inventory').then(({ data }) => (this.items = data));
                this.filter = "All";

            },
        },

        created() {

            this.loadItems();

        }


    };

</script>


<style scoped>

.w-10 {
    width: 10%;
}

.w-20 {
    width: 20%;
}

.w-30 {
    width: 30%;
}

.w-35 {
    width: 35%;
}

.w-15 {
    width: 15%;
}

.search-button-text {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    padding: .375rem .75rem;
    margin-bottom: 0;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    text-align: center;
    white-space: nowrap;
    background-color: #ffffff;
}



</style>
