<template>
	<div class="w-100">
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-md">
						<div class="d-flex justify-content-between">
							<h1 class="m-0 text-dark">Edit Product</h1>
							<button class="btn btn-save" @click.prevent="saveProduct">Save</button>
							
							<router-link to="/product/add" class="btn btn-cancel">
								<span>Cancel</span>
							</router-link>

						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="content">
			<div class="container-fluid">
				<div class="row ">
					<div class="col-sm-8 border-right">
						<div class="card">	
							<div class="card-header no-border">
								<div class="d-flex justify-content-between">
									<h3 class="card-title">Product Information</h3>
								</div>
							</div>
							<div class="card-body">                
								<div class="form-group">
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label for="">Title</label>
												<input v-model="product.name" class="form-control" :class="{ 'is-invalid' : product.errors.has('name') }" type="text" name="name" placeholder-shown="Product Name" placeholder="Product Name">
												<has-error :form="product" field="name"></has-error>
											</div>
										</div>
										<div class="col-sm-6">
											<label for="">Category</label>
											<multiselect v-model="category" deselect-label="Can't deselect" track-by="id" label="name" placeholder="Select Category" open-direction="bottom"
											:options="categories" 
											:searchable="true"
											:allow-empty="false"
											:custom-label="getCategory"
											:hide-selected="true"
											:taggable="true"
											tag-placeholder="Add this as category"
											@input="selectCategory"
											@tag="addCategory">
										</multiselect>
									</div>
								</div>
							</div>
							<label for="productdesc">Description</label>
							<vue-editor id="productdesc" v-model="product.description" :editor-toolbar="toolBar"></vue-editor>
						</div>
					</div>
					<div class="card">
						<div class="card-header no-border">
							<div class="d-flex justify-content-between">
								<h3 class="card-title">Images</h3>
								<a href="" @click.prevent="clickUpload"><h6>Upload Images</h6></a>
								<input id="imgUpload" name="images[]" multiple type="file" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" hidden @change="uploadImage" />
							</div>
						</div>

						<div class="card-body text-center">

							<!-- <img src="/img/designs/svg/pictures.svg" class="w-25" style="opacity: .5" v-if="product.images.length == 0"> -->
							<div class="d-flex p-2" style="height: 200px; overflow-y: scroll;">
								<div class="row">
									<div class="p-1 imageHolder"
									v-for="(image, index) in product.images"
									:key="index"
									title="Click to remove photo"
									@click="removeImage(index)">
									<img class="productImage" :src="image.name">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-header no-border">
						<div class="d-flex justify-content-between">
							<h3 class="card-title">Pricing & Inventory</h3>
						</div>
					</div>

					<div class="card-body">
						<div class="form-group">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="">Price</label>
										<div class="input-group ">
											<div class="input-group-prepend">
												<span class="input-group-text">₱</span>
											</div>
											<input v-model="product.price" type="number" class="form-control" placeholder="0.00" :class="{ 'is-invalid' : product.errors.has('price') }" name="price" >
											<has-error :form="product" field="price"></has-error>


										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="">Compare at Price</label>
										<div class="input-group ">
											<div class="input-group-prepend">
												<span class="input-group-text">₱</span>
											</div>
											<input v-model="product.compare_price"  type="number" class="form-control" placeholder="0.00" name="compare_price">
											<has-error :form="product" field="compare_price"></has-error>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="">Cost per Item</label>
										<div class="input-group ">
											<div class="input-group-prepend">
												<span class="input-group-text">₱</span>
											</div>
											<input v-model="product.cost"  type="number" class="form-control" placeholder="0.00" name="cost">
											<has-error :form="product" field="cost"></has-error>
										</div>
									</div>
								</div>
							</div>
						</div>

						<hr>

						<div class="form-group">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="">SKU (Stock Keeping Unit)</label>
										<div class="input-group">
											<input v-model="product.sku" type="text" class="form-control" placeholder="SKU" name="sku" disabled>
											<div class="input-group-append">
												<span class="input-group-text" id="basic-addon2">Generate</span>
											</div>
											<has-error :form="product" field="sku"></has-error>
										</div>

									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for="">Quantity</label>
										<input v-model="product.qty" type="number" class="form-control" placeholder="0" name="quantity">
										<has-error :form="product" field="quantity"></has-error>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<div class="card" v-if="variants.length > 0">
				<div class="card-header no-border">
								<div class="d-flex justify-content-between">
									<h3 class="card-title">Variants</h3>
									<!-- <a href="javascript:void(0);"><h5>Add Variant</h5></a> -->
									<button class="btn btn-outline-primary no-border" @click.prevent="addVariant" v-if="!isAddVariant" @click="variantCheck">Add Variant</button>
									<button class="btn btn-outline-danger no-border" @click.prevent="cancelVariant" v-else>Cancel</button>
								</div>
							</div>

							<div class="card-body" v-if="isAddVariant">
								<p>Add variants if this product comes in multiple versions, like different sizes or colors.</p>
								<hr>
								<div class="row" >
									<div class="col-sm-12" v-if="variants.length > 0">
										
										<div v-for="(variant, index) in variants" :key="index"  class="form-row">
											<div class="col">
												<variant-update
													:variant="variant" 
													:loadedVariants="loadedVariants"
													:index="index"
													@variantCheck="variantCheck"
													@removeVariant="removeVariant"
													@addNewVariant="addNewVariant"
													@addVariantOption="addVariantOption">
												</variant-update> 
											</div>
											
											
										</div>
									</div>
								</div>
							</div>
				<div class="card-footer">

					<div class="row" >
						<div class="col-sm-12">
							<div class="table">
								<table class="table">
									<caption>Preview</caption>
									<thead class="thead-light">
										<tr>
											<th scope="col">
												<div class="custom-control custom-checkbox">
													<input class="custom-control-input" type="checkbox" checked id="checkAll">
													<label class="custom-control-label text-muted" for="checkAll">
													</label>
												</div>
											</th>
											<th scope="col">Variant</th>
											<th scope="col">Price</th>
											<th scope="col">SKU</th>
											<th scope="col">Quantity</th>

										</tr>
									</thead>
									<tbody>
										<tr v-for="(item, index) in selectedItem" :key="index" :id="index">
											<th scope="row">
															<!-- <div class="custom-control custom-checkbox">
																<input class="custom-control-input" type="checkbox" checked @change="checking(provar, index)" :id="'provar_' + index">
																<label class="custom-control-label text-muted" :for="'provar_' + index">
																</label>
															</div> -->
														</th>
														<td>{{ item.name }}</td>
														<td>
															<input v-model="item.price" class="form-control" type="number" placeholder="Price">
														</td>
														<td>
															<input v-model="item.sku" class="form-control" type="text" placeholder="SKU">
														</td>
														<td>
															<input v-model="item.quantity" class="form-control" type="number" placeholder="Quantity">
														</td>
													</tr>
													<tr v-for="(provar, index) in productVariants" :key="index" :id="index">
														<th scope="row">
															<!-- <div class="custom-control custom-checkbox">
																<input class="custom-control-input" type="checkbox" checked @change="checking(provar, index)" :id="'provar_' + index">
																<label class="custom-control-label text-muted" :for="'provar_' + index">
																</label>
															</div> -->
														</th>
														<td>{{ provar.name }}</td>
														<td>
															<input v-model="provar.price" class="form-control" type="number" placeholder="Price">
														</td>
														<td>
															<input v-model="provar.sku" class="form-control" type="text" placeholder="SKU">
														</td>
														<td>
															<input v-model="provar.quantity" class="form-control" type="number" placeholder="Quantity">
														</td>
													</tr>
												</tbody>
											</table>
										</div>	
									</div>
								</div>

							</div>
						</div>

					</div>

					<div class="col-sm-4">
						
						<div class="card">
							<div class="card-header no-border">
								<div class="d-flex justify-content-between">
									<h3 class="card-title">Collections</h3>
								</div>
							</div>

							<div class="card-body">
								<p>Add this product to a collection so it's easy to find in your store.</p>
								<multiselect v-model="product.collections" deselect-label="Can't deselect" track-by="id" label="description" placeholder="Choose from collection" open-direction="bottom"
								:options="collections" 
								:searchable="true"
								:allow-empty="true"
								
								:hide-selected="true"
								:multiple="true"
								:option-height="50"
								@input="selectCollection"
								>
								<template slot="singleLabel" slot-scope="props">
									<img :src="props.option.display_image" class="option__image img-circle" width="40" height="40">
									<span class="option__desc">
										<span class="option__title small">{{ props.option.description }}</span>
									</span>
								</template>
								<template slot="option" slot-scope="props"><img class="option__image img-circle" width="40" height="40" :src="props.option.display_image">
									<div class="option__desc">
										<span class="option__title small">{{ props.option.description }}</span>
									</div>
								</template>
							</multiselect>
						</div>
					</div>

					<div class="card">
						<div class="card-header no-border">
							<div class="d-flex justify-content-between">
								<h3 class="card-title">Tags</h3>
								<a href="javascript:void(0);"><h5>View all tags</h5></a>
							</div>
						</div>

						<div class="card-body">
							<multiselect v-model="product.tags" deselect-label="Can't deselect" track-by="id" label="value" placeholder="Choose tags" open-direction="bottom"
							:options="tags" 
							:searchable="true"
							:allow-empty="false"
							:hide-selected="true"
							:taggable="true"
							:multiple="true"
							tag-placeholder="Add this as tag"
							@input="selectTag"
							@tag="addTag">
						</multiselect>
					</div>
				</div>

						<!-- <div class="card">
							<div class="card-header no-border">
								
								<h3 class="card-title">SEO Optimization <i class="far fa-question-circle small text-secondary"></i></h3>
								
							</div>

							<div class="card-body">
								<div class="form-group">
									<label for="">Meta Title</label>
									<input v-model="product.metatitle" class="form-control" :class="{ 'is-invalid' : product.errors.has('metatitle') }" type="text" name="metatitle" placeholder-shown="Meta Title" placeholder="Meta Title">
									<has-error :form="product" field="metatitle"></has-error>
								</div>

								<div class="form-group">
									<label for="">Meta Description</label>
									<textarea v-model="product.metadesc" class="form-control" :class="{ 'is-invalid' : product.errors.has('metadesc') }" type="text" name="metadesc" placeholder-shown="Meta Description" placeholder="Meta Description" rows="5"></textarea>
									<has-error :form="product" field="metadesc"></has-error>
								</div>
							</div>
						</div>
					-->
				</div>
			</div>
		</div>
	</div>
