<template>

	<div class="container-fluid">

		<div class="jumbotron">
			<div class="d-flex align-items-end justify-content-between">
				<h1>Collections</h1>
				<button class="btn btn-success" trigger="hover" data-toggle="tooltip" title="Create Collection" @click="addCollection">
					<span><i class="fa fa-plus-circle white" aria-hidden="true"></i> Add New Collection</span>
				</button>
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
										<input v-model="searchQuery" class="form-control border rounded-right" placeholder="Search" aria-label="Search">
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
						<div class="table-responsive">
							<table class="table table-hover no-border">
								<!-- <thead class="thead-dark">
									<tr>
										<th></th>
										<th></th>
										<th>
											<div class="input-group input-group-sm">
												<div class="input-group-prepend">
													<button class="search-button-text border border-0 rounded-left " @click.prevent="">
														<i class="fa fa-search"></i>
													</button>
												</div>
												<input v-model="searchQuery" class="form-control border border-0 rounded-right" placeholder="Search" aria-label="Search">
											</div>
										</th>
										
										
									</tr>
								</thead> -->
								<thead class="thead-light">
									<tr>
										<th class="text-center w-50">Collection Name</th>
										<th class="text-center w-25">Status</th>
										<th class="text-center w-25">Action</th>
										
									</tr>
								</thead>
								<tbody>
									<tr v-if="collections.length == 0">
										<td colspan="4" align="center">
											<div class="overlay" style="font-size: 25px; font-weight: bolder;">
												<i class="fa fa-spinner fa-spin red"></i>
											</div>
										</td>
									</tr>

									<tr v-else v-for="collection in filteredCollections" :key="collection.id">
										<td class="text-center">{{ collection.description }}</td>
										<td class="text-center">
											<span class="badge badge-pill" :class="[collection.isactive == 1 ? 'badge-success' : 'badge-secondary']">{{ collection.isactive == 1 ? "Active" : "Inactive" }}</span>
										</td>
										<td class="text-center">
											<button class="btn btn-warning btn-sm" trigger="hover" data-toggle="tooltip" title="Edit Collection" @click="editCollection(collection)" v-if="collection.isactive == 1"><i class="fas fa-pencil-alt"></i></button>
											<router-link :to="{ path: '/collections/'+collection.id+'/viewcollection', params: { collectionID: collection.id } }" class="btn btn-info btn-sm" trigger="hover" data-toggle="tooltip" title="View Collection"><i class="fas fa-eye"></i></router-link>
											<button class="btn btn-success btn-sm" trigger="hover" data-toggle="tooltip" title="Activate Collection" v-if="collection.isactive == 0 || collection.isactive == null" @click="enableCollection(collection.id)"><i class="fas fa-check"></i></button>
	
											<button class="btn btn-danger btn-sm" trigger="hover" data-toggle="tooltip" title="Disable Collection" v-if="collection.isactive == 1" @click="disableCollection(collection.id)"><i class="fas fa-trash"></i></button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="addCollection" tabindex="-1" role="dialog" aria-labelledby="addCollectionLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="addCollectionLabel">{{ updateMode ? "Edit Collection" : "Add Collection" }}</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>


					
					<div class="modal-body">
						<div class="content">
							<div class="container-fluid">
								<div class="row">

									<div class="col-sm-12">


										<div class="form-group">
											<div class="row">

												<div class="col-sm-12">
													<div class="form-group">
														<label for="">Title</label>
														<input class="form-control" type="text" name="name" placeholder="e.g (BTS Collection, Under P250, Korean Experience...)" v-model="collection.description" :class="{ 'is-invalid' : collection.errors.has('description') }" >
														<has-error :form="collection" field="description"></has-error>
													</div>
												</div>
											</div>
										</div>
										<label for="">Image</label>

										<div class="row text-center" >
											<div class="col-sm-6">
												<div class="w-100 border-info pt-2":class="[collection.display_image == null ? 'opacity' : '']" style="height: 250px; border: dashed; cursor: pointer;" @click="addDP">
													<img :src="collection.display_image == null ? '/img/designs/svg/pictures.svg' : collection.display_image" class="w-75 h-100">
													<input id="display_image" name="display_image" type="file" @change="uploadDP" hidden :class="{ 'is-invalid' : collection.errors.has('display_image') }" />
													<has-error :form="collection" field="display_image"></has-error>
												</div>
												<div class="small blue">{{ collection.display_image == null ? 'Add' : 'Change' }} Display Image</div>
											</div>
											<div class="col-sm-6">
												<div class="w-100 border-info pt-2":class="[collection.cover_image == null ? 'opacity' : '']" style="height: 250px; border: dashed; cursor: pointer;" @click="addCP">
													<img :src="collection.cover_image == null ? '/img/designs/svg/pictures.svg' : collection.cover_image" class="w-75 h-100">
													<input id="cover_image" name="cover_image" type="file" @change="uploadCP" hidden :class="{ 'is-invalid' : collection.errors.has('cover_image') }" />
													<has-error :form="collection" field="cover_image"></has-error>
												</div>
												<div class="small blue">{{ collection.cover_image == null ? 'Add' : 'Change' }} Cover Image</div>
											</div>
										</div>

										<!-- <div class="form-group">
											<label for="">Meta Title</label>
											<input v-model="product.metatitle" class="form-control" :class="{ 'is-invalid' : product.errors.has('metatitle') }" type="text" name="metatitle" placeholder-shown="Meta Title" placeholder="Meta Title">
											<has-error :form="product" field="metatitle"></has-error>
										</div>

										<div class="form-group">
											<label for="">Meta Description</label>
											<textarea v-model="product.metadesc" class="form-control" :class="{ 'is-invalid' : product.errors.has('metadesc') }" type="text" name="metadesc" placeholder-shown="Meta Description" placeholder="Meta Description" rows="5"></textarea>
											<has-error :form="product" field="metadesc"></has-error>


										</div> -->
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary" @click.prevent="updateMode ? updateCollection() : saveCollection()">{{ updateMode ? "Apply Changes" : "Save" }}</button>
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

				collection: new Form({
					id: null,
					description: null,
					cover_image: null,
					display_image: null
				}),


				// Data Handlers
				collections: [],


				// Watched Data
				// 
				filters: ["All", "Unpublished", "Published"],


				filter: "",
				searchQuery: "",
				updateMode: false,
				
				count: 0,
				
				

			}
		},
		computed: {
			filteredCollections: function() {
				if(this.searchQuery){
					return this.collections.filter((collection)=>{
						if( (collection.description.toString().toLowerCase().search(this.searchQuery.toString().toLowerCase()) > -1)) {
							return collection.description;
						}
					})
				}else{
					return this.collections;
				}
			}
		},

		methods: {
			addCollection: function() {
				this.updateMode = false;
				this.collection.reset();
				$('#addCollection').modal('show');
			},

			addDP: function() {
				document.getElementById('display_image').click();
			},

			addCP: function() {
				document.getElementById('cover_image').click();
			},

			uploadDP: function(e) {
				let image = e.target.files[0];

				let reader = new FileReader();

				reader.onloadend = files => {

					this.collection.display_image = reader.result;
					console.log(reader.result.length);
				};

				reader.readAsDataURL(image);
			},

			uploadCP: function(e) {
				let image = e.target.files[0];

				let reader = new FileReader();

				reader.onloadend = files => {

					this.collection.cover_image = reader.result;
					console.log(reader.result.length);
				};

				reader.readAsDataURL(image);
			},

			saveCollection: function() {
				this.$Progress.start();
				this.collection.post('/api/collections')
				.then(() => {
					this.$Progress.finish();
					$('#addCollection').modal('hide');
					Toast.fire({
						type: 'success',
						title: 'Collection Created Successfully'
					});
					Fire.$emit('AfterCreate');
				})
				.catch(({error}) => { console.log(error.message); });
			},

			editCollection: function(collection) {
				this.updateMode = true;
				this.collection.reset();
				$('#addCollection').modal('show');
				this.collection.fill(collection);
			},

			updateCollection: function(id) {
				this.$Progress.start();
				this.collection.put('/api/collections/'+this.collection.id)
					.then(() => {
						this.$Progress.finish();
						$('#addCollection').modal('hide');
						Toast.fire({
							type: 'success',
							title: 'Collection Updated Successfully'
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
			},

			disableCollection: function(id) {
				Swal.fire({
					title: 'Are you sure?',
					text: "You may revert this some other time!",
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, disable it!'
				}).then((result) => {

					if(result.value){
						this.$Progress.start();
						this.collection.delete('/api/collections/'+id)
							.then(() => {
								this.$Progress.finish();
								Swal.fire(
									'Disabled!',
									'A collection has been disabled.',
									'success')
								Fire.$emit('AfterCreate');
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

			enableCollection: function(id) {
				Swal.fire({
					title: 'Enable Collection',
					text: "Enable collection?",
					type: 'info',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Enable'
				}).then((result) => {

					if(result.value){
						this.$Progress.start();
						this.collection.get('/api/collections/restore/'+id)
							.then(() => {
								this.$Progress.finish();
								Swal.fire(
									'Enabled!',
									'A collection has been enabled.',
									'success')
								Fire.$emit('AfterCreate');
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

			loadCollections: function() {
				axios.get('/api/collections').then(({ data })=>(this.collections = data));
			}
		},

		created: function() {
			this.loadCollections();

			Fire.$on('AfterCreate', () => {
				this.loadCollections();
			});
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

	.opacity {
		opacity: .5;
	}



</style>
