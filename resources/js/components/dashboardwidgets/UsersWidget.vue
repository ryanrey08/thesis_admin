<template>
    <div class="small-box bg-danger h-100">
        <div class="inner">
        <h3>{{ users.length }}</h3>

        <p>Registered Customer</p>
        </div>
        <div class="icon">
        <i class="fas fa-user"></i>
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
                users: [],
            }
        },
        methods: {
            loadUsers: function() {

                axios.get('/api/customer').then(({ data }) => (this.users = data));

            },
        },
        created() {
            this.loadUsers();
        }
    };
</script>
