<template>
	<div class="w-100">

		<div class="content-header ">
			<div class="container-fluid">
				<div class="row m-0">
					<div class="col-4">
						<div class="card">
							<div class="card-body">
								<h5 class="danger font-weight-bold">Order Details</h5>
								
								<p class="small">ORDER #: <strong>{{ orderid }}</strong></p>
								<p class="small">STATUS: <strong><span class="badge white" :class="bg[order.statusid]">{{ order.status }}</span></strong></p>
								<p class="small"><a href="" @click.prevent="">View Processing Timeline</a></p>
							</div>
						</div>
					</div>
					<div class="col-3">
						<div class="card">
							<div class="card-body">
								<h5 class="danger font-weight-bold">Customer Information</h5>
								
								<p class="small">NAME: <strong>{{ customerDetails.name }}</strong></p>
								<p class="small">MOBILE: <strong>{{ customerDetails.phone }}</strong></p>
								<p class="small">EMAIL: <strong>{{ customerDetails.email }}</strong></p>
							</div>
						</div>
					</div>
					<div class="col-5">
						<div class="card">
							<div class="card-body">
								<h5 class="danger font-weight-bold">Shipping & Payment Information</h5>
								
								
								<div class="d-flex justify-content-between">
									<div class="w-50">
										<p class="small">CONSIGNEE: <strong>{{ shippingDetails.name }}</strong></p>
									</div>
											
									<div class="w-50">
										<p class="small">Payment Method: <strong>{{ paymentDetails.name }}</strong></p>
									</div>
								</div>

								<div class="d-flex justify-content-between">
									<div class="w-50">
										<p class="small">MOBILE: <strong>{{ shippingDetails.phone }}</strong></p>
									</div>
											
									<div class="w-50">
										<p class="small">Shipping Method: <strong>J&T Express</strong></p>
									</div>
								</div>
								
								<p class="small">SHIPPING ADDRESS: <strong>{{ getCompleteAddress(shippingDetails) }}</strong></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="content-header">
			<div class="container-fluid">
				<div class="row m-0" >
					<div class="col-12">
						<div class="card">
							<div class="card-body">
								<step-progress :steps="sts" style="transform: scale(0.8, 0.8);" :activeColor="getColor" :current-step="order.statusid" icon-class="fa fa-check"></step-progress>
							</div>
						</div>
					</div>
				</div>
				<div class="row m-0">
					<div class="col-12">
						<div class="card">
							<div class="card-body" >
								<div class="table-responsive">
									<table class="table table-sm table-borderless m-0">
										<thead class="danger">
											<tr>
												<th scope="col" class="text-center w-50">Tracking Number</th>
												<th scope="col" class="text-center w-50">Logistic Staff</th>
												
											</tr>
										</thead>
										<tbody>
											<tr v-for="courier in couriers">
												<td class="text-center">{{ courier.trackingnumber }}</td>
												<td class="text-center">{{ courier.staff }}</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row m-0">
					<div class="col-12">
						<div class="card">
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-sm table-hover table-borderless m-0">
										<thead class="danger">
											<tr>
												<th scope="col" class="text-center w-15">#</th>
												<th scope="col" class="text-center w-40">Item</th>
												<th scope="col" class="text-center w-15">Price</th>
												<th scope="col" class="text-center w-15">Quantity</th>
												<th scope="col" class="text-center w-15">Sub Total</th>
											</tr>
										</thead>
										<tbody>
											<tr v-for="item in items">
												<td class="text-center">{{ item.itemid }}</td>
												<td class="small">
													{{ item.name }}
												</td>
												<td class="text-right">{{ item.price }}</td>
												<td class="text-center">{{ item.quantity }}</td>
												<td class="text-right">{{ getSubTotal(item).toFixed(2) }}</td>
											</tr>
										</tbody>
										<tfoot class="danger">
											<tr>
												<td class="text-right" colspan="4"><h3>Grand Total</h3></td>
												<td class="text-right"><h3>₱ {{ order.total }}</h3></td>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
							<div class="card-footer bg-light text-right">
								<button class="btn bg-processing" v-if="order.statusid == 1" @click="updateOrderStatus">Process Order</button>
								<button class="btn bg-shipping" v-if="order.statusid == 2 && staff.type == 1" @click="confirmDelivery">Process Shipping</button>
								<button class="btn bg-delivery" v-if="order.statusid == 3" @click="updateOrderStatus">Confirm Delivery</button>
								<button class="btn bg-success" v-if="order.statusid == 4" @click="updateOrderStatus">Complete Transaction</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="courier" tabindex="-1" role="dialog" aria-labelledby="courierTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="courierTitle">Logistics Details</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="">Tracking Number #</label>
							<input v-model="courier.trackingnumber" class="form-control" :class="{ 'is-invalid' : courier.errors.has('trackingnumber') }" type="text" name="trackingnumber" placeholder="Tracking Number">
							<has-error :form="courier" field="trackingnumber"></has-error>
						</div>

						<div class="form-group">
							<label for="">Attending Staff</label>
							<input v-model="courier.staff" class="form-control" :class="{ 'is-invalid' : courier.errors.has('staff') }" type="text" name="staff" placeholder="First Last">
							<has-error :form="courier" field="staff"></has-error>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" @click="addCourier">Save changes</button>
					</div>
				</div>
			</div>
		</div>


	</div>
</template>

