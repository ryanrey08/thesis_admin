<template>
	<div class="container-fluid" id="printMe">
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-md-12">
						<div class="d-flex justify-content-between">
							<h1 class="m-0 text-dark">PO #{{ porderid }} </h1>
							
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="content">
			<div class="container-fluid">
				
				<div class="row">
					<div class="col-sm-8 border-right">
						<div class="p-2 d-flex">
							<button class="btn btn-outline-info w-25" @click="completeOrder">Mark as Complete</button>
						</div>
						<div class="table shadow shadow-sm ">
							<table class="table table-hover">
								<thead class="thead-light p-2">
									<tr>
										<th scope="col" class="text-center w-10"><i class="far fa-image"></i></th>
										<th scope="col" class="text-left w-30">Item</th>
										<th scope="col" class="text-center w-15">Received</th>
										<th scope="col" class="text-center w-15">Accept <span class="small"><i class="fas fa-circle text-success"></i></span></th>
										<th scope="col" class="text-center w-15">Cancel <span class="small"><i class="fas fa-circle text-warning"></i></span></th>
										<th scope="col" class="text-center w-15">Reject <span class="small"><i class="fas fa-circle text-danger"></i></span></th>
									</tr>
								</thead>
								<tbody style="height: 700px; overflow-y: scroll;">
									<tr v-for="(item, index) in poitems" :key="item.id">
										<td class="text-center"><img :src="item.imgname" width="24"></td>
										<td class="text-left small">{{ item.name }}</td>
										<td class="text-center">
											<div class="progress">
												<div class="progress-bar bg-success" role="progressbar" :style="'width: ' + (item.received * (100 / item.quantity)) + '%'" :aria-valuenow="item.received" aria-valuemin="0" :aria-valuemax="item.quantity"></div>
												<div class="progress-bar bg-warning" role="progressbar" :style="'width: ' + (item.cancelled * (100 / item.quantity)) + '%'" :aria-valuenow="item.cancelled" aria-valuemin="0" :aria-valuemax="item.quantity"></div>
												<div class="progress-bar bg-danger" role="progressbar" :style="'width: ' + (item.rejected * (100 / item.quantity)) + '%'" :aria-valuenow="item.rejected" aria-valuemin="0" :aria-valuemax="item.quantity"></div>
											</div>
											<span class="small">{{ Number(item.received) + Number(item.cancelled) + Number(item.rejected)  }} of {{ item.quantity }} </span>
										</td>
										<td>
											<div class="input-group input-group-sm border border-secondary">
												<input min="0" v-model="item.received"  class="form-control border rounded-right" type="number" @change="checkMax(item, $event, item.cancelled, item.rejected)">
												<div class="input-group-append">
													<button type="button" class="btn btn-light" @click="applyAll(1, item)">All</button>
												</div>
											</div>
										</td>
										<td>
											<div class="input-group input-group-sm border border-secondary">
												<input min="0" v-model="item.cancelled"  class="form-control border rounded-right" type="number" @change="checkMax(item, $event, item.received, item.rejected)">
												<div class="input-group-append">
													<button type="button" class="btn btn-light" @click="applyAll(2, item)">All</button>
												</div>
											</div>
										</td>
										<td>
											<div class="input-group input-group-sm border border-secondary">
												<input min="0" v-model="item.rejected"  class="form-control border rounded-right" type="number" @change="checkMax(item, $event, item.received, item.cancelled)">
												<div class="input-group-append">
													<button type="button" class="btn btn-light" @click="applyAll(3, item)">All</button>
												</div>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>

					</div>
					<div class="col-sm-4">
						<div class="card">
							<div class="card-header no-border">
								<div class="d-flex justify-content-between">
									<h3 class="card-title">PO Details</h3>
								</div>
							</div>
							<div class="card-body">

								<p>Name: {{ porder_details.sourcename }}</p>
								<p>Contact Number: {{ porder_details.phone }}</p>
								<p>Address: {{ porder_details.address }}</p>
								
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">	</div>
					<div class="col-sm-4">	</div>
					<div class="col-sm-4">	
						<div class="card">
							<div class="card-header no-border">
								<div class="d-flex justify-content-between">
									<h3 class="card-title">PO Details</h3>
								</div>
							</div>
							<div class="card-body" v-for="po_history in po_histories">
								<div class="row">
									<div class="col-md-6">
										<p>{{ po_history.staff_name }} </p><p>{{ po_history.action }}</p>
									</div>
									<div class="col-md-6">
										<p>{{ getDate(po_history.created_at) }} </p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>


			<div class="footer p-3 bg-light w-100 border-top border-secondary d-flex justify-content-end">
				<router-link to="/porder" class="btn btn-light w-25" data-toggle="tooltip" title="Discard">
					<span>Discard</span>
				</router-link>
				<button class="btn btn-success w-25" @click="updatePO">Save PO</button>
			</div>
			
		</div>


	</div>
</template>



<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>



