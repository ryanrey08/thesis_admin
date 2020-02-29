<template>

	<div class="container-fluid">
		<div class="jumbotron">
			<div class="d-flex align-items-end justify-content-between">
				<h1>Sources</h1>
				<button  class="btn btn-success" trigger="hover" data-toggle="tooltip" title="Add New Source" @click="addSource">Add New Source</button>
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
										<input v-model="searchQuery" @keyup="searchSource" class="form-control border rounded-right" placeholder="Search" aria-label="Search">
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
						                <select class="custom-select border-0">
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
										<th class="text-center w-25">Name</th>
										<th class="text-center w-20">Contact</th>
										<th class="text-center w-50">Address</th>
										<!-- <th class="text-center w-10">Action</th> -->
									</tr>
								</thead>

								<tbody class="border">
									<tr v-for="source in sources.data" :key="source.id">
										<td class="text-center">
											<div class="custom-control custom-checkbox">
												<input class="custom-control-input" type="checkbox">
												<label class="custom-control-label text-muted">
												</label>
											</div>
										</td>
										<td class="text-center">{{ source.name }}</td>
										<td class="text-center">{{ source.phone }}</td>
										<td class="text-center">{{ source.address }}</td>
										<!-- <td class="text-center">asdasd</td> -->
									</tr>
									
								</tbody>
							</table>
						</div>
						<pagination :data="sources" @pagination-change-page="getResults"></pagination>
					</div>
				</div>
			</div>

		</div>

		<div class="modal fade" id="addSource" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
				<div class="modal-content" >

					<div class="modal-header">
						<h5 class="modal-title" id="addSourceLabel">Create new sources</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>

					<form @submit.prevent="updateMode ? updateSource() : saveSource() ">
						<div class="modal-body">
							<div class="row">
								<div class="col">

									<label for="">Source Name</label>
									<div class="input-group mb-3">

										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-user-tag fa-fw"></i></span>
										</div>

										<input v-model="source.name" class="form-control" :class="{ 'is-invalid' : source.errors.has('name') }" type="text" name="name" placeholder="Source Name">

										<has-error :form="source" field="name"></has-error>

									</div>

									<label for="">Contact Number</label>
									<div class="input-group mb-3">

										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fa fa-user-lock fa-fw"></i></span>
										</div>

										<input v-model="source.phone" class="form-control" :class="{ 'is-invalid' : source.errors.has('phone') }" type="text" name="phone" placeholder="+639XX XXX XXXX" v-mask="'+639## ### ####'">

										<has-error :form="source" field="phone"></has-error>

									</div>

									<label for="">Address</label>
									<div class="input-group mb-3">

										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fa fa-user-lock fa-fw"></i></span>
										</div>

										<input v-model="source.address" class="form-control" :class="{ 'is-invalid' : source.errors.has('address') }" type="text" name="address" placeholder="Complete Address">

										<has-error :form="source" field="address"></has-error>

									</div>

								</div>

							</div>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">{{ updateMode ? " Apply Changes" : " Save" }}</button>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>


</template>

<script>

	export default {

		data() {
			return {
				source: new Form({
					id: null,
					name: null,
					phone: null,
					address: null,
				}),
				sources: {},
				updateMode: false,
				filters: ["All", "Unpublished", "Published"],
				searchQuery: '',
			}
		},

		methods: {
			searchSource: _.debounce(function() {
				
			}, 1000),

			addSource: function() {
				this.updateMode = false;
				this.source.reset();
				$("#addSource").modal("show");
			},

			editSource: function(source) {
				this.updateMode = true;
				this.source.reset();
				$('#addSource').modal('show');
				this.source.fill(source);
			},

			updateSource: function(id) {
				this.$Progress.start();
				this.source.put('/api/source/'+this.source.id)
				.then(() => {
					this.$Progress.finish();
					$('#addSource').modal('hide');
					Toast.fire({
						type: 'success',
						title: 'Source Updated Successfully'
					});
					// Fire.$emit('AfterCreate');
					this.loadSources();
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

			getResults: function(page = 1) {
				axios.get('/api/source?page=' + page)
					.then(response => {
						this.sources = response.data;
					});
			},

			saveSource: function(){
				this.$Progress.start();
				this.source.post('/api/source')
				.then(() => {
					this.$Progress.finish();
					$('#addSource').modal('hide');
					Toast.fire({
						type: 'success',
						title: 'Source Added Successfully'
					});
					// Fire.$emit('AfterCreate');
					this.loadSources();
				})
				.catch(({error}) => { this.$Progress.finish(); });
			},
			loadSources: function() {
				axios.get('/api/source').then(( data ) => {this.sources = data.data});
			}
		},

		created() {
			this.loadSources();
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