<template>

	<div class="container-fluid">

		<div class="jumbotron">
			<div class="d-flex align-items-end justify-content-between">
				<h1>Purchase Order</h1>
				<router-link to="/porder/add" class="btn btn-success" trigger="hover" data-toggle="tooltip" title="Add New Product">
					<span><i class="fa fa-receipt white" aria-hidden="true"></i> Create Purchase Order</span>
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
										<input v-model="searchQuery" @keyup="searchPO" class="form-control border rounded-right" placeholder="Search" aria-label="Search">
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
										
										<th class="text-center w-10">#</th>
										<th class="text-center w-50">Source</th>
										<th class="text-center w-10">Status</th>
										<th class="text-center w-15">ETA</th>
										<th class="text-center w-15">Action</th>
									</tr>
								</thead>

								<tbody class="border">
									<tr v-for="porder in porders.data" :key="porder.id">
										<td class="text-center">{{ porder.id }}</td>
										<td class="text-center">{{ porder.sourcename }}</td>
										<td class="text-center">
											<span class="badge badge-pill" :class="{'badge-warning': porder.po_status_id == 1 || porder.po_status_id == 2, 'badge-success': porder.po_status_id == 3 }">{{ porder.postat }}</span>
										</td>
										<td class="text-center">{{ porder.expected_arrival }}</td>
										<td class="text-center">
											<button class="btn btn-danger btn-sm" v-if="porder.status == 1"><i class="fas fa-trash"></i></button>
											
											<router-link :to="{ path: '/porder/'+porder.id+'/view', params: { porderid: porder.id } }" class="btn btn-info btn-sm"><i class="far fa-fw fa-eye"></i></router-link>
											<router-link :to="{ path: '/porder/'+porder.id+'/print', params: {porderid: porder.id} }" class="btn btn-info btn-sm">
											<i class="fas fa-print"></i>
											</router-link>
										</td>
									</tr>
									
								</tbody>
							</table>
						</div>
						<pagination :data="porders" @pagination-change-page="getResults"></pagination>
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
				filters: ["All", "Unpublished", "Published"],
				searchQuery: '',
				porders: []
			}
		},

		methods: {
			searchPO: _.debounce(function() {
				axios.get('/api/porder/search?po=' + this.searchQuery)
					.then(response => {
						this.porders = response.data;
					})
					.catch((error) => {

					})
			}, 1000),

			getResults: function(page = 1) {
				axios.get('/api/porder?page=' + page)
					.then(response => {
						this.porders = response.data;
					});
			},

			createPO: function() {

			},

			loadPO: function() {
				axios.get('/api/porder').then(( data ) => {this.porders = data.data});
			}
		},

		created() {
			this.loadPO();
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

	.w-70 {
		width: 70%;
	}

	.w-40 {
		width: 40%;
	}

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

</style>