<script>
import moment from 'moment';

	export default {
		data() {
			return {
				porderid: null,
				staff: new Form({
					id: null,
					role_id: null,
				}),
				poitems: [],
				porder: new Form({
					poitems: [],
					staff: null,
				}),

				porders: [],
				porder_details: {},
				po_histories: []
			}
		},

		methods: {



			loadPOItems: function() {
				axios.get('/api/porder/get/' + this.porderid ).then(( data ) => { this.poitems = data.data });
			},

			checkAllowed: function(item, e) {

				let remaining = item.quantity - ( item.received + item.cancelled + item.rejected );
				console.log(e.target);
			},

			checkMax: function(item, e, field1, field2) {

				let max = item.quantity - (Number(field1) + Number(field2));

				// console.log("Max : " + max);
				// console.log(e.target);
				if(max > 0) {
					e.target.max = max;
				} else {
					e.target.value = 0;
				}
				
			},

			applyAll: function(itemfield, item) {

				if(itemfield == 1) {
					let rem = item.quantity - (Number(item.received) + Number(item.cancelled) + Number(item.rejected));
					item.received = rem + Number(item.received);
				} else if(itemfield == 2) {
					let rem = item.quantity - (Number(item.received) + Number(item.cancelled) + Number(item.rejected));
					item.cancelled = rem + Number(item.cancelled);
				} else {
					let rem = item.quantity - (Number(item.received) + Number(item.cancelled) + Number(item.rejected));
					item.rejected = rem + Number(item.rejected);
				}
				
				
			},

			completeOrder: function() {
				this.poitems.forEach(function(item) {

					item.cancelled = 0;
					item.rejected = 0;
					item.received = item.quantity;
				})
			},


			updatePO: function() {

				this.porder.poitems = this.poitems;
				this.porder.staff = this.staff;

				this.$Progress.start();
				this.porder.put('/api/porder/' + this.porderid)
					.then(() => {
						this.$Progress.finish();
						Toast.fire({
							icon: 'success',
							title: 'Inventory Updated!'
						});
						window.location.assign("/porder");
					})
					.catch(({error}) => {
						this.$Progress.fail();
						Toast.fire({
							icon: 'danger',
							title: 'Inventory Updated!'
						});
					});
			},

			loadPOItem: function() {
				axios.get('/api/porder/getPo/' + this.porderid ).then(( data ) => { 
					this.porders = data.data;
					this.porder_details = data.data[0];
				});
			},

			getStaff: function() {
				axios.get("/api/profile").then(({data}) => this.staff.fill(data));
			},

			 print: function () {
			      // Pass the element id here
			      // this.$htmlToPaper('printMe');
			      window.open('/print', '_blank');
    		},

    		getPOHistory: function() {
    			axios.get('/api/porder/getPOHistory/' + this.porderid).then(( data ) => { 
					this.po_histories = data.data;
				});
    		},

    		getDate: function(date) {
    			let new_date = moment(date).format("dddd, MMMM Do YYYY, h:mm a");

    			return new_date
    		}


		},

		created: function() {

			this.getStaff();
			this.porderid = this.$route.params.porderid;
			this.loadPOItems();
			this.loadPOItem();
			this.getPOHistory();
			
		}
	};
</script>



<style scoped>

	::-webkit-scrollbar {
		width: 3px;
		height: 3px;
	}


	::-webkit-scrollbar-track {
		background: #f1f1f1; 
	}

	::-webkit-scrollbar-thumb {
		background: -webkit-gradient(linear,left bottom,left top,color-stop(0,#00A591),color-stop(1,#1e7145));
	}


	::-webkit-scrollbar-thumb:hover {
		background: #555; 
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

	.w-35 {
		width: 35%;
	}

	.w-15 {
		width: 15%;
	}

	.w-70 {
		width: 70%;
	}

	.card-header {
		background: #ffffff;
	}

	.card-footer {
		background: #ffffff;
	}

	.imageHolder {
		max-width: 150px;
		max-height: 200px;
	}

	.productImage {
		width: 100%;
		height: 100%;
	}

	.w-40 {
		width: 40%;
	}

	.w-20 {
		width: 20%;
	}

	.btn-save:hover {
		box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
	}


	.btn-save {
		background: -webkit-gradient(linear,left bottom,left top,color-stop(0,#17a2b8),color-stop(1,#1fc8e3));
		padding: 15px;
		font-size: 15px;
		border-radius: 10%;
		bottom: 10%;
		right: 5%;
		position: fixed;
		cursor: pointer;
		z-index: 99;
		color: #ffffff;
		
	}
	
	.btn-cancel:hover {
		box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
	}


	.btn-cancel {
		background: -webkit-gradient(linear,left bottom,left top,color-stop(0,#dc3545),color-stop(1,#e4606d));
		padding: 15px;
		font-size: 15px;
		border-radius: 10%;
		bottom: 10%;
		right: 10%;
		position: fixed;
		cursor: pointer;
		z-index: 99;
		
	}

	textarea {
		resize: none;
	}

	@media print {
  @page {
    size: landscape
  }
}
</style>