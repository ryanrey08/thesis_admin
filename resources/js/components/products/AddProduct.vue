<template>
	<div class="container-fluid">
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-md-12">
						<div class="d-flex justify-content-between">
							<h1 class="m-0 text-dark">Add Product</h1>
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
											@tag="addCategory"
											:class="{ 'is-invalid' : product.errors.has('categoryID') }">
											</multiselect>
											<has-error :form="product" field="categoryID"></has-error>
										</div>
									</div>
								</div>
								<label for="productdesc">Description</label>
								<vue-editor id="productdesc" v-model="product.description" :editor-toolbar="toolBar" :class="{ 'is-invalid' : product.errors.has('description') }"></vue-editor>
								<has-error :form="product" field="description"></has-error>
							</div>
						</div>
						<div class="card">
							<div class="card-header no-border">
								<div class="d-flex justify-content-between">
									<h3 class="card-title">Images</h3>
									<a href="" @click.prevent="clickUpload"><h6>Upload Images</h6></a>
									<input id="imgUpload" name="images[]" multiple type="file" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" hidden @change="uploadImage" :class="{ 'is-invalid' : product.errors.has('images') }"/>
									<has-error :form="product" field="images"></has-error>

								</div>
							</div>

							<div class="card-body text-center">
								
								<img src="/img/designs/svg/pictures.svg" class="w-25" style="opacity: .5" v-if="product.images.length == 0">
								<div class="d-flex p-2" style="height: 200px; overflow-y: scroll;" v-else>
									<div class="row">
										<div class="p-1 imageHolder"
										v-for="(image, index) in product.images"
										:key="index"
										title="Click to remove photo"
										@click="removeImage(index)">
											<img class="productImage" :src="image">
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
													<input v-model="product.price" type="number" class="form-control" placeholder="0.00" :class="{ 'is-invalid' : product.errors.has('price') }" name="price" min="0">
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
													<input v-model="product.compare_price"  type="number" class="form-control" placeholder="0.00" name="compare_price" min="0" :class="{ 'is-invalid' : product.errors.has('compare_price') }">
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
													<input v-model="product.cost"  type="number" class="form-control" placeholder="0.00" name="cost" min="0"
													:class="{ 'is-invalid' : product.errors.has('cost') }">
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
													<input v-model="product.sku" type="text" class="form-control" placeholder="SKU" name="sku" :class="{ 'is-invalid' : product.errors.has('sku') }">
													<div class="input-group-append">
														<span class="input-group-text" id="basic-addon2" @click="generateSKU">Generate</span>
													</div>
													<has-error :form="product" field="sku"></has-error>
												</div>

											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<label for="">Quantity</label>
												<input v-model="product.quantity" type="number" class="form-control" placeholder="0" name="quantity" min="0" :class="{ 'is-invalid' : product.errors.has('quantity') }">
												<has-error :form="product" field="quantity"></has-error>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<label for="">Stock Threshold</label>
												<input v-model="product.threshold" type="number" class="form-control" placeholder="0" name="threshold" min="0" :class="{ 'is-invalid' : product.errors.has('treshold') }">
												<has-error :form="product" field="threshold"></has-error>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						

						<div class="card">
							<div class="card-header no-border">
								<div class="d-flex justify-content-between">
									<h3 class="card-title">Variants</h3>
									<!-- <a href="javascript:void(0);"><h5>Add Variant</h5></a> -->
									<button class="btn btn-outline-primary no-border" @click.prevent="addVariant" v-if="variants.length == 0">Add Variant</button>
									<button class="btn btn-outline-danger no-border" @click.prevent="clearVariants" v-else>Cancel</button>
								</div>
							</div>

							<div class="card-body">
								<p>Add variants if this product comes in multiple versions, like different sizes or colors.</p>
								<hr>
								<div class="row" >
									<div class="col-sm-12" v-if="variants.length > 0">
										
										<div v-for="(variant, index) in variants" :key="index"  class="form-row">
											<div class="col">
												<variant-inputs
													:variant="variant" 
													:loadedVariants="loadedVariants"
													:index="index"
													@variantCheck="variantCheck"
													@removeVariant="removeVariant"
													@addNewVariant="addNewVariant"
													@addVariantOption="addVariantOption">
												</variant-inputs> 
											</div>
											
											
										</div>
										<div class="form-group">
											<button class="btn btn-outline-primary form-control" @click.prevent="addVariant" ><i class="fa fa-plus fa-fw"></i> Add another option</button>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer" v-if="product.productVariants.length > 0">
								
								<div class="row" >
									<div class="col-sm-12" v-if="variants.length > 0" >
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
													<tr v-for="(provar, index) in product.productVariants" :key="index" :id="index">
														<th scope="row">
															<div class="custom-control custom-checkbox">
																<input class="custom-control-input" type="checkbox" checked @change="checking(provar, index)" :id="'provar_' + index">
																<label class="custom-control-label text-muted" :for="'provar_' + index">
																</label>
															</div>
														</th>
														<td>{{ provar.name }}</td>
														<td>
															<input v-model="provar.price" class="form-control" type="number" placeholder="Price" min="0">
														</td>
														<td>
															<input v-model="provar.sku" class="form-control" type="text" placeholder="SKU">
														</td>
														<td>
															<input v-model="provar.quantity" class="form-control" type="number" placeholder="Quantity" min="0">
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
						</div>-->
					</div>
				</div>
				<div class="footer p-3 bg-light w-100 border-top border-secondary d-flex justify-content-end">
					<router-link to="/product" class="btn btn-light w-25" data-toggle="tooltip" title="Discard">
						<span>Cancel</span>
					</router-link>
					<button class="btn btn-success w-25" @click.prevent="saveProduct" data-toggle="tooltip" title="Save Product">Save</button>
				</div>
			</div>
		</div>
	</div>

