/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';


Vue.use(VueRouter);




// VFORM
import { Form, HasError, AlertError } from 'vform';

window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);


// VueProgressbar
import VueProgressBar from 'vue-progressbar';

Vue.use(VueProgressBar, {
   color: 'rgb(143, 255, 199)',
   failedColor: 'red',
   height: '3px'
});


// SweerAlert2

import Swal from 'sweetalert2';
window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 4000
});

window.Toast = Toast;


// Fire 
window.Fire = new Vue();



// Laravel Vue Pagination
Vue.component('pagination', require('laravel-vue-pagination'));


// Vue Multiselect
import Multiselect from 'vue-multiselect';
Vue.component('multiselect', Multiselect);



// VuetheMask
import VueTheMask from 'vue-the-mask';
Vue.use(VueTheMask)


// VueMask
import VueMask from 'v-mask';
Vue.use(VueMask);




// MomentJS
import moment from 'moment';

Vue.filter('upText', function(text){
    return text.charAt(0).toUpperCase() + text.slice(1);
});

Vue.filter('cusDate', function(rawDate){
    return moment(rawDate).format('MMMM Do YYYY');
});



// Vee-Validate
import VeeValidate from 'vee-validate';



// StepProgress
import StepProgress from 'vue-step-progress';

import 'vue-step-progress/dist/main.css';

Vue.component('step-progress', StepProgress);




import datePicker from 'vue-bootstrap-datetimepicker';
import 'bootstrap/dist/css/bootstrap.css';
import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
Vue.use(datePicker);

import VueHtmlToPaper from 'vue-html-to-paper';
 
const options = {
  name: '_blank',
  specs: [
    'fullscreen=yes',
    'titlebar=yes',
    'scrollbars=yes'
  ],
  styles: [
    'https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css',
    'https://unpkg.com/kidlat-css/css/kidlat.css',
    '/css/app.css'
  ]
}
 
Vue.use(VueHtmlToPaper, options);




// Vue-toastr-2
import VueToastr2 from 'vue-toastr-2';
import 'vue-toastr-2/dist/vue-toastr-2.min.css';
 
window.toastr = require('toastr');
 
Vue.use(VueToastr2);





$(function () {
    $('[data-toggle="popover"]').popover()
    $('[data-toggle="tooltip"]').tooltip({
        html: true,
    })
});








let routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/pos', component: require('./components/pointofsales/PointOfSales.vue').default },
      { path: '/printreceipt', component: require('./components/pointofsales/POSPrint.vue').default },
    // { path: '/pos/invoice', component: require('./components/pointofsales/Invoice.vue').default },
    { path: '/product', component: require('./components/products/ProductList.vue').default },
    { path: '/product/add', component: require('./components/products/AddProduct.vue').default },
    { path: '/product/:productid/view', component: require('./components/products/ViewProduct.vue').default },
    { path: '/collections', component: require('./components/products/CollectionList.vue').default },
    { path: '/collections/:collectionID/viewcollection', component: require('./components/products/CollectionView.vue').default },
    { path: '/product/:productid/edit', component: require('./components/products/EditProduct.vue').default },
    { path: '/inventory', component: require('./components/inventory/Inventory.vue').default },
    { path: '/porder', component: require('./components/inventory/PurchaseOrder.vue').default },
    { path: '/porder/add', component: require('./components/inventory/AddPurchase.vue').default },
    { path: '/porder/:porderid/view', component: require('./components/inventory/ViewPO.vue').default },
    { path: '/vendor', component: require('./components/inventory/Vendor.vue').default },

    { path: '/porder/:porderid/print', component: require('./components/inventory/PrintPo.vue').default },

    { path: '/orders', component: require('./components/orders/OrderList.vue').default },
    { path: '/orders/:orderid/manage', component: require('./components/orders/ManageOrder.vue').default },
    { path: '/orders/:orderid/view', component: require('./components/orders/ViewOrder.vue').default },

    { path: '/management/staff', component: require('./components/management/StaffList.vue').default },
    { path: '/management/customer', component: require('./components/management/CustomerList.vue').default },

    // { path: '/reservations/reservationall', component: require('./components/reservations/ReservationAll.vue').default },
    // { path: '/reservations/reservationnow', component: require('./components/reservations/ReservationNow.vue').default },

    { path: '/cms/adminpage', component: require('./components/cms/AdminPage.vue').default },
    { path: '/cms/customerpage', component: require('./components/cms/CustomerPage.vue').default },


    { path: '/settings/shipping', component: require('./components/settings/ShipSettings.vue').default },
    { path: '/settings/store', component: require('./components/settings/StoreSettings.vue').default },


];



const router = new VueRouter({
    mode: 'history',
    routes // short version
});






Vue.component('example-component', require('./components/ExampleComponent.vue').default);


const app = new Vue({
    el: '#app',
    router
});
