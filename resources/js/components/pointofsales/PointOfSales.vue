<template>

	<div class="w-100">
		<div class="content">
			<div class="container-fluid">
				<div class="row mb-2 p-2 rounded-lg">
					<div class="col-sm-8">
						<div class="card card-danger card-outline" style="height: 550px;">
							<div class="card-header">
								<div class="row">
									<div class="col-sm-12">
										<div class="input-group input-group-sm border border-danger rounded">
											<div class="input-group-prepend">
												<button class="search-button-text border border-0 rounded-left " @click.prevent="">
													<i class="fa fa-search danger"></i>
												</button>
											</div>
											<input v-model="searchQuery" class="form-control border border-0 rounded-right search-box" placeholder="Search" aria-label="Search">
										</div>
									</div>
								</div>
							</div>
							
							<div class="card-body" style="height: 200px; overflow-y: scroll; overflow-x: hidden;" >
								<div class="row h-100">
									<div v-if="products.length == 0" class="col-sm-12 text-center h-100">
										<p class="card-text h-100" style="padding: 30%;font-size: 25px; font-weight: bolder;align-content: center!important;"><i class="fa fa-spinner fa-spin red"></i></p>
									</div>
									<div v-else v-for="product in filteredProducts" :key="product.id" class="col-3" @click.prevent="checkItem(product)">
										<div class="card card-outline product-item" :class="[product.ispublished == 1 ? 'card-primary' : 'card-danger']" style="height:320px; width: 100%;">
											<div class="ribbon-wrapper" v-if="product.discount_type != 0 && product.discount_type != null" >
									
												<div class="ribbon discount-ribbon">
													<div class="glow"></div>
													<span class="strong">{{ product.discount_type == 1 ? (product.discount_value + '% OFF') : 'LESS ₱' + product.discount_value }}</span>
									
											    </div>
											</div>
											<div class="cover-image">
												
							
												<img class="card-img-top product-image" :src="product.imgname" alt="Card image" width="">

											</div>
											<div class="card-body text-center product-name" style="height: 80px;">
												<p class="small"> {{ product.name }}</p>
											</div>
											<div class="card-footer border-top-0 text-center product-price" style="height: 60px;">
												<p class="small" v-if="product.combination == 'NONE'">
													<span v-if="product.discount_type != 0 && product.discount_type != null">
														<b> ₱ {{ Math.floor(getDiscountedPrice(product.discount_type, product.discount_value, product.maxprice)) }}</b>
														<br>
														<!-- <span class="light"><del>₱ {{ Math.floor(product.maxprice) }}</del></span> -->
													</span>
													<span v-else><b>₱ {{ product.maxprice }}</b></span>
												</p>
												<p class="small" v-else>
													<span v-if="product.discount_type != 0 && product.discount_type != null">
																	
														<b v-if="product.minprice == product.maxprice">₱ {{ Math.floor(getDiscountedPrice(product.discount_type, product.discount_value, product.maxprice)) }}</b>	
														<b v-else>₱ {{ Math.floor(getDiscountedPrice(product.discount_type, product.discount, product.minprice)) }} - {{ Math.floor(getDiscountedPrice(product.discount_type, product.discount_value, product.maxprice)) }}</b>
														<br>
														<!-- <span class="light"><del>₱ {{ Math.floor(product.maxprice) }}</del></span> -->
													</span>
													<span v-else>
														<b v-if="product.minprice == product.maxprice">₱ {{ Math.floor(Number(product.maxprice)) }}</b>
														<b v-else>₱ {{ Math.floor(Number(product.minprice)) }} - {{ Math.floor(Number(product.maxprice)) }}</b>
													</span>
												</p>
												<div class="stars">
													<span class="ion ion-ios-star danger"></span>
													<span class="ion ion-ios-star danger"></span>
													<span class="ion ion-ios-star danger"></span>
													<span class="ion ion-ios-star-outline danger"></span>
													<span class="ion ion-ios-star-outline danger"></span>
												</div>
											</div>
											<div class="product-frame">

												<div class="d-flex flex-wrap " :class="product.discount_type != 0 && product.discount_type != null ? 'justify-content-between' : ''">
													<!-- <div v-if="product.discounttype != 0 && product.discounttype != null" class="p-1 discount-ribbon small" trigger="hover" data-toggle="tooltip" >
														<span class="strong">{{ product.discounttype == 1 ? (product.discount + '% OFF') : 'LESS ₱' + product.discount }}</span>
													</div> -->
													<div v-if="product.combination != 'NONE'" class="p-1 bg-danger small" :class="product.discount_type != 0 && product.discount_type != null ? '' : 'ml-auto'" trigger="hover" data-toggle="tooltip" :title="product.variantcount+' available variants'" style="opacity: .8;">
														<i class="fa fa-plus fa-fw" aria-hidden="true"></i>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="card card-outline card-primary p-1 light" style="height: 550px;">
							<div class="card-header small">
								<span>{{ date }}</span><br>
								<span>{{ time }}</span>
							</div>
							<div class="card-body p-0 mt-1" style="height: 200;overflow-y: scroll; overflow-x: hidden;">
								<div v-if="selectedItems.length == 0" class="d-flex flex-wrap justify-content-center align-content-center h-100">
									<h4 class="danger" style="font-style: italic;">Cart Empty</h4>
								</div>
								<div v-else class="row small mb-0" v-for="item in selectedItems" :key="item.id">
									<div class="col-sm-12">
										<div class="media border p-2">
											<img :src="item.product.imgname" class="m-2" width="40">
											<div class="media-body">
												<div class="d-flex flex-wrap">
													<h4 class="small">{{ item.product.name }}</h4>
													<div class="ml-auto">
														<i class="fa fa-times-circle danger" style="cursor: pointer;" @click.prevent="removeItem(item.product.id)"></i>
													</div>
												</div>
												<!-- <h4 class="small">₱ {{ getDiscountedPrice(item.product.discounttype, item.product.discount, item.product.price) }}</h4> -->
												<h4 class="small">₱ {{ item.product.price }}</h4>
												<div class="d-flex flex-wrap">
													<h4 class="small quantity" >Quantity: {{ item.quantity }}</h4>
													<div class="ml-auto">
														<h4 class="small" style="font-style: italic;">Sub Total(₱): {{ getSubTotal(item) }}</h4>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer bg-danger-gradient">
								<div class="table-responsive w-100">
									<table class="w-100">
										<tbody>
											<tr>
												<td class="border border-danger w-50">Sub Total (₱)</td>
												<td class="border border-danger w-50">{{ getTotal }}</td>
											</tr>
										<!-- <tr>
											<td class="border border-danger w-50">Tax (12%)</td>
											<td class="border border-danger w-50">{{ getTax}}</td>
										</tr> -->

										<tr>
											<td class="border border-danger w-50">Total (₱)</td>
											<td class="border border-danger w-50">{{ getTotal }}</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<button class="mt-1 btn btn-danger form-control" @click.prevent="selectedItems = []" :disabled="selectedItems.length > 0 ? false : true"><i class="fas fa-window-close mr-2"></i>CLEAR CART</button>
								</div>
								<div class="col-sm-6">
									<button class="mt-1 btn btn-info form-control" data-toggle="modal" data-target="#checkOut" :disabled="getTotal > 0 ? false : true"><i class="fa fa-money mr-2"></i>CHECKOUT</button>
								</div>
							</div>
							
						</div>
					</div>
				</div>                                       
			</div>
			<div class="modal fade" id="variantModal" aria-modal="true">
				<div class="modal-dialog modal-dialog-centered modal-lg">
					<div class="modal-content bg-gradient-danger">

						<div class="modal-header">
							<h4 class="modal-title">Choose from the variants</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>

						<div class="modal-body">
							<div class="row">
								<div class="col-sm-6">

									<div class="row" v-for="variant in activeVariants">
										<div class="col-sm-12">
											<label for="">{{ variant.name }}</label>
											<div class="row">
												<div class="col" v-for="option in variant.options">
													<button class="m-2 btn w-100" :class="[option.selected == true ? 'btn-warning strong' : 'btn-outline-warning']" @click.prevent="changeSelection(variant.variantid, option.optionid)">
														{{ option.description }}
													</button>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-6" v-if="selectedProduct.length > 0">
									<div class="media border border-danger p-2">
										<img :src="selectedProduct[0].imgname" class="m-2" width="40">
										<div class="media-body">
											<div class="d-flex flex-wrap">
												<h5 class="small">{{ selectedProduct[0].name }}</h5>
											</div>
											<div class="d-flex flex-wrap">
												<h6 class="mr-2 small" v-if="selectedProduct[0].discount_type != 0"><del>₱ {{ selectedProduct[0].price }}</del></h6>
												<h6><strong>₱ {{ Math.floor(getDiscountedPrice(selectedProduct[0].discount_type, selectedProduct[0].discount_value, selectedProduct[0].price)) }}</strong></h6>
											</div>
											<!-- <h6 v-if="selectedProduct.discounttype != 0"><del>₱ {{ Number(selectedProduct.price) }}</del></h6> -->
											

											<div class="d-flex flex-wrap">
												<h6>
													Available Stocks: {{ getRemainingQuantity(selectedProduct[0]) }}
												</h6>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="itemQuantity">Enter Quantity</label>
										<input class="form-control" type="number" v-model="qty" min="1">
									</div>
								</div>
							</div>
						</div>

						<div class="modal-footer justify-content-between">
							<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-warning" :disabled="selectedProduct.length > 0 && qty <= getRemainingQuantity(selectedProduct[0]) && qty > 0 ? false : true" @click.prevent="selectItem(selectedProduct[0], qty)"><i class="fas fa-cart-plus mr-1"></i>Add to Cart</button>
						</div>

					</div>
					
				</div>

			</div>

			<div class="modal fade" id="checkOut" aria-modal="true">
				<div class="modal-dialog modal-dialog-centered modal-sm">
					<div class="modal-content bg-gradient-danger">
						<div class="modal-header">
							<h4 class="modal-title">Checkout</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>

						<div class="modal-body">
							<div class="table-responsive w-100 mb-5">
								<table class="w-100">
									<tbody>
										<tr>
											<td class="border border-danger w-50">Total (₱)</td>
											<td class="border border-danger w-50">{{ getTotal }}</td>
										</tr>
										<tr>
											<td class="border border-danger w-50">Cash Tendered</td>
											<td class="border border-danger w-50">{{ Number(amount).toFixed(2) }}</td>
										</tr>
										<tr>
											<td class="border border-danger w-50">Change</td>
											<td class="border border-danger w-50">{{ change }}</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="form-group">
								<label for="amount">Enter Amount</label>
								<input type="number" class="form-control" id="amount" v-model="amount" min="0">
							</div>
						</div>

						<div class="modal-footer justify-content-between">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary" @click.prevent="checkout">Finish Transaction</button>
						</div>

					</div>

				</div>

			</div>
		</div>


	</div>