</template>


<script>

	import { VueEditor } from 'vue2-editor';

	Vue.component('variant-inputs', {
		props: {
			variant: Object,
			variants: Array,
			index: Number,
			loadedVariants: Array,

		},
		data() {
			return {

				value: null,
				loadedOptions: [],

			}
		},

		methods: {

			getName: function({id, name}) {
				return `${name}`;
			},

			onChange: function(variant){
				this.variant.id = variant.id;
				this.variant.name = variant.name;
				this.variant.options = [];
				this.loadOptions(variant.id);
				this.variantCheck();  
			},

			variantCheck: function() {
				this.$emit("variantCheck");
			},

			loadOptions: function(id) {
				axios.get('/api/attributes/variants/options/get/' + id).then(({ data })=>(this.loadedOptions = data));
			},

			removeVariant: function(index) {
				//alert(index);
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

		template: `
		
		<div class="form-group">
			
			<div class="d-flex justify-content-between">
				<label for="">Option {{ index + 1 }}</label>
				<button class="btn btn-outline-danger" @click.prevent="removeVariant(index)"><i class="fa fa-trash"></i></button>
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
					@input="onChange"
					@tag="addNewVariant">
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
	components: {
		VueEditor, 
	},

	data() {

		return {
			
			product: new Form({
				name: null,
				categoryID: null,
				price: 0.00,
				compare_price: 0.00,
				cost: 0.00,
				quantity: 0,
				threshold: 0,
				sku: null,
				description: null,
				tags: [],
				collections: [],
				productVariants: [],
				images: [],
				variants: [],
				staffID: null,
				metatitle: null,
				metadesc: null,

			}),

			staff: new Form({
				id: null,
				name: null,
			}),

			category: null,
			
			variants: [],

			categories: [],
			tags: [],
			collections: [],

			loadedVariants: [],

			loadedOptions: [],

			toolBar: [["bold", "italic", "underline"],[{ list: "ordered" }, { list: "bullet" }]],

		}

	},

	methods: {
		getStaff: function() {
			axios.get("/api/profile").then(({data}) => this.staff.fill(data));
		},

		saveProduct: function() {

			this.product.staffID = this.staff.id;
			this.product.productVariants = this.filterVariants(this.product.productVariants);
			this.product.variants = this.variants;
			console.log(this.product);
			this.$Progress.start();
			this.product.post('/api/product')
			.then(() => {
				this.$Progress.finish();
				$('#addProduct').modal('hide');
				Toast.fire({
					icon: 'success',
					title: 'Product Added Successfully'
				});
				Fire.$emit('ProductCreate');
			})
			.catch(({error}) => { this.$Progress.finish(); });
		},

		filterVariants: function(productVariants){


			let provar = [];
			for(let index = 0; index < productVariants.length; index++) {
				if(productVariants[index].isChecked) {
					provar.push(productVariants[index]);
				}
			}

			return provar;
		},

		addCategory: function(newCat) {
			let newCategory = new Form({
				description: newCat
			});

			newCategory.post('/api/attributes/category/add')
			.then(() => {
				this.loadCategories();
			})
			.catch(({error}) => { console.log(error.message); });
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

		checking: function(provar, index) {
			let row = document.getElementById(index);
			let inputs = row.querySelectorAll("input");

			provar.isChecked = !provar.isChecked;

			if(provar.isChecked) {
				this.disableInput(inputs, false)
			} else {
				this.disableInput(inputs, true)
			}
		},

		disableInput: function(inputs, status) {
			for(let counter = 1; counter < inputs.length; counter++) {
				if(status) {
					inputs[counter].setAttribute('disabled', 'true');
				} else {
					inputs[counter].removeAttribute('disabled', 'false');
				}
			}
		},

		uploadImage: function(e) {

			let images = e.target.files;
			let counter = 0;
			do {
				let reader = new FileReader();

				reader.onloadend = files => {

					this.product.images.push(reader.result);
				};

				reader.readAsDataURL(images[counter]);
				counter++;
			} while(counter < images.length);
			

			
		},

		clickUpload: function() {
			document.getElementById("imgUpload").click();
		},

		removeImage: function(index) {
			this.product.images.splice(index, 1);
			return this.product.images;
		},

		selectCollection: function(){

		},

		selectTag: function() {

		},

		selectCategory: function(category) {
			this.product.categoryID = category.id;
		},

		getCollection: function({id, name}) {
			return `${name}`;
		},

		getTag: function({id, tag}) {
			return `${tag}`;
		},

		getCategory: function({id, description}) {
			return `${description}`;
		},

		loadAttributes: function() {

			this.loadCategories();
			this.loadCollections();
			this.loadTags();
			this.loadVariants();
		},

		loadCategories: function() {
			axios.get('/api/attributes/category/get').then(({ data })=>(this.categories = data));
		},

		loadCollections: function() {
			axios.get('/api/attributes/collections/get').then(({ data })=>(this.collections = data));
		},

		loadTags: function() {
			axios.get('/api/attributes/tags/get').then(({ data })=>(this.tags = data));
		},

		loadVariants: function() {
			axios.get('/api/attributes/variants/get').then(({ data })=>(this.loadedVariants = data));
		},


		searchVariant: function(key) {
			this.filteredVariants = [];
			console.log(key);

			if(key.trim() != "" && key.trim() != null){
				for(var index = 0; index < this.loadedVariants.length; index++) {
					if(this.searchColumn(key, this.loadedVariants[index].name) > -1) {
						this.filteredVariants.push(this.loadedVariants[index]);
					}
				}
			}
		},

		searchColumn: function(key, column) {
			return column.toString().toLowerCase().search(key);
		},

		addVariant: function() {

			var variant = {
				id: null,
				name: null,
				options: []
			}

			this.variants.push(variant);

		},

		removeVariant: function(index){
			this.variants.splice(index, 1);

			this.variantCheck();
		},

		clearVariants: function() {
			this.variants = [];

			this.variantCheck();
		},

		variantCheck: function() {
			var counter = 0, name = this.product.name + "-", combination = "";
			this.product.productVariants = [];

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
					this.product.productVariants.push(productVariant);

				}

				temp = name;
				comb = combination;


			}
		},

		generateSKU: function() {
			var vowels = "aeiouAEIOU0123456789 ";
			var sku = "";
			var found = false;

			for(var index = 0; index < this.product.name.length; index++) {
				found = false;
				for(var inner = 0; inner < vowels.length; inner++) {
					if(this.product.name[index] === vowels[inner]) {
						found = true;
						break;
					}
				}

				if(!found) {
					sku += this.product.name[index].toUpperCase();
				}
			}


			sku += "-" + this.product.categoryID;

			this.product.sku = sku;
		},

		removeOption: function(varOption, index) {
			varOption.splice(index, 1);
			this.variantCheck();
		}
	},

	created: function() {

		this.getStaff();
		this.loadAttributes();
		// $('[data-toggle="tooltip"]').tooltip('hide'); 
		Fire.$on('ProductCreate', () => {
			window.location.assign("/product");
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

	textarea {
		resize: none;
	}

	
</style>