</div>
</template>
<script>

import { VueEditor } from 'vue2-editor';

Vue.component('variant-update', {
	props: {
		variant: Object,
		variants: Array,
		index: Number,
		loadedVariants: Array,

	},
	data() {
		return {

			value: this.variant,
			loadedOptions: [],

		}
	},

	methods: {

		getName: function({id, name}) {
			return `${name}`;
		},

		onChange: function(variant){
			// this.variant.id = variant.id;
			// this.variant.name = variant.name;
			// this.variant.options = [];
			// this.loadOptions(variant.id);
			this.variantCheck();  
		},

		variantCheck: function() {
			this.$emit("variantCheck");
		},

		loadOptions: function() {
			axios.get('/api/attributes/variants/options/get/' + this.variant.variantid).then(({ data })=>(this.loadedOptions = data));
		},

		removeVariant: function(index) {
			alert(index);
			this.$emit("removeVariant", index);
		},

		addNewVariant: function(newVariant) {
			this.$emit("addNewVariant", newVariant);
		},

		addVariantOption: function(newOption) {
			const option = {
				description: newOption,
				variantID: this.variant.id
			}
			this.$emit("addVariantOption", option);
			this.loadOptions(this.variant.id);
		}

	},

	mounted(){
		this.loadOptions();
		this.variantCheck(); 
	},

	template: `
		
		<div class="form-group">
			
			<div class="d-flex justify-content-between">
				<label for="">Option {{ index + 1 }}</label>
			</div>						
			<div class="row mb-2">
				<div class="col-6 col-sm-5">
					<multiselect v-model="value" deselect-label="Can't deselect" track-by="id" label="name" placeholder="Select variant" open-direction="bottom" 
					:options="loadedVariants" 
					:searchable="true"
					:allow-empty="false"
					:custom-label="getName"
					:hide-selected="true"
					:taggable="true"
					tag-placeholder="Add this as variant"
					@tag="addNewVariant"
					disabled>
					</multiselect>
				</div>
				<div class="col-6 col-sm-7">
					<multiselect v-model="variant.options" deselect-label="Can't deselect"
					track-by="id" label="value" placeholder="Select Options" open-direction="bottom" 
					:options="loadedOptions" 
					:searchable="true"
					:allow-empty="false"
					:hide-selected="true"
					:taggable="true"
					:multiple="true"
					tag-placeholder="Add this as option"
					@input="variantCheck"
					@tag="addVariantOption">
					</multiselect>
				</div>
			</div>
		</div>				
		`,

});
export default {
	data() {

		return {

			product: new Form({
				name: null,
				category_id: null,
				price: null,
				compare_price: null,
				combination: null,
				collections: [],
				cost: null,
				qty: null,
				sku: null,
				description: null,
				tags: [],
				collections: [],
				productVariants: [],
				selectedItem: [],
				images: [],
				variants: [],
				variantcount: null,
				options: [],
				staff_id: null,
				metatitle: null,
				metadesc: null
			}),

			images: [],
			newImages: [],
			category: {
				id: null,
				description: null
			},
			categories: [],
			collections: [],
			tags: [],
			imageCount: 0,
			variants: [],
			variantValue: [],
			productVariants: [],
			options: [],
			newOptions: [],
			loadedVariants: [],
			selectedItem: [],
			activeItems: [],
			prodid: null,
			imgSrc: null,
			qty: 0,
			isAddVariant: false,

			toolBar: [["bold", "italic", "underline"],[{ list: "ordered" }, { list: "bullet" }]],
		}

	},

	methods: {
		uploadImage: function(e) {

			var image = {
				id: null,
				name: "",
				product_id: null
			}

			let images = e.target.files;
			let counter = 0;
			do {
				let reader = new FileReader();

				reader.onloadend = files => {
					image.name = reader.result;
					image.product_id = this.prodid;
					//Vue.set(this.product.images, key, value)
					this.product.images.push(image);
					return this.product.images;
				};

				reader.readAsDataURL(images[counter]);
				counter++;
			} while(counter < images.length);
			

			
		},

		clickUpload: function() {
			document.getElementById("imgUpload").click();
		},

		selectCollection: function(){

		},

		selectTag: function() {

		},


		addTag: function(tags) {
			let newTag = new Form({
				tag: tags
			});

			newTag.post('/api/attributes/tags/add')
			.then(() => {
				this.loadTags();

			})
			.catch(({error}) => { console.log(error.message); });
		},



		addCategory: function(newCat) {
			let newCategory = new Form({
				description: newCat
			});

		},

		selectCategory: function(category) {
			this.product.categoryID = category.id;
		},

		getCategory: function({id, description}) {
			return `${description}`;
		},

		getOptionValue: function({id, value}) {
			return `${value}`;
		},

		loadCategories: function() {
			axios.get('/api/attributes/category/get').then(({ data })=>{
				this.categories = data;
				for(var x = 0;x < this.categories.length;x++){
					if(this.categories[x].id == this.product.category_id){
						this.category.id = this.categories[x].id;
						this.category.description = this.categories[x].description;

					}
				}

			});
		},

		loadCollections: function() {
			axios.get('/api/attributes/collections/get').then(({ data })=>(this.collections = data));
		},

		loadTags: function() {
			axios.get('/api/attributes/tags/get').then(({ data })=>(this.tags = data));
		},

		viewProduct: function() {
			axios.get('/api/product/edit/' + this.prodid).then(( data ) => {
				this.product.fill(data.data[0]);
				// if(this.product.variantcount > 1 && this.product.combination != "NONE") {
					this.getVariants();
					axios.get('/api/inventory/getItem/' + this.prodid).then((data) => (this.selectedItem = data.data));
				// }
			});
		},

		getVariants: function() {

			axios.get('/api/product/getVariantValue/'+this.prodid)
			.then((data) => {
				this.variantValue = data.data;
				this.assignVariant();
				this.getOption();
			});

		},

		assignVariant: function() {
			for(var x = 0;x < this.variantValue.length;x++){
				var varval = {
				id: null,
				name: null,
				variantid: null,
				options: []
			}
				varval.id = this.variantValue[x].id;
				varval.name = this.variantValue[x].name;
				varval.variantid = this.variantValue[x].variantid;
				varval.options = [];
				this.variants.push(varval);
			}
		},

		addVariant: function() {
			this.isAddVariant = !this.isAddVariant;
			// var variant = {
			// 	id: null,
			// 	name: null,
			// 	options: []
			// }

			// this.variants.push(variant);

		},

		cancelVariant: function() {
			this.isAddVariant = !this.isAddVariant;
		},

		removeVariant: function(index){
			this.variants.splice(index, 1);

			this.variantCheck();
		},

		addNewVariant: function(newVar) {
			let newVariant = new Form({
				name: newVar
			});

			newVariant.post('/api/attributes/variants/add')
			.then(() => {
				this.loadVariants();
			})
			.catch(({error}) => { console.log(error.message); });
		},

		addVariantOption: function(newOpt) {
			console.log(newOpt);
			let newOption = new Form({
				value: newOpt.description,
				variantID: newOpt.variantID
			});

			console.log(newOption);

			newOption.post('/api/attributes/variants/options/add')
			.then(() => {
				this.loadVariants();
			})
			.catch(({error}) => { console.log(error.message); });
		},

		variantCheck: function() {
			var counter = 0, name = this.product.name + "-", combination = "";
			this.productVariants = [];

			if(counter < this.variants.length){
					//Passes a variant object
					
					this.generateProductVariants(counter, this.variants[counter], name, combination);
				}
			},

			generateProductVariants: function(counter, variant, name, combination) {
			// Loop for selecting options per variant
			var temp = name;
			var comb = combination;
			
			for(var index = 0; index < variant.options.length; index++) {
				temp += variant.options[index].value + " ● ";
				comb += variant.options[index].id + "-";
				if((counter + 1) < this.variants.length) {
					this.generateProductVariants(counter + 1, this.variants[counter + 1], temp, comb);
				} else {
					var productVariant = {
						name: temp.slice(0, (temp.length - 2)),
						combination: comb.slice(0, (comb.length - 1)),
						isChecked: true,
						price: this.product.price,
						quantity: this.product.quantity,

					};

					productVariant.sku = this.product.sku + "-" + productVariant.combination;
					this.productVariants.push(productVariant);

				}

				temp = name;
				comb = combination;

				console.log("hello");

			}
		},

		loadVariants: function() {
			axios.get('/api/attributes/variants/get').then(({ data })=>(this.loadedVariants = data));
		},



		removeImage: function(index) {
			this.product.images.splice(index, 1);
			return this.product.images;
		},

		getImages: function() {
			axios.get('/api/product/images/' + this.prodid).then(( data ) => {
				this.product.images = data.data;
				// for(var x = 0; x < data.data.length; x++){
				// 	this.product.images.push({
				// 		id: data.data[x].id,
				// 		name: data.data[x].name,
				// 		product_id: data.data[x].product_id
				// 	});
				// }
					//this.imageCount = this.product.images.length;
					//this.imgSrc = this.product.images[0].name;
				});

		},

		getProdCollections: function() {
			axios.get('/api/product/getProdCollections/' + this.prodid).then(( data )=>(this.product.collections = data.data));
		},

		getProdTags: function() {
			axios.get('/api/product/getProdTags/' + this.prodid).then(( data )=>(this.product.tags = data.data));
		},

		getOption: function() {
			for(var x = 0;x < this.variantValue.length;x++){
				axios.get('/api/attributes/variants/options/get/' + this.variantValue[x].variantid).then(({ data })=>{
					this.options.push(data);
				});
			}
			//console.log(this.options);
		},

		assignOptions: function() {
			var option = {
				id: null,
				prodvarid: null,
				value: null,
				variant_id: null

			};
			for(var x = 0;x < this.variants.length;x++ ){
				for(var y = 0;y < this.variants[x].options.length;y++){
					option.id = this.variants[x].options[y].id;
					option.prodvarid = this.variants[x].id;
					option.value = this.variants[x].options[y].value;
					option.variant_id = this.variants[x].options[y].variant_id;
					this.newOptions.push(option);
				}
			}
		},

		saveProduct: function() {
			this.product.selectedItem = this.selectedItem;
			if(this.product.selectedItem.length == 1){
				this.product.selectedItem[0].quantity = this.product.qty;
			}
			this.product.productVariants = this.productVariants;
			this.product.variants = this.variants;
			this.assignOptions();
			this.product.options = this.newOptions;
			this.product.category_id = this.category.id;
			this.$Progress.start();
				this.product.put('/api/product/'+ this.prodid)
					.then(() => {
						this.$Progress.finish();
						Toast.fire({
							icon: 'success',
							title: 'Staff Updated Successfully'
						});
						Fire.$emit('AfterCreate');
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
		this.prodid = this.$route.params.productid;
		this.viewProduct();
		this.getImages();
		this.loadCategories();
		this.loadVariants();
		this.loadCollections();
		this.loadTags();
		this.getProdCollections();
		this.getProdTags();
		console.log(this.product);
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
	background: -webkit-gradient(linear,left bottom,left top,color-stop(0,#dc3545),color-stop(1,#e4606d));
}


::-webkit-scrollbar-thumb:hover {
	background: #555; 
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