</div>

</template>

<script>

export default {
	data: function() {
		return {

					// Date
					date: null,
					time: null,
					staff: new Form({
						id: null,
						name: null,
					}),
					searchQuery: '',
					qty: 1,
					amount: 0,

					products: [],
					selectedItems: [],

					activeVariants: [],
					activeProduct: [],
					variantOptions: [],
					selectedProduct: {}
				}
			},

			computed: {

				filteredProducts: function(){
					if(this.searchQuery){
						return this.products.filter((item)=>{
							if( (item.name.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1) || (item.id.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1) || (item.qty.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1) || (item.variantcount.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1) || (item.categoryName.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1)) {
								return item.name;
							}
						})
					}else{
						return this.products;
					}
				},

				getTotal: function() {
					let subtotal = 0;
					for(let index = 0; index < this.selectedItems.length; index++) {
						subtotal += this.getSubTotal(this.selectedItems[index]);
					}

					return subtotal.toFixed(2);
				},

				getTax: function() {
					return (this.getTotal * .12).toFixed(2);
				},

				change: function() {
					return (this.amount - this.getTotal >= 0 ? this.amount - this.getTotal : 0 ).toFixed(2);
				}

			},

			methods: {
				getDiscountedPrice: function(discounttype, discountValue, price) {
					if(discounttype == 1) {
						return Number(price) - (Number(price) * (Number(discountValue) / 100));
					} else {
						return Number(price) - Number(discountValue);
					}
				},

				checkout: function() {
					let transaction = new Form({
						selectedItems: this.selectedItems,
						payment: this.amount,
					});

					this.$Progress.start();
					transaction.post('/api/pos/transaction/checkout')
						.then(() => {
							this.$Progress.finish();
							$('#checkOut').modal('hide');
							Swal.fire(
								'Complete!',
								'Transaction Complete!',
								'success')
								// .then(() => {
								// 	window.open('/pos/invoice', '_target');
								// });
							Fire.$emit('AfterTransaction');
							this.selectedItems = [];
							this.amount = 0;
							this.qty = 1;
						})
						.catch(({error}) => { this.$Progress.finish(); console.log(error.message); });
				},

				getRemainingQuantity: function(selectedProduct) {
					let found = false;
					let selQty = 0;
					for(let index = 0; index < this.selectedItems.length; index++) {
						if(selectedProduct.id == this.selectedItems[index].product.id) {
							selQty = this.selectedItems[index].quantity;
							break;
						}
					}

					return selectedProduct.quantity - selQty;
				},

				generateCombination: function() {
					let combination = [];
					for(let index = 0; index < this.activeVariants.length; index++) {
						for(let inner = 0; inner < this.activeVariants[index].options.length; inner++) {
							if(this.activeVariants[index].options[inner].selected == true) {
								// combination += this.activeVariants[index].options[inner].optionid + " - "
								combination.push(this.activeVariants[index].options[inner].optionid);
							}
						}
					} 
					
					combination.sort(function(a, b){return a - b});

					// console.log(this.checkCombination(combination));
					let itemid = this.checkCombination(combination);
					if(itemid !== undefined) {
						axios.get('/api/inventory/items/'+itemid).then(({data}) => (this.selectedProduct = data));
					}
				},

				checkCombination: function(combination) {

					let combinations = [];

					for(let index = 0; index < this.activeProduct.length; index++) {

						let combo = this.activeProduct[index].combination.split(" - ");
						combo.sort(function(a, b){return a - b});

						let sku = {
							id: this.activeProduct[index].id,
							comb: combo
						}

						combinations.push(sku);
					}

					let found = false;
					let id = null;
					for(let outer = 0; outer < combinations.length; outer++) {
						if(combination.toString() == combinations[outer].comb.toString()) {
							found = true;
							id = combinations[outer].id;
							break;
						}
					}

					if(found) {
						return id;
					}

				},

				changeSelection: function(varID, optID) {

					for(let index = 0; index < this.activeVariants.length; index++) {
						if(this.activeVariants[index].variantid == varID) {
							for(let inner = 0; inner < this.activeVariants[index].options.length; inner++) {
								if(this.activeVariants[index].options[inner].optionid == optID) {
									this.activeVariants[index].options[inner].selected = true;
								} else {
									this.activeVariants[index].options[inner].selected = false;
								}
							}
							break;
						}
					}

					this.generateCombination();

				},

				getProduct: function(productID) {
					axios.get('/api/inventory/'+productID).then(({data}) => (this.activeProduct = data));
				},

				checkItem: function(product) {
					this.selectedProduct = [];
					if(product.variantcount > 0 && product.combination != "NONE") {
						axios.get('/api/pos/getVariants/'+product.id)
						.then((data) => {
								// this.activeVariants = data.data;
								let result = data.data;

								let varopts = [];
								for(let index = 0; index < result.length; index++) {
									let found = false;
									let varID = result[index].variantid;
									for(let counter = 0; counter < varopts.length; counter++) {
										if(varopts[counter].variantid == varID) {
											found = true;
											break;
										}
									}

									if(!found) {
										let variant = {
											variantid: varID,
											name: result[index].name,
											options: []
										}
										for(let outer = 0; outer < result.length; outer++) {
											if(varID == result[outer].variantid) {
												let opt = {
													optionid: result[outer].optionid,
													description: result[outer].description,
													selected: false
												}

												variant.options.push(opt);
											}
										}
										varopts.push(variant);
									}
								}

								this.activeVariants = varopts;
								this.getProduct(product.id);

								$("#variantModal").modal("show");
							});
						
					} else if((product.variantcount - 1) == 0 && product.combination == "NONE") {
						axios.get('/api/inventory/items/'+product.itemid)
						.then((data) => {
							let sku = data.data;
							this.selectItem(sku[0]);
						});
					}
				},

				getSubTotal: function(item) {
					return (item.product.price * item.quantity);
				},

				removeItem: function(id) {
					for(let index = 0; index < this.selectedItems.length; index++) {
						if(id == this.selectedItems[index].product.id) {
							this.selectedItems.splice(index, 1);
							break;
						}
					}

					this.$toastr.error('Item removed from cart!', 'Item Removed!', {"showDuration": "0","timeOut": "3000","showEasing": "swing"});
				},

				selectItem: function(product, qty = 1) {
					if(this.selectedItems.length == 0) {
						product.price = Math.floor(this.getDiscountedPrice(product.discount_type, product.discount_value, product.price));
						let item = {
							product: product,
							quantity: qty
						}
						this.selectedItems.push(item);
					} else {
						let found = false;
						for(let index = 0; index < this.selectedItems.length; index++) {
							if(product.id == this.selectedItems[index].product.id) {
								this.selectedItems[index].quantity = Number(this.selectedItems[index].quantity) + Number(qty) ;
								found = true;
								break;
							}
						}

						if(!found) {
							product.price = Math.floor(this.getDiscountedPrice(product.discount_type, product.discount_value, product.price));
							let item = {
								product: product,
								quantity: qty
							}  
							this.selectedItems.push(item);
						}
					}

					this.qty = 1;
					
					this.$toastr.success('Item added to cart!', 'Successful!', {"showDuration": "0","timeOut": "3000","showEasing": "swing"});
				},

				loadProducts: function() {
					axios.get("/api/pos").then(({data}) => (this.products = data));
				},

				getStaff: function() {
					axios.get("/api/profile").then(({data}) => this.staff.fill(data));
				},

				getDateTime: function() {
					let dateTime = new Date();
					let months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
					this.date = months[dateTime.getMonth()] + " " + dateTime.getDate() + ", " + dateTime.getFullYear();

					if(dateTime.getHours() >= 13) {
						this.time = dateTime.getHours() - 12 + ":" + String(dateTime.getMinutes()).padStart(2, 0);
					} else if(dateTime.getHours() == 0) {
						this.time = "12:" + String(dateTime.getMinutes()).padStart(2, 0);
					} else {
						this.time = dateTime.getHours() + ":" + String(dateTime.getMinutes()).padStart(2, 0);
					}
					this.time += " " + (dateTime.getHours() >= 12 ? "PM" : "AM");
				},

				compress: function(value) {
					if(value.length > 35) {
						return value.substring(0, 35) + "...";
					} else {
						return value;
					}
				}
			},

			created() {
				// setTimeout(this.getDate(), 1000);
				this.loadProducts();
				Fire.$on('AfterTransaction', () => {
	                this.loadProducts();
	            });

				// setInterval(() => this.getDateTime(), 1000);
				// this.getStaff();
				// this.loadProducts();
				// Fire.$on('AfterTransaction', () => {
	   //              this.loadProducts();
	   //          });
			}
		};
