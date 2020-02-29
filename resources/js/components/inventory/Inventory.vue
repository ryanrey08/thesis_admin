<template>

	<div class="container-fluid">
		<div class="jumbotron">
			<h1>Inventory</h1>
		</div>

		<div class="content">
			<div class="container-fluid">
				<div class="row mt-2">
					<div class="col-sm-12">
						<div class="content ">
							<div class="row">
								<div class="col-9">
									<div class="input-group border border-secondary">
										<div class="input-group-prepend">
											<button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown">
												Filter
											</button>
											<ul class="dropdown-menu">
												<li class="dropdown-item"><a href="#">Action</a></li>
												<li class="dropdown-item"><a href="#">Another action</a></li>
												<li class="dropdown-item"><a href="#">Something else here</a></li>
												<li class="dropdown-divider"></li>
												<li class="dropdown-item"><a href="#">Separated link</a></li>
											</ul>
										</div>
										<input v-model="searchQuery" @keyup="searchItem" class="form-control border rounded-right" placeholder="Search" aria-label="Search">
										<div class="input-group-append">
											<button type="button" class="btn btn-light">Search</button>
										</div>
									</div>
								</div>
								<div class="col-3">
									<div class="input-group border border-secondary">
										<div class="input-group-prepend">
											<span class="input-group-text bg-light border-0">Sort By:</span>
										</div>
										<select v-model="filter" class="custom-select border-0">
											<option v-for="(filter, index) in filters" :key="index" :value="filter">{{ filter }}</option>
										</select>

									</div>
								</div>
							</div>

						</div>
						<div class="table shadow shadow-sm">
							<table class="table table-hover bg-light">
								<thead class="thead-light p-2">
									<tr>
										<th class="text-center w-5">
											<div class="custom-control custom-checkbox">
												<input class="custom-control-input" type="checkbox" id="checkAll">
												<label class="custom-control-label text-muted" for="checkAll">
												</label>
											</div>
										</th>
										<th class="text-center w-25">Product</th>
										<th class="text-center w-20">SKU</th>
										<th class="text-center w-10">Incoming</th>
										<th class="text-center w-10">Available</th>
										<th class="text-center w-25">Edit Quantity Available</th>
									</tr>
								</thead>
								<tbody class="border">
									<tr v-for="item in items.data" :key="item.id" :class="{ 'table-danger': item.quantity == 0, 'table-warning': item.quantity <= item.threshold }">
										<td class="text-center">
											<div class="custom-control custom-checkbox">
												<input class="custom-control-input" type="checkbox" :id="item.id">
												<label class="custom-control-label text-muted" :for="item.id">
												</label>
											</div>
										</td>
										<td @click="showHistory(item.id)">{{ item.name }}</td>
										<td class="text-center" @click="showHistory(item.id)">{{ item.sku }}
											<div class="modal fade" id="history" tabindex="-1" role="dialog" aria-labelledby="addStaffLabel" aria-hidden="true">
												<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
													<div class="modal-content" >

														<div class="modal-header">
															<h5 class="modal-title" id="addStaffLabel"><i class="fa fa-fw"aria-hidden="true"></i>Inventory History</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>

														<div class="modal-body">

															<div class="row">
																<div class="col-sm-12">
																	<div class="table-responsive">
																		<table class="table table-hover no-border">
																			<thead class="thead-dark">

																				<tr>
																					<th class="text-center w-25" >Date</th>
																					<th class="text-center w-25" >Event</th>
																					<th class="text-center w-25" >Adjusted By</th>    
																					<th class="text-center w-10" >Adjustment</th>
																					<th class="text-center w-15" >Quantity</th>
																				</tr>
																			</thead>
																			<tbody>
																				<tr v-for="history in histories" :key="history.id">
																					<td class="text-center">{{ getDate(history.created_at) }}</td>
																					<td class="text-center" v-if="history.description_type == 0">{{ history.event_description }}</td>
																					<td class="text-center" v-else>{{ history.event_description }}<a v-if="history.event_id == 3" :href="'/porder/'+ history.description + '/view'"> (# {{ history.description }}) </a>
																						<a v-else></a></td>
																					<td class="text-center">{{ history.staff_name }}</td>
																					<td class="text-center">{{ history.adjustments }}</td>
																					<td class="text-center small">{{ history.quantity }}</td>
																				</tr>
																			</tbody>
																		</table>
																	</div>
																</div>
															</div>

														</div>

														<div class="modal-footer">
															<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
														</div>

													</div>

												</div>
											</div>
										</td>
										<td class="text-center" @click="showHistory(item.id)">0</td>

										<td class="text-center" @click="showHistory(item.id)">
											{{ item.quantity }}
											<span class='text-dark font-weight-bolder' v-if="item.newQty > 0 ">> {{ item.updatetype == 1 ? Number(item.quantity) + Number(item.newQty) : Number(item.newQty) }} </span>
										</td>
										<td>
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="btn-group btn-group-toggle" data-toggle="buttons">
														<label class="btn btn-outline-secondary active">
															<input type="radio" :name="item.id" :id="item.id" value="1" autocomplete="off" @click="changeSelection(item)" checked="true" v-model="item.update">Add
														</label>
														<label class="btn btn-outline-secondary">
															<input type="radio" :name="item.id" :id="item.id" value="2" autocomplete="off" @click="changeSelection(item)" v-model="item.update">Set
														</label>
													</div>
												</div>
												<input type="number" class="form-control" placeholder="0" v-model="item.newQty">
												<div class="input-group-append">
													<button type="button" class="btn btn-outline-success" @click="updateItem(item)">Save</button>
												</div>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<pagination :data="items" @pagination-change-page="getResults"></pagination>
					</div>
				</div>
			</div>

		</div>

	</div>


</template>

<script>

import moment from 'moment';

export default {

	data() {
		return {

				// Data Handlers
				items: {},


				// Watched Data
				item: new Form({
					id: null,
					productID: null,
					name: null,
					price: null,
					quantity: null,
					combination: null,
				}),
				
				// filteredProducts: [],
				filters: ["All", "Unpublished", "Published"],



				filter: "",
				searchQuery: "",

				histories: [],
				staff: new Form({
					id: null,
					name: null
				})
			}
		},
		computed: {
			filteredItems (){
				if(this.searchQuery){
					return this.items.filter((item)=>{
						if( (item.id.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1) || (item.price.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1) || (item.quantity.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1) || (item.name.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1)) {
							return item.name;
						}
					})
				}else{
					return this.items;
				}
			}
		},

		methods: {
			editItem: function(item) {
				this.item.reset();
				this.item.fill(item);
				$('#editItem').modal('show');
			},

			getSelected: function(id) {
				let updates = document.getElementsByName(id);
				let upd = 1;
				if(updates[1].checked == true) {
					upd = updates[1].value;
				} else {
					upd = updates[0].value;
				}

				return upd;
			},

			changeSelection: function(item) {
				let options = document.getElementsByName(item.id);
				if(options[1].checked == true) {
					item.updatetype = options[1].value;
				} else {
					item.updatetype = options[0].value;
				}
			},

			updateItem: function(itm) {

				let update = this.getSelected(itm.id);

				let itms = new Form({
					id: itm.id,
					productID: itm.product_id,
					name: itm.name,
					price: itm.price,
					quantity: itm.quantity,
					combination: null,
					newQty: itm.newQty,
					updatetype: update, 
					staff: this.staff,
				});

				this.$Progress.start();
				itms.put('/api/inventory/'+ itm.id)
				.then(() => {
					this.$Progress.finish();
						// $('#editItem').modal('hide');
						Toast.fire({
							icon: 'success',
							title: 'Item Updated Successfully'
						});
						this.loadItems();
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

			searchItem: _.debounce(function() {
				axios.get('/api/inventory/search?item=' + this.searchQuery)
				.then(response => {
					this.items = response.data;
				})
				.catch((error) => {

				})
			}, 1000),

			getResults: function(page = 1) {
				axios.get('/api/inventory?page=' + page)
				.then(response => {
					this.items = response.data;
				});
			},

			loadItems: function() {

				axios.get('/api/inventory').then(( data ) => {this.items = data.data});
				this.filter = "All";

			},

			showHistory: function(id) {
				$('#history').modal('show');
				axios.get('/api/inventory/getHistory/' + id ).then(( data ) => { 
					this.histories = data.data;
				});

			},

			getStaff: function() {
				axios.get("/api/profile").then(({ data }) => this.staff.fill(data))
			},

			getDate: function(date) {
				let date_now = moment();
				let new_date = moment(date);
				let duration = moment.duration(date_now.diff(new_date));
				let days = duration.asHours();

				let history_date = moment().subtract(days, 'hours').calendar();
				return history_date;
			},

			getDescription: function(desc_type_id) {
				if(desc_type_id == 0){
					return
				}
			}
		},

		created() {

			this.loadItems();
			this.getStaff();

		}


	};

	</script>


	<style scoped>

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
