<template>

    <div class="w-100">

        

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md">
                        <h1 class="m-0 text-dark">Customers</h1>
                    </div>
                </div>
               <!--  <button  class="btn btn-add" trigger="hover" data-toggle="tooltip" title="Add New Staff" @click="addStaff">
                    <i class="fas fa-user-plus white" aria-hidden="true"></i>
                </button> -->
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row mt-2">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-hover no-border">
                                <thead class="thead-dark">
                                    <tr>
                                        <th colspan="2">
                                            <select v-model="filter" class="custom-select">
                                                <option v-for="(filter, index) in filters" :key="index" :value="filter">{{ filter }}</option>
                                            </select>
                                        </th>
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
                                        <th class="text-center w-5" >#</th>
                                        <th class="text-center w-10"><i class="fas fa-image"></i></th>
                                        <th class="text-center w-25" >Name</th>
                                        <th class="text-center w-25" >Email Address</th>
                                        <th class="text-center w-10" v-if="filter == 'Archived'">Archived At</th>    
                                        <th class="text-center w-10" v-else>Status</th>
                                        <th class="text-center w-15" >Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="customers.length == 0">
                                        <td colspan="7" align="center">
                                            <div class="overlay" style="font-size: 25px; font-weight: bolder;">
                                                <i class="fa fa-spinner fa-spin red"></i>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr v-else v-for="customer in customers" :key="customer.id">
                                        <td class="text-center">{{ customer.id }}</td>
                                        <td class="text-center"><img :src="customer.photo" width="24"></td>
                                        <td class="text-center">{{ customer.name }}</td>
                                        <td class="text-center">{{ customer.email }}</td>
                                       <!--  <td class="text-center">{{ customer.type == '2' ? 'Staff' : 'Administrator' }}</td> -->
                                        <td align="center" v-if="filter == 'Archived'">
                                            <span>{{ customer.updated_at | cusDate }}</span>
                                        </td>
                                        <td align="center" v-else>
                                            <span class="badge badge-pill" :class="[customer.isactive == 1 ? 'badge-info' : 'badge-secondary']">{{ customer.isactive == 1 ? "Active" : "Archived" }}</span>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-warning btn-sm" trigger="hover" data-toggle="tooltip" title="View Details" v-if="customer.isactive == 1" @click="viewCustomer(customer)"><i class="far fa-fw fa-eye"></i></button>
    
                                           <!--  <button class="btn btn-danger btn-sm" trigger="hover" data-toggle="tooltip" title="Archive Staff" v-if="staff.customer == 1" @click="deleteStaff(customer.id)"><i class="fas fa-trash"></i></button>

                                            <button class="btn btn-info btn-sm" trigger="hover" data-toggle="tooltip" title="Restore Staff" v-if="customer.isactive == 0" @click="restoreStaff(customer.id)"><i class="fas fa-trash-restore"></i></button> -->
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="viewCustomer" tabindex="-1" role="dialog" aria-labelledby="addStaffLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content" >

                        <div class="modal-header">
                            <h5 class="modal-title" id="addStaffLabel">Customer Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form >

                            <div class="modal-body">

                                <div class="row">

                                    <div class="col">

                                        <h4 class="display-6">Account Information</h4>

                                        
                                        <label for="">Name</label>
                                        <div class="input-group mb-3">

                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user-tag fa-fw"></i></span>
                                            </div>

                                            <input v-model="newCustomer.name" class="form-control" type="text" name="name" placeholder="Full Name" disabled="true">

                                        </div>
                                        
                                         <label for="">E-mail</label>
                                        <div class="input-group mb-3">

                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-user-lock fa-fw"></i></span>
                                            </div>

                                            <input v-model="newCustomer.email" class="form-control" type="email" name="email" placeholder="Email Address" disabled="true">
                                        </div>

                                        <!-- <div class="input-group mb-3">

                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-user-lock fa-fw"></i></span>
                                            </div>

                                            <input v-model="staff.password" class="form-control" :class="{ 'is-invalid' : staff.errors.has('password') }" type="password" name="password" placeholder="Password">

                                            <has-error :form="staff" field="password"></has-error>

                                        </div> -->

                                       <!--  <div class="input-group mb-3" v-if="!updateMode">

                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-user-lock fa-fw"></i></span>
                                            </div>

                                            <input v-model="staff.confirm" class="form-control" :class="{ 'is-invalid' : staff.errors.has('confirm') }" type="password" name="confirm" placeholder="Confirm Password">

                                            <has-error :form="staff" field="confirm"></has-error>

                                        </div> -->

                                    </div>

                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>

                        </form>

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
                newCustomer: new Form({
                    id: null,
                    name: null,
                    email: null,
                    photo: null,
                    isactive: null
                }),
                
                customers: [],
                filters: ["All", "Archived", "Unarchived"],
                searchQuery: '',
                updateMode: false,


                // Watched Data
                
                // filteredProducts: [],
                
                filter: null,
                // activeStaff: new Form({
                //     id: null,
                //     name: null,
                //     type: null,
                // }),
                

            }
        },

        computed: {
            filteredStaffs: function() {
                if(this.searchQuery) {
                    return this.customers.filter((customer) => {
                        if( (customer.id.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1) || 
                            (customer.name.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1) ||
                            (customer.email.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1)) {
                                return customer.name;
                        }
                    })
                } else {
                    return this.customer;
                }
            }
        },


        methods: {

            // getVariants: function() {
            //     axios.get('/api/product/variants/get/'+product.id).then(({ data }) => ( product.variants = data ))
            // },

            // getActiveStaff: function() {
            //     axios.get("/api/profile").then(({data}) => this.activeStaff.fill(data));
            // },
            viewCustomer: function(customer) {
                $('#viewCustomer').modal('show');
                this.newCustomer.fill(customer)
            },

            loadCustomers: function() {

                axios.get('/api/customer').then(({ data }) => (this.customers = data));
                this.filter = "All";

            }

        },

        created() {
            //this.getActiveStaff();
            this.loadCustomers();

            Fire.$on('AfterCreate', () => {
                this.loadCustomers();
            });
        }
    }

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



</style>