</script>


<style scoped>

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

::-webkit-scrollbar {
	width: 3px;
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

.cover-image {
	padding: 2px 2px;
	max-height: 120px;
}

.search-box {
	font-size: 1rem;
	font-family: 'Segoe UI Light';
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

.image {
	display: block;
	width: 100%;
	height: auto;
}

.product-frame {
	position: absolute;
	width: 100%;
	height: 100%;
}


.product-image {

	width: 100%;
	height: 120px;
	object-fit: fill;
	object-position: 10% 10%;
	cursor: pointer;
	padding: 1px 1px;
}

.product-item {
	max-width: 160px;
	max-height: 280px;
	cursor: pointer;
}

.product-list {
	max-height: 400;
}

.selected-item-list {
	max-height: 700px;
	bottom: 2%;
	right: 2%;
	width: 100%;
} 

.product-name {
	max-height: 80px;
}

.product-price {
	max-height: 60px;
	background: #ffffff;
}

.stars {
	color: #ffe6e6;
	font-size: 10px;
}
.strong {
	font-weight: bolder;
}

.discount-ribbon {
	background: linear-gradient(to bottom, #ffcc00 -25%, #ffff99 100%);
}

@-webkit-keyframes flow {
	0% { left:-20px;opacity: 0;}
	50% {left:100px;opacity: 0.3;}
	100%{ left:180px;opacity: 0;}
}
@keyframes flow {
	0% { left:-20px;opacity: 0;}
	50% {left:100px;opacity: 0.3;}
	100%{ left:180px;opacity: 0;}
}

.glow{ background: rgb(255,255,255); width:40px; height:100%; z-index:999; position:absolute;-webkit-animation: flow 1.5s linear infinite;
	-moz-animation: flow 1.5s linear infinite;-webkit-transform: skew(20deg);
	-moz-transform: skew(20deg);
	-o-transform: skew(20deg); /* FF3.6+ */ /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(left, rgba(255,255,255,0) 0%, rgba(255,255,255,0) 1%, rgba(255,255,255,1) 100%);
	background: -o-linear-gradient(left, rgba(255,255,255,0) 0%, rgba(255,255,255,0) 1%, rgba(255,255,255,1) 100%);
	background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0) 1%, rgba(255,255,255,1) 100%); /* Chrome10+,Safari5.1+ */ /* Opera 11.10+ */ /* IE10+ */ /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00ffffff', endColorstr='#ffffff',GradientType=1 ); /* IE6-9 */ 
	border-left:1px solid #fff;
}

</style>
