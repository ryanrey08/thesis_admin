<template>
    <div class="small-box bg-warning h-100">
        <div class="inner">
        <h3>{{ orders.length }}</h3>

        <p>Orders</p>
        </div>
        <div class="icon">
        <i class="fas fa-shopping-cart"></i>
        </div>

        <router-link to="/orders" class="small-box-footer">
            More info <i class="fas fa-arrow-circle-right"></i>
        </router-link>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                orders: [],
            }
        },
        methods: {
             loadOrders: function() {

                axios.get('/api/orders').then(({ data }) => (this.orders = data));

            },
        },
        created() {
            this.loadOrders();
        }
    };
</script>
