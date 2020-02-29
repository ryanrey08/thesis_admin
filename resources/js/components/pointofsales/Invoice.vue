<template>
	<div class="container" id="invoice">
		<div class="container-fluid">
			<div class="invoice p-3 mb-3">

				<div class="row">
					<div class="col-12">
						<!-- <h4>
							<img :src="'/img/designs/logo/hanalogo.png'" width="24">HanaDulSetPH
							<small class="float-right">Date: 2/10/2014</small>
						</h4> -->
						<!-- <div class="media p-2 " style="height: 50px;">
							<img :src="'/img/designs/logo/hanalogo.png'" width="36">
							<div class="media-body h-100">
								<div class="d-flex flex-wrap align-content-center h-100">
									<h3>
										HanaDulSetPH
									</h3>
								</div>
							</div>
						</div> -->

						<h4>HanaDulSetPH</h4>
					</div>

				</div>

				<div class="row invoice-info">
					<div class="col-sm-4 invoice-col">
						From
						<address>
							<strong>Admin, Inc.</strong><br>
							795 Folsom Ave, Suite 600<br>
							San Francisco, CA 94107<br>
							Phone: (804) 123-5432<br>
							Email: info@almasaeedstudio.com
						</address>
					</div>

					<div class="col-sm-4 invoice-col">
						To
						<address>
							<strong>John Doe</strong><br>
							795 Folsom Ave, Suite 600<br>
							San Francisco, CA 94107<br>
							Phone: (555) 539-1037<br>
							Email: john.doe@example.com
						</address>
					</div>

					<div class="col-sm-4 invoice-col">
						<b>Invoice #007612</b><br>
						<br>
						<b>Order ID:</b> 4F3S8J<br>
						<b>Payment Due:</b> 2/22/2014<br>
						<b>Account:</b> 968-34567
					</div>

				</div>

				<div class="row">
					<div class="col-12 table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Qty</th>
									<th>Product</th>
									<th>Serial #</th>
									<th>Description</th>
									<th>Subtotal</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>1</td>
									<td>Call of Duty</td>
									<td>455-981-221</td>
									<td>El snort testosterone trophy driving gloves handsome</td>
									<td>$64.50</td>
								</tr>
								<tr>
									<td>1</td>
									<td>Need for Speed IV</td>
									<td>247-925-726</td>
									<td>Wes Anderson umami biodiesel</td>
									<td>$50.00</td>
								</tr>
								<tr>
									<td>1</td>
									<td>Monsters DVD</td>
									<td>735-845-642</td>
									<td>Terry Richardson helvetica tousled street art master</td>
									<td>$10.70</td>
								</tr>
								<tr>
									<td>1</td>
									<td>Grown Ups Blue Ray</td>
									<td>422-568-642</td>
									<td>Tousled lomo letterpress</td>
									<td>$25.99</td>
								</tr>
							</tbody>
						</table>
					</div>

				</div>


				<div class="row">

					<div class="col-6">
						<p class="lead">Payment Methods:</p>
						

						<p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
							Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
							plugg
							dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
						</p>
					</div>

					<div class="col-6">
						<p class="lead">Amount Due 2/22/2014</p>

						<div class="table-responsive">
							<table class="table">
								<tbody><tr>
									<th style="width:50%">Subtotal:</th>
									<td>$250.30</td>
								</tr>
								<tr>
									<th>Tax (9.3%)</th>
									<td>$10.34</td>
								</tr>
								<tr>
									<th>Shipping:</th>
									<td>$5.80</td>
								</tr>
								<tr>
									<th>Total:</th>
									<td>$265.24</td>
								</tr>
							</tbody></table>
						</div>
					</div>

				</div>



				<div class="col-12">
					<a href="/pos/invoice" target="_blank" @click="print()" class="btn btn-default"><i class="fas fa-print"></i>Print</a>
				</div>
			</div>
		</div>
	</div>
</template>



<script>
	
	import Vue from 'vue';
	import VueHtmlToPaper from 'vue-html-to-paper';

	Vue.use(VueHtmlToPaper);

	export default {
		methods: {

			print: function() {
				// window.print()
				window.print();
			}
		},

		mounted() {
			console.log('Component mounted.');
			
		}
	}
</script>