<script>

	import phil from 'phil-reg-prov-mun-brgy';

	export default {
		data() {
			return {
				orderid: null,
				order: {},
				courier: new Form({
					id: null,
					orderid: null,
					trackingnumber: null,
					staff: null,
				}),
				staff: new Form({
					id: null,
					name: null,
					type: null,
				}),
				couriers: [],
				shippingDetails: {},
				customerDetails: {},
				paymentDetails: {},
				items: [],
				status: [],
				bg: ['bg-danger', 'bg-pending', 'bg-processing', 'bg-shipping', 'bg-delivery', 'bg-success'],
				sts: ["Pending", "Processing", "Shipping", "Delivery", "Complete"],

			}
		},
		computed: {
			getColor: function() {
				let colors = ["#dc3545", "#7e3878", "#e3a21a", "#99b433", "#BE9EC9", "#5cb85c"];

				return colors[this.order.statusid];

			}
		},

		methods: {
			confirmDelivery: function() {
				$('#courier').modal('show');
			},

			addCourier: function() {
				this.courier.orderid = this.orderid;
				this.courier.post('/api/orders/courier/add')
					.then(() => {
						this.$toastr.success('Saved Successfully!', 'Successful!', {"showDuration": "0","timeOut": "3000","showEasing": "swing"});
						this.updateOrderStatus();
					})
			},

			loadCourier: function() {
				axios.get('/api/orders/courier/get/' + this.orderid).then(({ data }) => (this.couriers = data ))
			},

			updateOrderStatus: function() {
				// axios.get('/api/orders/status/update/' + this.orderid).then(( data ) => {
				// 	this.loadOrder();
				// });


				let order = new Form({
					staffid: this.staff.id,
					transactionid: this.order.transactionid
				});

				this.$Progress.start();
				order.post('/api/orders/status/update/'+this.orderid)
					.then(() => {
						this.$Progress.finish();
						Toast.fire({
							type: 'success',
							title: 'Updated Successfully'
						});
						this.loadOrder();
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

			loadOrder: function() {
				axios.get('/api/orders/get/' + this.orderid).then(( data ) => {
					this.order = data.data[0];

					this.loadShippingDetails();
					this.loadCustomerDetails();
					this.loadPaymentDetails();
					this.loadItems();
					this.loadOrderStatus();
					this.loadCourier();
				});
			},

			loadShippingDetails: function() {
				axios.get('/api/customer/address/get/' + this.order.addressid).then(({ data }) => (this.shippingDetails = data[0] ));
			},

			loadCustomerDetails: function() {
				axios.get('/api/customer/get/' + this.order.userid).then(({ data }) => (this.customerDetails = data[0] ));
			},

			loadPaymentDetails: function() {
				axios.get('/api/payments/get/methods/' + this.order.transactionid).then(({ data }) => (this.paymentDetails = data[0] ));
			},

			loadOrderStatus: function() {
                axios.get('/api/orders/status/get').then(({ data }) => (this.status = data));
            },

			loadItems: function() {
				// /items/get/{order}
				axios.get('/api/orders/items/get/' + this.order.transactionid).then(({ data }) => (this.items = data ));
			},

			getCompleteAddress: function(address) {
				return address.housenumber + " " + this.showBarangay(address.barangay) + ", " + this.showCity(address.cityid) + ", " + this.showProvince(address.provinceid);
			},

			showProvince: function(provCode) {
				let provName = null;
				let provinces = phil.provinces;
				for(let index = 0; index < provinces.length; index++) {
					if(Number(provinces[index].prov_code) === Number(provCode)) {
						provName = provinces[index].name;
						break; 
					}
				}

				return provName;
			},
			showCity: function(cityCode) {
				let cityName = null;
				let cities = phil.city_mun;
				for(let index = 0; index < cities.length; index++) {
					if(Number(cities[index].mun_code) === Number(cityCode)) {
						cityName = cities[index].name;
						break; 
					}
				}

				return cityName;
			},
			showBarangay: function(barangay) {
				return barangay;
			},

			getSubTotal: function(item) {
				return (item.price * item.quantity);
			},

			getFinalTotal: function(items) {
				return (Number(this.getTotal(items)) + Number(this.paymentDetails.fee)).toFixed(2);
			},
			getStaff: function() {
				axios.get("/api/profile").then(({data}) => this.staff.fill(data));
			},
		},

		created() {
			this.orderid = this.$route.params.orderid;
			this.getStaff();

			this.loadOrder();
		}
	};
</script>


<style scoped>

	.bg-pending {
		background: #7e3878;
		color: #ffffff;
	}

	.bg-processing {
		background: #e3a21a;
		color: #ffffff;
	}

	.bg-shipping {
		background: #99b433;
		color: #ffffff;
	}

	.bg-delivery {
		background: #BE9EC9;
		color: #ffffff;
	}

	
	.w-5 {
		width: 5%;
	}
	.w-40 {
		width: 40%;
	}
	.w-20 {
		width: 20%;
	}
	.w-10 {
		width: 10%;
	}


	::-webkit-scrollbar-track {
		background: #f1f1f1; 
	}

	::-webkit-scrollbar-thumb {
		background: -webkit-gradient(linear,left bottom,left top,color-stop(0,#dc3545),color-stop(1,#e4606d));
	}


	::-webkit-scrollbar-thumb:hover {
		background: #555; 
	}
</style>