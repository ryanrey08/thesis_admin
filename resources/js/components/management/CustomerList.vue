<template>

    <div class="w-100">

        

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md">
                        <h1 class="m-0 text-dark">Staffs</h1>
                    </div>
                </div>
                <button  class="btn btn-add" trigger="hover" data-toggle="tooltip" title="Add New Staff" @click="addStaff">
                    <i class="fas fa-user-plus white" aria-hidden="true"></i>
                </button>
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
                                        <th class="text-center w-10" >Role</th>
                                        <th class="text-center w-10" v-if="filter == 'Archived'">Archived At</th>    
                                        <th class="text-center w-10" v-else>Status</th>
                                        <th class="text-center w-15" >Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="staffs.length == 0">
                                        <td colspan="7" align="center">
                                            <div class="overlay" style="font-size: 25px; font-weight: bolder;">
                                                <i class="fa fa-spinner fa-spin red"></i>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr v-else v-for="staff in filteredStaffs" :key="staff.id">
                                        <td class="text-center">{{ staff.id }}</td>
                                        <td class="text-center"><img :src="staff.photo" width="24"></td>
                                        <td class="text-center">{{ staff.name }}</td>
                                        <td class="text-center">{{ staff.email }}</td>
                                        <td class="text-center">{{ staff.type == '2' ? 'Staff' : 'Administrator' }}</td>
                                        <td align="center" v-if="filter == 'Archived'">
                                            <span>{{ staff.updated_at | cusDate }}</span>
                                        </td>
                                        <td align="center" v-else>
                                            <span class="badge badge-pill" :class="[staff.active == 1 ? 'badge-info' : 'badge-secondary']">{{ staff.active == 1 ? "Active" : "Archived" }}</span>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-warning btn-sm" trigger="hover" data-toggle="tooltip" title="Edit Staff" v-if="staff.active == 1" @click="editStaff(staff)"><i class="fas fa-pencil-alt"></i></button>
    
                                            <button class="btn btn-danger btn-sm" trigger="hover" data-toggle="tooltip" title="Archive Staff" v-if="staff.active == 1" @click="deleteStaff(staff.id)"><i class="fas fa-trash"></i></button>

                                            <button class="btn btn-info btn-sm" trigger="hover" data-toggle="tooltip" title="Restore Staff" v-if="staff.active == 0" @click="restoreStaff(staff.id)"><i class="fas fa-trash-restore"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="addStaff" tabindex="-1" role="dialog" aria-labelledby="addStaffLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content" >

                        <div class="modal-header">
                            <h5 class="modal-title" id="addStaffLabel"><i class="fa fa-fw" :class="[updateMode ? 'fa-user-edit' : 'fa-user-plus']" aria-hidden="true"></i>{{ updateMode ? " Edit Staff" : " Add New Staff" }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form @submit.prevent="updateMode ? updateStaff() : saveStaff() ">

                            <div class="modal-body">

                                <div class="row">

                                    <div class="col">

                                        <h4 class="display-6">Account Information</h4>

                                        <div class="input-group mb-3">

                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user-tag fa-fw"></i></span>
                                            </div>

                                            <input v-model="staff.name" class="form-control" :class="{ 'is-invalid' : staff.errors.has('name') }" type="text" name="name" placeholder="Full Name">

                                            <has-error :form="staff" field="name"></has-error>

                                        </div>

                                        <div class="form-group">

                                            <label for="">Role</label>
                                            <select v-model="staff.type" class="custom-select" name="type" id="type">
                                                <option selected value="1">Administrator</option>
                                                <option value="2">Staff</option>
                                            </select>

                                            <has-error :form="staff" field="type"></has-error>

                                        </div>

                                        <div class="input-group mb-3" v-if="!updateMode">

                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-user-lock fa-fw"></i></span>
                                            </div>

                                            <input v-model="staff.email" class="form-control" :class="{ 'is-invalid' : staff.errors.has('email') }" type="email" name="email" placeholder="Email Address">

                                            <has-error :form="staff" field="email"></has-error>

                                        </div>

                                        <div class="input-group mb-3" v-if="!updateMode">

                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-user-lock fa-fw"></i></span>
                                            </div>

                                            <input v-model="staff.password" class="form-control" :class="{ 'is-invalid' : staff.errors.has('password') }" type="password" name="password" placeholder="Password">

                                            <has-error :form="staff" field="password"></has-error>

                                        </div>

                                        <div class="input-group mb-3" v-if="!updateMode">

                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-user-lock fa-fw"></i></span>
                                            </div>

                                            <input v-model="staff.confirm" class="form-control" :class="{ 'is-invalid' : staff.errors.has('confirm') }" type="password" name="confirm" placeholder="Confirm Password">

                                            <has-error :form="staff" field="confirm"></has-error>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">{{ updateMode ? " Apply Changes" : " Save" }}</button>
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
                staff: new Form({
                    id: null,
                    name: null,
                    type: 1,
                    email: null,
                    password: null,
                    slug: null,
                    confirm: null
                }),
                
                staffs: [],
                filters: ["All", "Archived", "Unarchived"],
                searchQuery: '',
                updateMode: false,


                // Watched Data
                
                // filteredProducts: [],
                
                filter: null,
                activeStaff: new Form({
                    id: null,
                    name: null,
                    type: null,
                }),
                

            }
        },

        computed: {
            filteredStaffs: function() {
                if(this.searchQuery) {
                    return this.staffs.filter((staff) => {
                        if( (staff.id.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1) || 
                            (staff.name.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1) ||
                            (staff.email.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1)) {
                                return staff.name;
                        }
                    })
                } else {
                    return this.staffs;
                }
            }
        },


        methods: {

            // getVariants: function() {
            //     axios.get('/api/product/variants/get/'+product.id).then(({ data }) => ( product.variants = data ))
            // },

            getActiveStaff: function() {
                axios.get("/api/profile").then(({data}) => this.activeStaff.fill(data));
            },

            loadStaffs: function() {

                axios.get('/api/staff').then(({ data }) => (this.staffs = data, this.newStaffs = data));
                this.filter = "All";

            },

            addStaff: function() {
                this.updateMode = false;
                this.staff.reset();
                $('#addStaff').modal('show');

            },

            saveStaff: function(){
                this.$Progress.start();
                this.staff.post('/api/staff')
                    .then(() => {
                        this.$Progress.finish();
                        $('#addStaff').modal('hide');
                        Toast.fire({
                            type: 'success',
                            title: 'Staff Created Successfully'
                        });
                        Fire.$emit('AfterCreate');
                    })
                    .catch(({error}) => { this.$Progress.finish(); });
            },

            editStaff: function(staff) {
                this.updateMode = true;
                this.staff.reset();
                $('#addStaff').modal('show');
                this.staff.fill(staff);
            },

            updateStaff: function(id) {
                this.$Progress.start();
                this.staff.put('/api/staff/'+this.staff.id)
                    .then(() => {
                        this.$Progress.finish();
                        $('#addStaff').modal('hide');
                        Toast.fire({
                            type: 'success',
                            title: 'Staff Updated Successfully'
                        });
                        Fire.$emit('AfterCreate');
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

            deleteStaff: function(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {

                    if(result.value){
                        this.$Progress.start();
                        this.staff.delete('/api/staff/'+id)
                            .then(() => {
                                this.$Progress.finish();
                                Swal.fire(
                                    'Deleted!',
                                    'A record has been deleted.',
                                    'success')
                                Fire.$emit('AfterCreate');
                            })
                            .catch(() => {
                                this.$Progress.finish();
                                Swal.fire(
                                    'Failed', "There's something wrong.",
                                    'warning'
                                )
                            });
                    }
                });
            },

            restoreStaff: function(id) {
                Swal.fire({
                    title: 'Restore Account',
                    text: "Restore account?",
                    type: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Restore'
                }).then((result) => {

                    if(result.value){
                        this.$Progress.start();
                        this.staff.get('/api/staff/restore/'+id)
                            .then(() => {
                                this.$Progress.finish();
                                Swal.fire(
                                    'Restored!',
                                    'A record has been restored.',
                                    'success')
                                Fire.$emit('AfterCreate');
                            })
                            .catch(() => {
                                this.$Progress.finish();
                                Swal.fire(
                                    'Failed', "There's something wrong.",
                                    'warning'
                                )
                            });
                    }
                });
            },


        },

        created() {
            this.getActiveStaff();
            this.loadStaffs();

            Fire.$on('AfterCreate', () => {
                this.loadStaffs();
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
