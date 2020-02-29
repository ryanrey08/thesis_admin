<template>

	<div class="container-fluid">

		<div class="jumbotron">
			<div class="d-flex align-items-end justify-content-between">
				<h1>Products</h1>
				<router-link to="/product/add" class="btn btn-success" trigger="hover" data-toggle="tooltip" title="Add New Product">
					<span><i class="fa fa-plus-circle white" aria-hidden="true"></i> Add New Product</span>
				</router-link>
			</div>
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
										<input v-model="searchQuery" @keyup="searchProduct" class="form-control border rounded-right" placeholder="Search" aria-label="Search">
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
										<th class="text-center w-10">#</th>
										<th class="text-center w-10"><i class="fas fa-image"></i></th>
										<th class="text-center w-30">Product</th>
										<th class="text-center w-25">Inventory</th>
										<th class="text-center w-10">Category</th>
										<th class="text-center w-15">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr v-if="products.total == 0">
										<td colspan="6" align="center">
											<div class="overlay" style="font-size: 25px; font-weight: bolder;">
												<i class="fa fa-spinner fa-spin red"></i>
											</div>
										</td>
									</tr>

									<tr v-else v-for="product in products.data" :key="product.id">
										<td class="text-center">{{ product.id }}</td>
										<td class="text-center"><img :src="product.imgname" width="24"></td>
										<td class="text-center" :class="product.name.length > 50 ? 'small' : ''">{{ product.name }}</td>
										<td class="text-center">
											{{ product.qty }} items with {{ product.combination.trim() == 'NONE' ? 0 : product.variantcount }} variants
										</td>
										<td class="text-center" :class="product.categoryname.length > 20 ? 'small' : ''">{{ product.categoryname }}</td>
										<td>
											<div class="btn-group">
												<button class="btn btn-info btn-sm" trigger="hover" data-toggle="tooltip" title="Add Discount" @click="addDiscount(product)" v-if="product.discounttype == 0"><i class="fas fa-fw fa-percentage"></i></button>
												<button class="btn btn-info btn-sm" trigger="hover" data-toggle="tooltip" title="Edit Discount" @click="editDiscount(product)" v-if="product.discounttype != 0"><i class="fas fa-fw fa-paw"></i></button>
												<router-link :to="{ path: '/product/'+product.id+'/edit', params: { productid: product.id } }" cclass="btn btn-warning btn-sm" trigger="hover" data-toggle="tooltip" title="Edit Product"><i class="fas fa-fw fa-pencil-alt"></i></router-link>
												<router-link :to="{ path: '/product/'+product.id+'/view', params: { productid: product.id } }" class="btn btn-view btn-sm" trigger="hover" data-toggle="tooltip" title="View Product in Store"><i class="fas fa-fw fa-eye"></i></router-link>
												<button class="btn btn-success btn-sm" trigger="hover" data-toggle="tooltip" title="Post Product" v-if="staff.role_id == 4 && product.ispublished == 0" @click="postProduct(product.id)"><i class="fas fa-fw fa-check"></i></button>
												<button class="btn btn-danger btn-sm" trigger="hover" data-toggle="tooltip" title="Post Product" v-if="staff.role_id == 4 && product.ispublished == 1" @click="hideProduct(product.id)"><i class="fas fa-fw fa-trash"></i></button>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>

						<pagination :data="products" @pagination-change-page="getResults"></pagination>
					</div>
				</div>
			</div>

			<div class="modal fade" id="discountModal" aria-modal="true">
				<div class="modal-dialog modal-dialog-centered modal-m">
					<div class="modal-content r">
						<div class="modal-header">
							<h6 class="modal-title">{{ selectedProduct.name }}</h6>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>

						<div class="modal-body">
							<h4 class="small"></h4>
							<div class="row">
								<div class="col-6">
									<div class="custom-control custom-radio custom-control-inline">
										<input type="radio" class="custom-control-input" checked id="percentage" name="discounttype" value="1" v-model="selectedProduct.discounttype">
										<label class="custom-control-label" for="percentage">Percentage</label>
									</div>
								</div>

								<div class="col-6">
									<div class="custom-control custom-radio custom-control-inline">
										<input type="radio" class="custom-control-input" id="moneyless" name="discounttype" value="2" v-model="selectedProduct.discounttype">
										<label class="custom-control-label" for="moneyless">Less Discount</label>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-12" v-if="selectedProduct.discounttype == 1">
									<div class="form-group">
										<label for="amount">Percentage</label>
										<input type="number" class="form-control" v-model="selectedProduct.discountValue" min="0">
									</div>
								</div>

								<div class="col-12" v-else-if="selectedProduct.discounttype == 2">
									<div class="form-group">
										<label for="amount">Value</label>
										<input type="number" class="form-control" v-model="selectedProduct.discountValue" min="0">
									</div>
								</div>
							</div>
						</div>

						<div class="modal-footer justify-content-between">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
							<button type="button" class="btn btn-primary" @click.prevent="applyDiscounts">Save Changes</button>
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
					role_id: null,
				}),
				
				products: {},
				searchQuery: '',

				selectedProduct: new Form({
					id: null,
					discounttype: null,
					discountValue: null,
				}),

				// Watched Data
				filters: ["All", "Unpublished", "Published"],

			}
		},

		computed: {
			filteredProducts (){
				if(this.searchQuery){
					return this.products.filter((item)=>{
						if( (item.name.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1) || (item.id.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1) || (item.qty.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1) || (item.variantcount.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1) || (item.categoryname.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1)) {
							return item.name;
						}
					})
				}else{
					return this.products;
				}
			}
		},


		methods: {
			searchProduct: _.debounce(function() {
				axios.get('/api/product/search?pro=' + this.searchQuery)
					.then(response => {
						this.products = response.data;
					})
					.catch((error) => {

					})
			}, 1000),
			getResults: function(page = 1) {
				axios.get('/api/product?page=' + page)
					.then(response => {
						this.products = response.data;
					});
			},

			hideProduct: function(id) {
				Swal.fire({
                    title: 'Are you sure?',
                    text: "Hide Product from Store?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {

                    if(result.value){
                        this.$Progress.start();
                        this.staff.get('/api/product/unpublish/'+id)
                            .then(() => {
                                this.$Progress.finish();
                                Swal.fire(
                                    'Hidden!',
                                    'Product has been hidden from the store.',
                                    'success')
                                this.loadProducts();
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

			postProduct: function(id) {
				Swal.fire({
					title: 'Publish Product',
					text: "Publish Product?",
					type: 'info',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Publish'
				}).then((result) => {

					if(result.value){
						this.$Progress.start();
						this.staff.get('/api/product/publish/' + id)
							.then(() => {
								this.$Progress.finish();
								Swal.fire(
									'Published!',
									'Product has been published.',
									'success')
								this.loadProducts();
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

			getVariants: function() {
				axios.get('/api/product/variants/get/'+product.id).then(({ data }) => ( product.variants = data ))
			},

			getStaff: function() {
				axios.get("/api/profile").then(({data}) => this.staff.fill(data));
			},

			loadProducts: function() {

				axios.get('/api/product').then(( data ) => {this.products = data.data});
				this.filter = "All";

			},

			setDiscountType(type) {
				console.log(type);
				this.selectedProduct.discounttype = type;
			},

			editDiscount: function(product) {
				this.selectedProduct.reset();
				this.selectedProduct.id = product.id;
				this.selectedProduct.discounttype = product.discounttype;
				this.selectedProduct.discountValue = product.discount;
				$('#discountModal').modal('show');
			},

			addDiscount: function(product) {
				this.selectedProduct.reset();
				this.selectedProduct.id = product.id;
				this.selectedProduct.discounttype = product.discounttype;
				this.selectedProduct.discountValue = product.discount;
				$('#discountModal').modal('show');
			},

			applyDiscounts: function() {
				this.$Progress.start();
				this.selectedProduct.post('/api/product/'+ this.selectedProduct.id + '/discounts/add')
					.then(() => {
						this.$Progress.finish();
						$('#discountModal').modal('hide');
						Toast.fire({
							type: 'success',
							title: 'Discount Applied Successfully'
						});
						this.loadProducts();
					})
					.catch(({error}) => {
						this.$Progress.fail();
						Swal.fire(
							'Failed', "There's something wrong.",
							'warning'
						);
						console.log(error.message);
					});
			}

		},

		created() {
			this.getStaff();
			this.loadProducts();
		}
	};

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
