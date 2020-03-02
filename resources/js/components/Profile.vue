<template>
	<div class="w-100">
		<div class="content">
			<div class="container-fluid" v-if="staff != {}">
				<div class="row mb-2 p-2 rounded-lg">
					<div class="col-md-12">
						<div class="card card-primary card-outline">
							<div class="card-body box-profile">
								<div class="text-center image-container">
									<img class="profile-user-img img-fluid img-circle" :src="staff.photo" alt="User profile picture">
								</div>

								<h3 class="profile-username text-center">{{ staff.name }}</h3>
								<p class="text-muted text-center">{{ staff.type == 1 ? 'Administrator' : 'Staff' }}</p>
							</div>
							<div class="card-footer bg-light">
								<ul class="nav nav-pills">
									
									<li class="nav-item"><a class="nav-link active" href="#timeline" data-toggle="tab">Timeline</a></li>
									<li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
								</ul>
								<div class="tab-content p-3">
									
									<div class="tab-pane active" id="timeline">

										<ul class="timeline timeline-inverse">

											<li class="time-label">
												<span class="bg-danger">10 Feb. 2014</span>
											</li>

											<li>
												<i class="fas fa-envelope bg-primary"></i>

												<div class="timeline-item">
													<span class="time"><i class="far fa-clock"></i> 12:05</span>

													<h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

													<div class="timeline-body">
														Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
														weebly ning heekya handango imeem plugg dopplr jibjab, movity
														jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
														quora plaxo ideeli hulu weebly balihoo...
													</div>
													<div class="timeline-footer">
														<a href="#" class="btn btn-primary btn-sm">Read more</a>
														<a href="#" class="btn btn-danger btn-sm">Delete</a>
													</div>
												</div>
											</li>

											<li>
												<i class="fas fa-user bg-info"></i>

												<div class="timeline-item">
													<span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

													<h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
													</h3>
												</div>
											</li>

											<li>
												<i class="fas fa-comments bg-warning"></i>

												<div class="timeline-item">
													<span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

													<h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

													<div class="timeline-body">
														Take me to your leader!
														Switzerland is small and neutral!
														We are more like Germany, ambitious and misunderstood!
													</div>
													<div class="timeline-footer">
														<a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
													</div>
												</div>
											</li>

											<li class="time-label">
												<span class="bg-success">3 Jan. 2014</span>
											</li>

											<li>
												<i class="fas fa-camera bg-purple"></i>

												<div class="timeline-item">
													<span class="time"><i class="far fa-clock"></i> 2 days ago</span>

													<h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

													<div class="timeline-body">
														<img src="http://placehold.it/150x100" alt="..." class="margin">
														<img src="http://placehold.it/150x100" alt="..." class="margin">
														<img src="http://placehold.it/150x100" alt="..." class="margin">
														<img src="http://placehold.it/150x100" alt="..." class="margin">
													</div>
												</div>
											</li>

											<li>
												<i class="far fa-clock bg-gray"></i>
											</li>
										</ul>
									</div>
									<div class="tab-pane" id="settings">
										<div class="row">

											<div class="col">

												<h4 class="display-6">Account Settings</h4>

												<div class="form-group" v-if="staff.type == 1">
													<label for="">Name</label>
													<div class="input-group mb-3" >

														<div class="input-group-prepend">
															<span class="input-group-text"><i class="fas fa-user-tag fa-fw"></i></span>
														</div>

														<input v-model="staff.name" class="form-control" :class="{ 'is-invalid' : staff.errors.has('name') }" type="text" name="name" placeholder="Full Name">

														<has-error :form="staff" field="name"></has-error>

													</div>
												</div>

												<div class="form-group">
													<label for="">Email Address</label>
													<div class="input-group mb-3">

														<div class="input-group-prepend">
															<span class="input-group-text"><i class="fa fa-user-lock fa-fw"></i></span>
														</div>

														<input v-model="staff.email" class="form-control" :class="{ 'is-invalid' : staff.errors.has('email') }" type="email" name="email" placeholder="Email Address">

														<has-error :form="staff" field="email"></has-error>

													</div>
												</div>
												

												<div class="form-group" v-if="changePassword == true">
													<label for="">New Password</label>
													<div class="input-group mb-3">

														<div class="input-group-prepend">
															<span class="input-group-text"><i class="fa fa-user-lock fa-fw"></i></span>
														</div>

														<input v-model="newPassword" class="form-control" :class="{ 'is-invalid' : staff.errors.has('password') }" type="password" name="password" placeholder="New Password">

														<has-error :form="staff" field="password"></has-error>

													</div>
												</div>

												<div class="form-group" v-if="changePassword == true">
													<label for="">Confirm Password</label>
													<div class="input-group mb-3">

														<div class="input-group-prepend">
															<span class="input-group-text"><i class="fa fa-user-lock fa-fw"></i></span>
														</div>

														<input v-model="staff.confirm" class="form-control" :class="{ 'is-invalid' : staff.errors.has('confirm') }" type="password" name="confirm" placeholder="Confirm Password">

														<has-error :form="staff" field="confirm"></has-error>

													</div>
												</div>

												<div class="form-group" v-if="changePassword == true">
													<label for="">Re-type Old Password</label>
													<div class="input-group mb-3">

														<div class="input-group-prepend">
															<span class="input-group-text"><i class="fa fa-user-lock fa-fw"></i></span>
														</div>

														<input class="form-control" placeholder="Re-type Old Password">

													</div>
												</div>


												<div class="d-flex">
													<a href="" v-if="changePassword == false" @click.prevent="changePassword = true">Change Password</a>
													<a href="" v-if="changePassword == true" @click.prevent="changePassword = false">Cancel Change of Password</a>
													<button class="btn btn-primary ml-auto" @click="saveChanges">Save Changes</button>
												</div>
											</div>

										</div>
									</div>
								</div>
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
			staff: new Form({
				id: null,
				name: null,
				type: null,
				email: null,
				photo: null,
			}),
			newPassword: null,
			changePassword: false,
		}
	},

	methods: {
		getStaff: function() {
			axios.get("/api/profile").then(({data}) => this.staff.fill(data));
		},

		saveChanges: function() {
			this.$Progress.start();
				this.staff.put('/api/staff/'+this.staff.id)
					.then(() => {
						this.$Progress.finish();
						$('#addStaff').modal('hide');
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
		this.getStaff();
	}
}
</script>
