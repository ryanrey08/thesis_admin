<template>
    <div class="small-box bg-info h-100">
        <div class="inner">
        <h3>{{ products.total }}</h3>

        <p>Products</p>
        </div>
        <div class="icon">
        <i class="fas fa-tshirt"></i>
        </div>

        <router-link to="/product" class="small-box-footer">
            More info <i class="fas fa-arrow-circle-right"></i>
        </router-link>
    
    </div>
</template>

<script>
    export default {

        data() {
            return {
                products: {},
            }
        },
        methods: {
            loadProducts: function() {

                axios.get('/api/product').then(( data ) => {this.products = data.data});

            },
        },
        created() {
            this.loadProducts();
        }
    };
</script>
