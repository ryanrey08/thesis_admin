<template>
   <div class="content">
            <div class="container-fluid">
                <div class="row mt-2">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-hover no-border">
                                <thead class="thead-dark">
                                    <tr>
                                        <th colspan="2">
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
                                        <th class="text-center w-25" >Customer Name</th>
                                        <th class="text-center w-25" >Date of Reservation</th>
                                        <th class="text-center w-10" >IsCancel</th>
                                        <th class="text-center w-10" >IsArrive</th>    
                                        <th class="text-center w-15" >Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="reservations.length == 0">
                                        <td colspan="7" align="center">
                                            <div class="overlay" style="font-size: 25px; font-weight: bolder;">
                                                <i class="fa fa-spinner fa-spin red"></i>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr v-else v-for="reservation in reservations" :key="reservation.id">
                                        <td class="text-center">{{ reservation.id }}</td>
                                        <td class="text-center">{{ reservation.name }}</td>
                                        <td class="text-center">{{ reservation.datetime }}</td>
                                        <td class="text-center">{{ reservation.iscancel == '1' ? 'Yes' : 'No' }}</td>
                                        <td class="text-center">{{ reservation.isarrive == '1' ? 'Yes' : 'No' }}</td>
                                        <td class="text-center">
                                           
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
            reservations: [],
            reservation: new Form({
                id: null,
                userid: null,
                datetime: null,
                isarrive: 0,
                iscancel: 0,
                datetimetoreserve: null
            }),
             user: new Form({
                    id: null,
                    name: null,
                    email: null,
                    password: null
                }),

            searchQuery: '',
        }
    },
    computed: {
         filteredReservations: function() {
                if(this.searchQuery) {
                    return this.reservationsNow.filter((reservation) => {
                        if( (reservation.id.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1) || 
                            (reservation.userid.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1) ||
                            (reservation.datetime.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1)) {
                                return reservation.userid;
                        }
                    })
                } else {
                    return this.reservationsNow;
                }
            }
    },
    methods: {
         loadReservation: function() {

                axios.get('/api/reservation').then(( data ) => {
                this.reservations = data.data;
             });
            },

        getUser: function(id) {
             axios.get('/api/getUser/' + id).then(({ data }) => (this.user = data[0]));
             return this.user.name;
        }
    },
    created() {
        this.loadReservation();
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
    .btn-view {
        background: #a64dff;
        color: #ffffff;
    }

    .btn-view:hover {
        background: #6610f2;
    }

</style>
