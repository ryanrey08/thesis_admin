<template>

	<div class="content"  style=" height: auto;">
		
		<section class="content-header">
			<div class="container">
				<div class="row small">
					<div class="col-sm-12">
						<ol class="breadcrumb float-sm-left">
							<li class="breadcrumb-item"><a href="/home">Home</a></li>
							<li class="breadcrumb-item"><a href="/product">Product</a></li>
							<li class="breadcrumb-item active">{{ product.name }}</li>
						</ol>
					</div>
				</div>
			</div>
		</section>
		
		<div class="container" style="background-color: #f4f6f9;">
			<div class="container-fluid p-0" >

				<div class="row mb-2">
					<div class="col-md-7 p-5">
						<div class="image-viewer w-100 h-100 mb-2" style="background: #ffe6e6;">
							<img :src="imgSrc" class="image-display w-100">
						</div>

						<div class="row">
							<div class="col-sm-2" @click="changePicture(image)" v-for="image in images" :key="image.id">
								<div class="image-gallery p-2" :class="image.name == imgSrc ? 'activePhoto' : ''">
									<img :src="image.name" class="w-100">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4 pt-5 px-0">
						<div class="row mb-2">
							<div class="col-md-12">
								<h3 class="text-dark">
									{{ product.name }}
								</h3>
							</div>
						</div>
						<div class="row mb-2">
							<div class="col-md-12">
								<div class="d-flex flex-wrap align-items-center">
									<div class="p-2 text-center flex-fill">
										<h4 class="danger">4.9</h4 >
										<div class="stars">
											<span class="ion ion-ios-star danger"></span>
											<span class="ion ion-ios-star danger"></span>
											<span class="ion ion-ios-star danger"></span>
											<span class="ion ion-ios-star danger"></span>
											<span class="ion ion-ios-star danger"></span>
										</div>
									</div>
									<div class="p-2 border-left border-right text-center flex-fill">
										<span>112 Ratings</span>
									</div>
									<div class="p-2  text-center flex-fill">
										<span>670 Sold</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="d-flex flex-wrap align-items-center p-3" v-if="selectedItem == null">
									<div class="p-2 small text-secondary" v-if="product.discount_type != 0 && product.discount_type != null"><del>₱ {{ Number(product.maxprice) }}</del></div>
									<div class="p-2" v-if="product.discount_type != 0 && product.discount_type != null">
										<h4 class="danger" v-if="product.combination == 'NONE'">
											₱ {{ Math.floor(getDiscountedPrice(product.discount_type, product.discount, product.maxprice)) }}
										</h4>

										<h4 class="danger" v-else>
											<span v-if="product.minprice == product.maxprice">₱ {{ Math.floor(getDiscountedPrice(product.discount_type, product.discount, product.maxprice)) }}</span>
											<span v-else>₱ {{ Math.floor(getDiscountedPrice(product.discount_type, product.discount, product.minprice)) }} - {{ Math.floor(getDiscountedPrice(product.discount_type, product.discount_value, product.maxprice)) }}</span>
										</h4>
									</div>
									<div class="p-2" v-else>
										<h4 class="danger" v-if="product.combination == 'NONE'">
											₱ {{ Math.floor(Number(product.maxprice)) }}
										</h4>

										<h4 class="danger" v-else>
											<span v-if="product.minprice == product.maxprice">₱ {{ Math.floor(Number(product.maxprice)) }}</span>
											<span v-else>₱ {{ Math.floor(getDiscountedPrice(product.discount_type, product.discount, product.minprice)) }} - {{ Math.floor(getDiscountedPrice(product.discount_type, product.discount, product.maxprice)) }}</span>
										</h4>
									</div>
									<div class="p-2" v-if="product.discount_type != 0 && product.discount_type != null">
										<h5>
											<span class="badge discount-ribbon small">
												{{ product.discount_type == 1 ? (product.discount + '% OFF') : 'LESS ₱' + product.discount }}
											</span>
										</h5>
									</div>
								</div>

								<div class="d-flex flex-wrap align-items-center p-3" v-else>
									<div class="p-2 small text-secondary" v-if="product.discounttype != 0 && product.discounttype != null"><del>₱ {{ Number(selectedItem.price) }}</del></div>
									<div class="p-2" v-if="product.discounttype != 0 && product.discounttype != null">
										<h4 class="danger">
											₱ {{ Math.floor(getDiscountedPrice(product.discounttype, product.discount, selectedItem.price)) }}
										</h4>
									</div>
									<div class="p-2" v-else>
										<h4 class="danger">
											<span>₱ {{ Number(product.price) }}</span>
										</h4>
									</div>
									<div class="p-2" v-if="product.discounttype != 0 && product.discounttype != null">
										<h5>
											<span class="badge discount-ribbon small">
												{{ product.discount_type == 1 ? (product.discount + '% OFF') : 'LESS ₱' + product.discount }}
											</span>
										</h5>
									</div>
								</div>
							</div>
						</div>
						<div class="row mb-2">
							<div class="col-md-4">
								<label for="" class="text-danger">Quantity</label>
							</div>
							
							<div class="col-md-5">
								<div class="input-group input-group-sm border rounded">
									<div class="input-group-prepend">
										<button class="quantity-button-text border border-0 rounded-left " :disabled="selectedItem != null ? false : true" @click.prevent="decreaseQuantity">
											<i class="fas fa-minus danger"></i>
										</button>
									</div>
									<input v-model="qty" :disabled="selectedItem != null ? false : true" class=" text-center form-control border border-0 quantity-box" >
									<div class="input-group-append">
										<button class="quantity-button-text border border-0 rounded-right " :disabled="selectedItem != null ? false : true" @click.prevent="increaseQuantity">
											<i class="fas fa-plus danger"></i>
										</button>
									</div>

								</div>
							</div>
							<div class="col-md-3" v-if="selectedItem != null">
								<span class="text-secondary small">{{ product.qty }} pcs. available</span>
							</div>						
						</div>
						<div class="row" v-for="variant in variants">
							<div class="col-md-4">
								<label for="" class="text-danger">{{ variant.name }}</label>
							</div>
							<div class="col-sm-8">
								<div class="row">
									<div class="col" v-for="option in variant.options">
										<button class="m-2 btn w-100" :class="[option.selected == true ? 'btn-danger strong' : 'btn-outline-danger']" @click.prevent="changeSelection(variant.variantid, option.optionid)">
											{{ option.description }}
										</button>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<button class="btn btn-lg w-100" :disabled="selectedItem != null && qty > 0 ? false : true" @click="showDemo"><i class="fas fa-cart-plus fa-fw"></i>Add to Cart</button>
							</div>
							<div class="col-md-6">
								<button class="btn btn-lg w-100" :disabled="selectedItem != null && qty > 0 ? false : true" @click="showDemo">Buy Now</button>
							</div>
						</div>
					</div> 
				</div>
			</div>

			<div class="container-fluid p-3 mt-5" style="background-color: #fff;">
				<h5 class="text-danger mt-3 mb-3">Product Specification</h5>
				<p>Category</p>
				<p>Brand</p>
				<p>Material</p>
				<p>Stock</p>
				<h5 class="text-danger mb-3">Product Description</h5>
				<span class="small mt-5" v-html="product.description">
				</span>
			</div>

			<div class="container-fluid p-3 mt-3" style="background-color: #fff;">
				<h5 class="text-danger mb-3 mt-3">Reviews and Ratings</h5>
				<div class="d-flex flex-wrap align-items-center">
					<div class="p-2 mr-3 text-center flex-fill" id="rating">
						<h4 class="danger"><strong>4.9</strong> out of 5</h4>
						<div class="stars">
							<span class="ion ion-ios-star danger"></span>
							<span class="ion ion-ios-star danger"></span>
							<span class="ion ion-ios-star danger"></span>
							<span class="ion ion-ios-star danger"></span>
							<span class="ion ion-ios-star danger"></span>
						</div>
					</div>
					<div class="p-2 mr-3 text-center flex-fill" id="rating">
						<span>All</span>
					</div>
					<div class="p-2 mr-3 text-center flex-fill" id="rating">
						<span>5 stars</span>
					</div>
					<div class="p-2 mr-3 text-center flex-fill" id="rating">
						<span>4 stars</span>
					</div>
					<div class="p-2 mr-3 text-center flex-fill" id="rating">
						<span>3 stars</span>
					</div>
					<div class="p-2 mr-3 text-center flex-fill" id="rating">
						<span>2 stars</span>
					</div>
					<div class="p-2 mr-3 text-center flex-fill" id="rating">
						<span>1 stars</span>
					</div>
					<div class="p-2 mr-3 text-center flex-fill" id="rating">
						<span>With Comments</span>
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

				product: new Form({}),
				images: [],
				variants: [],
				selectedItem: {},
				activeItems: [],
				prodid: null,
				imgSrc: null,
				qty: 0,
			}

		},

		methods: {
			showDemo: function() {
				Swal.fire({
					title: 'Just a demo',
					type: 'info',
				})
			},

			decreaseQuantity: function() {
				if(this.qty > 0)
					this.qty = Number(this.qty) - 1;
			},

			increaseQuantity: function() {
				if(this.qty < this.product.qty)
					this.qty = Number(this.qty) + 1;
			},

			changePicture: function(image) {
				this.imgSrc = image.name;
				console.log(image);
			},

			getDiscountedPrice: function(discount_type, discountValue, price) {
				if(discount_type == 1) {
					return Number(price) - (Number(price) * (Number(discountValue) / 100));
				} else {
					return Number(price) - Number(discountValue);
				}
			},

			generateCombination: function() {
				let combination = [];
				for(let index = 0; index < this.variants.length; index++) {
					for(let inner = 0; inner < this.variants[index].options.length; inner++) {
						if(this.variants[index].options[inner].selected == true) {

							combination.push(this.variants[index].options[inner].optionid);
						}
					}
				} 

				combination.sort(function(a, b){return a - b});


				let itemid = this.checkCombination(combination);
				if(itemid !== undefined) {
					axios.get('/api/inventory/items/' + itemid).then(({data}) => (this.selectedItem = data[0]));
				}
			},

			checkCombination: function(combination) {

				let combinations = [];

				for(let index = 0; index < this.activeItems.length; index++) {

					let combo = this.activeItems[index].combination.split(" - ");
					combo.sort(function(a, b){return a - b});

					let sku = {
						id: this.activeItems[index].id,
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

			changeSelection: function(varid, optid) {

				for(let index = 0; index < this.variants.length; index++) {
					if(this.variants[index].variantid == varid) {
						for(let inner = 0; inner < this.variants[index].options.length; inner++) {
							if(this.variants[index].options[inner].optionid == optid) {
								this.variants[index].options[inner].selected = true;
							} else {
								this.variants[index].options[inner].selected = false;
							}
						}
						break;
					}
				}

				this.generateCombination();

			},

			getItems: function() {
				axios.get('/api/inventory/' + this.prodid).then(({data}) => (this.activeItems = data));
			},

			getVariants: function() {
				
					axios.get('/api/product/getVariants/'+this.prodid)
					.then((data) => {

						let result = data.data;

						let varopts = [];
						for(let index = 0; index < result.length; index++) {
							let found = false;
							let varid = result[index].variantid;
							for(let counter = 0; counter < varopts.length; counter++) {
								if(varopts[counter].variantid == varid) {
									found = true;
									break;
								}
							}

							if(!found) {
								let variant = {
									variantid: varid,
									name: result[index].name,
									options: []
								}
								for(let outer = 0; outer < result.length; outer++) {
									if(varid == result[outer].variantid) {
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

						this.variants = varopts;
						this.getItems();
					});

			},

			viewProduct: function() {
				axios.get('/api/product/view/' + this.prodid).then(( data ) => {
					this.product = data.data[0];
					if(this.product.variantcount > 0 && this.product.combination != "NONE") {
						this.getVariants();
					} else if((this.product.variantcount - 1) == 0 && this.product.combination == "NONE") {
						axios.get('/api/inventory/items/' + this.product.itemid).then(({data}) => (this.selectedItem = data[0]));
					}
				});
			},

			getImages: function() {
				axios.get('/api/product/images/' + this.prodid).then(( data ) => {
					this.images = data.data;
					this.imgSrc = this.images[0].name;
					});
				
			},

			loadProduct: function() {
				this.viewProduct();
				this.getImages();
				this.getVariants();
			}

		},

		created() {
			this.prodid = this.$route.params.productid;
			this.loadProduct();
			console.log('Component mounted.')
		}
	};
</script>

<style scoped>


	.image-viewer {

		max-height: 400px;
	}

	.stars {
		color: #ffe6e6;
		font-size: 10px;
	}
	
	.discount-ribbon {
		background: linear-gradient(to bottom, #ffcc00 -25%, #ffff99 100%);
	}
	

	.w-35 {
		width: 35%;
	}

	.quantity-button-text {
		background: #ffffff;
	}

	.image-gallery {
		
		height: 80px;
		width: 80px;
	}

	.image-display {
		object-fit: fill;
		max-height: 400px;
	}

	.activePhoto {
		background-color: #FF9393FF;
	}

	.text-dark {
		color: #3d9970 !important;
	}

	.flex-fill {
		color: #3d9970;
	}

	.danger{
		color: #3d9970;
	}

	.text-danger{
		color: #3d9970 !important;
	}

	.border {
   		 border: 1px solid #3d9970 !important;
	}

	.text-secondary {
    	color: #3d9970 !important;
	}

	.btn-lg, .btn-group-lg > .btn {
    	border: 1px solid #3d9970;
    	transition: width 2s;
	}

	.btn-lg, .btn-group-lg > .btn:hover {
    	width: 200px;
	}

	#rating {
    color: #3d9970;
    border: 1px solid #3d9970;
}

.btn-outline-danger {
    color: #3d9970;
    border-color: #3d9970;
}
	

</style>
