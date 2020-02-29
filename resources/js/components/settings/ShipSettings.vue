<template>
	<div class="w-100">
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-md">
						<div class="d-flex justify-content-between">
							<h1 class="m-0 text-dark">Shipping Settings</h1>
						</div>
					</div>
				</div>
				<button class="btn btn-add" trigger="hover" data-toggle="tooltip" title="Add Location" @click="addLocation">
					<span><i class="white fas fa-map-pin"></i></span>
				</button>
			</div>
		</div>
		<div class="container-fluid">
			<div class="card-body">
				<div class="row">
					<div class="col-6">
						<div id="accordion">

							<div class="card card-light" v-for="location in locations" :key="location.id">
								<div class="card-header">
									<div class="d-flex justify-content-between">
										<h4 class="card-title align-content-center">
												<a data-toggle="collapse" data-parent="#accordion" :href="'#location_' + location.id" class="collapsed links" aria-expanded="false">
												{{ location.cluster }}
											</a>
										</h4>
										<a href="#" class="p-2 align-content-center links" @click.prevent="addLocation(location)"><i class="fas fa-angle-double-right"></i></a>
									</div>
								</div>
								<div :id="'location_' + location.id" class="panel-collapse in collapse" style="">
									<div class="card-body">
										<p>Shipping Fee: ₱ {{ location.shippingfee }}</p>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-6"></div>
				</div>
			</div>
			
			
			<div class="modal fade" id="addLocation" tabindex="-1" role="dialog" aria-labelledby="addLocationTitle" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="addLocationTitle">Add Location</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-5">
									<p>
										<label for="">Location/Area</label>
										<multiselect v-model="location.regions" deselect-label="Can't deselect" track-by="id" label="name" placeholder="Select Region" open-direction="bottom"
										:options="regions" 
										:searchable="true"
										:allow-empty="false"
										:custom-label="getRegion"
										:hide-selected="true"
										:multiple="true"
										@input="selectRegion">
										</multiselect>
									</p>
									<p>
										<label for="">Shipping Fee</label>
										<input type="text" class="form-control" v-model="location.shippingfee" >
									</p>
									<p>
										<label for="">Date Range</label>
										
									</p>
									
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary">Save changes</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script src="../../plugins/daterangepicker/daterangepicker.js"></script>

<script>

	import phil from 'phil-reg-prov-mun-brgy';

	import DateRangePicker from 'vue2-daterange-picker';

	import 'vue2-daterange-picker/dist/vue2-daterange-picker.css'

	export default {
		components: { DateRangePicker },
		data() {
			return {
				regions: [],
				provinces: [],
				cities: [],
				barangays: [],
				locations: [],
				location: new Form({
					cluster: null,
					shippingfee: null,
					firstdate: null,
					lastdate: null,
					regions: [],
				}),

			}
		},

		methods: {
			addLocation: function(location) {
				this.location.fill(location);
				this.location.regions = [];
				$("#addLocation").modal("show");
			},

			getRegion: function({id, name}) {
				return `${name}`;
			},

			selectRegion: function() {

			},

			loadRegions: function() {
				this.regions = phil.regions;
				console.log(this.regions);
			}
		},

		created() {
			
            // axios.get('/api/location').then(({ data }) => (this.locations = data));
            this.loadRegions();
   		}
	};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style scoped>
	.links {
		text-decoration: none;
		color: #ffffff;
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
	.location-links {
		text-decoration: none;
	}
</style>	
