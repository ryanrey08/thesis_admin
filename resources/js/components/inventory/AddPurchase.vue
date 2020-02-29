<template>
	<div class="container-fluid">
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-md-12">
						<h1 class="m-0 text-dark">Create Purchase Order</h1>
					</div>
				</div>
			</div>
		</div>


		<div class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-8 border-right">
						
						<div class="table shadow shadow-sm ">
							<table class="table table-hover">
								<thead class="thead-light p-2">
									<tr>
										<th scope="col" class="text-center w-10"><i class="far fa-image"></i></th>
										<th scope="col" class="text-left w-50">Item</th>
										<th scope="col" class="text-center w-10">Quantity</th>
										<th scope="col" class="text-center w-10">Action</th>
									</tr>
								</thead>
								<tbody style="height: 700px; overflow-y: scroll;">
									<tr>
										<td colspan="4">
											<button type="button" class="btn btn-light border border-dark form-control" data-toggle="modal" data-target="#searchItem"><i class="fas fa-plus"></i>Add Items</button>
										</td>
									</tr>
									<tr v-for="(item, index) in selectedItems" :key="item.id">
										<td class="text-center"><img :src="item.imgname" width="24"></td>
										<td class="text-left">{{ item.name }}</td>
										<td class="text-center">
											<input type="number"class="form-control" min="0" value="0" v-model="item.newQty">
										</td>
										<td class="text-center">
											<button type="button" class="btn btn-danger btn-sm" @click="removeFromPO(index)">Remove</button>
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
									<h3 class="card-title">Sources</h3>
								</div>
							</div>

							<div class="card-body">
								<multiselect v-model="porder.source" deselect-label="Can't deselect" track-by="id" label="name" placeholder="Search source" open-direction="bottom"
									:options="sources" 
									:searchable="true"
									:allow-empty="false"
									:hide-selected="true">
								</multiselect>
							</div>
						</div>
						<div class="card">
							<div class="card-header no-border">
								<div class="d-flex justify-content-between">
									<h3 class="card-title">Shipment</h3>
								</div>
							</div>

							<div class="card-body">
								<!-- <date-picker v-model="date" @dp-hide="doSomethingOnHide" @dp-change="doSomethingOnChange"></date-picker> -->
								<label>Expected arrival date</label>
								<date-picker v-model="porder.expected_arrival" :config="{format: 'YYYY-MM-DD', useCurrent: true}"></date-picker>
							</div>
						</div>
						<div class="card">
							<div class="card-header no-border">
								<div class="d-flex justify-content-between">
									<h3 class="card-title">Additional Details</h3>
								</div>
							</div>

							<div class="card-body">
								<!-- <date-picker v-model="date" @dp-hide="doSomethingOnHide" @dp-change="doSomethingOnChange"></date-picker> -->
								<label>Reference Number</label>
								<input type="text" class="form-control" v-model="porder.ref_number">
							</div>
						</div>
					</div>
				</div>
			</div>


			<div class="footer p-3 bg-light w-100 border-top border-secondary d-flex justify-content-end">
				<router-link to="/porder" class="btn btn-light w-25" data-toggle="tooltip" title="Discard">
					<span>Discard</span>
				</router-link>
				<button class="btn btn-success w-25"  @click="createPO" data-toggle="tooltip" title="Create Purchase Order">Save PO</button>
			</div>
			
			<div class="modal fade" id="searchItem" tabindex="-1" role="dialog" aria-labelledby="searchItemTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
					<div class="modal-content">
						<div class="modal-header">

							<div class="input-group border border-secondary">
								<button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown">Filter</button>
								<ul class="dropdown-menu">
									<li class="dropdown-item"><a href="#">Action</a></li>
									<li class="dropdown-item"><a href="#">Another action</a></li>
									<li class="dropdown-item"><a href="#">Something else here</a></li>
									<li class="dropdown-divider"></li>
									<li class="dropdown-item"><a href="#">Separated link</a></li>
								</ul>
								<input v-model="searchQuery" class="form-control border rounded-right" placeholder="Search items.." aria-label="Search">
								<div class="input-group-append">
									<button type="button" class="btn btn-light">Search</button>
								</div>
							</div>
							
						</div>
						<div class="modal-body">
							<div class="table shadow shadow-sm">
							<table class="table table-hover bg-light">
								<thead class="thead-light p-2">
									<tr>
										<th scope="col" class="text-center w-10"><i class="far fa-image"></i></th>
										<th scope="col" class="text-left w-30">Item</th>
										<th scope="col" class="text-center w-25">Price</th>
										<th scope="col" class="text-center w-20">Available Quantity</th>
										<th scope="col" class="text-center w-15">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="item in filteredItems" :key="item.id" :class="{ 'table-danger': item.quantity == 0, 'table-warning': item.quantity <= item.threshold }">
										<td class="text-center"><img :src="item.imgname" width="24"></td>
										<td class="text-left">{{ item.name }}</td>
										<td class="text-center">{{ item.price }}</td>
										<td class="text-center">{{ item.quantity }}</td>
										<td class="text-center">
											<button type="button" class="btn btn-info btn-sm" @click="addToPO(item)">Add to PO</button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
							<!-- <button type="button" class="btn btn-primary|secondary|success|danger|warning|info|light|dark">Save changes</button> -->
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
				date: null,
				staff: new Form({
					id: null,
					name: null,
				}),
				
				items: [],
				searchQuery: '',
				selectedItems: [],
				sources: [],
				selectedSource: {},

				porder: new Form({
					staff: {},
					selectedItems: [],
					source: {},
					expected_arrival: null,
					ref_number: null,
				})
				
				

			}

		},

		computed: {
			filteredItems (){
				let filtered = this.items.filter((item) => {
					if(this.selectedItems.findIndex(sel => sel.id === item.id) == -1) {
						return item.name;
					}
				});

				if(this.searchQuery){
					return filtered.filter((item)=>{
						if( (item.name.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1) || (item.price.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1) || (item.quantity.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1)) {
							return item.name;
						}
					})
				} else {
					return filtered;
				}

			}
		},

		methods: {

			createPO: function() {
				this.porder.selectedItems = this.selectedItems;
				this.porder.staff = this.staff;
				this.$Progress.start();
				this.porder.post('/api/porder')
				.then(() => {
					this.$Progress.finish();
					Toast.fire({
						icon: 'success',
						title: 'PO Created Successfully'
					});
					Fire.$emit('POCreate');
				})
				.catch(({error}) => { this.$Progress.finish(); });
			},

			searchItem: _.debounce(function() {
				axios.get('/api/inventory/all/search?item=' + this.searchQuery)
					.then(response => {
						this.items = response.data;
					})
					.catch((error) => {

					})
			}, 1000),
			
			loadItems: function() {

				axios.get('/api/inventory/get').then(( data ) => {this.items = data.data});
				this.filter = "All";

			},

			loadSources: function() {
				axios.get('/api/source/get').then(( data ) => {this.sources = data.data});
			},

			getStaff: function() {
				axios.get("/api/profile").then(({data}) => this.staff.fill(data));
			},

			addToPO: function(item) {
				if(!this.checkList(item)) {
					this.selectedItems.push(item);
					Toast.fire({
						icon: 'success',
						title: item.name + ' added to list successfully!',
						position: 'top'
					})
					// this.$toastr.success('Message', 'Title', {"showDuration": "0","timeOut": "1500","showEasing": "swing","positionClass": "toast-bottom-center", "showMethod": "slideDown", "hideMethod": "fadeOut"});
				} else {
					// this.$toastr.error('Message', 'Title', {"showDuration": "0","timeOut": "1500","showEasing": "swing","positionClass": "toast-bottom-center", "showMethod": "slideDown", "hideMethod": "fadeOut"});
				}


				
			},

			removeFromPO: function(item) {
				this.selectedItems.splice(item, 1);
				// alert(item);
			},

			checkList: function(chkItem) {
				let found = false;

				found = this.selectedItems.find(item => item.id == chkItem.id);
				return found;
			}
		},

		created: function() {
			this.getStaff();
			this.loadItems();
			this.loadSources();
			// $('[data-toggle="tooltip"]').tooltip('hide'); 
			Fire.$on('POCreate', () => {
				window.location.assign("/porder");
			});
		}
	};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>


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
</style>
