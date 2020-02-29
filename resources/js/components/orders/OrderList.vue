<template>

    <div class="w-100">

        <div class="jumbotron">
            <h1 class="display-4">Orders</h1>
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
                                            <select v-model="orderStat" class="custom-select">
                                                <option v-for="(status, index) in orderStatus" :key="index" :value="status">{{ status.description }}</option>
                                            </select>
                                        </th>
                                        <th></th>
                                        <th></th>
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
                                        <th class="text-center w-20">Customer</th>
                                        <th class="text-center w-15">Payment Method</th>
                                        <th class="text-center w-10">Status</th>
                                        <th class="text-center w-10">Total</th>
                                        <th class="text-center w-15">Date</th>
                                        <th class="text-center w-15">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="orders.length == 0">
                                        <td colspan="8" align="center">
                                            <div class="overlay" style="font-size: 25px; font-weight: bolder;">
                                                <i class="fa fa-spinner fa-spin red"></i>
                                            </div>
                                        </td>
                                    </tr>


                                    <tr v-else v-for="order in filteredOrders" :key="order.id">
                                        <td class="text-center">{{ order.id }}</td>
                                        <td class="text-center">{{ order.customer }}</td>
                                        <td class="text-center">{{ order.paymentmethod }}</td>
                                        <td class="text-center">
                                            <span class="badge white " :class="bg[order.statusid]">{{ order.status }}</span>
                                        </td>
                                        <td class="text-center">{{ order.total.toFixed(2) }}</td>
                                        <td class="text-center">{{ order.created_at | cusDate }}</td>
                                        <td class="text-center">
                                            <router-link :to="{ path: '/orders/'+order.id+'/manage', params: { orderid: order.id } }" class="btn btn-warning btn-sm" trigger="hover" data-toggle="tooltip" title="Manage Order"><i class="icon ion-ios-more"></i></router-link>
                                            
                                            <router-link :to="{ path: '/orders/'+order.id+'/view', params: { orderid: order.id } }" class="btn btn-view btn-sm" trigger="hover" data-toggle="tooltip" title="View Order Details"><i class="icon ion-ios-eye"></i></router-link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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

        data() {
            return {

                // Data Handlers
                staff: new Form({
                    id: null,
                    name: null,
                    type: null,
                }),
                orders: [],
                searchQuery: '',


                // Watched Data
                
                // filteredOrders: [],
                // filters: ["All", "Unpublished", "Published"],

                orderStatus: [],
                orderStat: null,
                bg: ['bg-danger', 'bg-pending', 'bg-processing', 'bg-shipping', 'bg-delivery', 'bg-success']
                // filter: "",
                // search: "",
                // '/img/products/': "/img/products/",
                
                // count: 0,
                
                

            }
        },

        computed: {
            filteredOrders (){
                if(this.searchQuery){
                    return this.orders.filter((order)=>{
                        if( (order.id.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1) || (order.customer.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1) || (order.paymentmethod.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1) || (order.status.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1) || (order.total.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1) || (order.created_at.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1)) {
                            return order.id;
                        }
                    })
                }else{
                    return this.orders;
                }
            }
        },


        methods: {

            getStaff: function() {
                axios.get("/api/profile").then(({data}) => this.staff.fill(data));
            },

            loadOrders: function() {

                axios.get('/api/orders').then(({ data }) => (this.orders = data));

            },

            loadOrderStatus: function() {
                axios.get('/api/orders/status/get').then(({ data }) => (this.orderStatus = data));
            }

        },

        created() {
            this.getStaff();
            this.loadOrders();
            this.loadOrderStatus();
            this.orderStat = this.orderStatus[0];
        }
    };

</script>


<style scoped>

    .btn-add:hover {
        background: -webkit-gradient(linear,left bottom,left top,color-stop(0,#17a2b8),color-stop(1,#1fc8e3));
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }


    .btn-add {
        background: -webkit-gradient(linear,left bottom,left top,color-stop(0,#dc3545),color-stop(1,#e4606d));
        width: 60px;
        font-size: 30px;
        border-radius: 100%;
        bottom: 10%;
        right: 5%;
        position: fixed;
        cursor: pointer;
        z-index: 99;
        
    }

    .w-5 {
        width: 5%;
    }

    .w-10 {
        width: 10%;
    }

    .w-20 {
        width: 20%;
    }
    .w-30 {
        width: 30%;
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
    .btn-view {
        background: #a64dff;
        color: #ffffff;
    }

    .btn-view:hover {
        background: #6610f2;
    }

    .bg-pending {
        background: #7e3878;
    }

    .bg-processing {
        background: #e3a21a;
    }

    .bg-shipping {
        background: #99b433;
    }

    .bg-delivery {
        background: #BE9EC9;
    }



</style>
