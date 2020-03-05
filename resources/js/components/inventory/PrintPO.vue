<template>
	<div class="container-sm my-5" id="printMe">
		<div class="row">
			<div class="col-md-8 offset-md-2" style="border: 1px solid black">
				<div class="row px-5">
					<div class="col-md-6 pt-5">
						<div>
							<h4>[Company Name]</h4>
							<p>[Street Address]</p>
							<p>[City. ST ZIP]</p>
							<p>Phone: (000) 000-000</p>
							<p>Fax: (000) 000-000</p>
							<p>Website</p>
						</div>
					</div>
					<div class="col-md-6 pt-5">
						<h2>Purchase Order</h2>
						<div class="row">
							<div class="col-md-6">
								<p>Date</p>
								<p>PO#</p>
							</div>
							<div class="col-md-6">
								<p>{{ porder.expected_arrival }}</p>
								<p>{{ porder.id }}</p>
							</div>
						</div>
					</div>
				</div>
				<div class="row pt-4 px-5">
					<div class="col-md-6">
						<select id="">
							 <option value="" disabled selected>VENDOR</option>
						</select>
						<p>{{ porder.sourcename }}</p>
						<p>Address: {{ porder.address }}</p>
						<p>Phone: {{ porder.phone }}</p>
					</div>
					<!-- <div class="col-md-6">
						<select id="">
							<option value="" disabled selected>SHIP TO</option>
						</select>
						<p>[Name]</p>
						<p>[Company Name]</p>
						<p>[Street Address]</p>
						<p>[City, ST ZIP]</p>
						<p>[Phone]</p>
					</div> -->
				</div>
				<!-- <div class="row px-5">
					<div class="col-md-12">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th scope="col">REQUISTIONER</th>
									<th scope="col">SHIP VIA</th>
									<th scope="col">F.O.B</th>
									<th scope="col">SHIPPIN TERMS</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>dfsdg</td>
									<td>gfdg</td>
									<td>gfg</td>
									<td>gfgf</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div> -->
				<div class="row px-5">
					<div class="col-md-12">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th scope="col">ITEM #</th>
									<th scope="col">QTY</th>
									<th scope="col">UNIT PRICE</th>
									<th scope="col">TOTAL</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="porder in porders">
									<td>{{ porder.item_id }}</td>
									<td>{{ porder.quantity }}</td>
									<td>{{ porder.price }}</td>
									<td>{{ porder.quantity * porder.price }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row px-5">
					<div class="col-md-8 com">
						<!-- <p class="comment"><span style="margin-top: 10px;">Comments or Special Instructions</span></p>
						<textarea name="" id="" cols="50" rows="10"></textarea> -->
					</div>
					<div class="col-md-4">
						<div class="row">
							<div class="col-md-6">
								<p>SUB TOTAL</p>
							</div>
							<div class="col-md-6">
								<p>{{ getTotal() }}</p>
							</div>
						</div>
						<hr>
						<hr>
						<div class="row">
							<div class="col-md-6">
								<p>TOTAL</p>
							</div>
							<div class="col-md-6">
								<p class="total">{{ getTotal() }}</p>
							</div>
						</div>
					</div>
				</div>
				<!-- <div class="row my-5">
					<div class="col-md-12 px-5">
						<p style="text-align: center; line-height: 18px; margin: 0px 90px;">If you have any questions about this purchase order, please contact [Name, Phone #, E-mail]</p>
					</div>
				</div> -->
			</div>
		</div>
	</div>
</template>
<script>
	export default{
		data(){
			return {
				porderid: this.$route.params.porderid,
				porders: [],
				porder: {}

			}
		},
		mounted(){
			this.loadPOItems();
			 setTimeout(() => {
 				 // this.$htmlToPaper('printMe');
 				 this.loadPrint();
    		}, 2000);
			
		},
		methods: {
			loadPOItems: function() {
				axios.get('/api/porder/getPo/' + this.porderid ).then(( data ) => { 
					this.porders = data.data;
					this.porder = data.data[0];
				});
			},

			getTotal:function() {
				let total = 0;
				for(let x = 0; x < this.porders.length;x++){
					total += (this.porders[x].quantity * this.porders[x].price);
				}

				return total;
			},

			loadPrint: function() {
				  this.$htmlToPaper('printMe');
				   setTimeout(function () { 
				   	window.location.href = '/porder';
				   }, 2000);
			}
		},

		created(){
			// this.loadPOItems();
		}
	};
</script>

<style scoped>

@media print {
  h4 {
	color: #3d9970;
}

h2 {
	color: #3d9970;
}

p {
	line-height: 8px;
}

.spval {
	margin-left: 15px;
}

.col-md-12 {
	margin-top: 30px;
}

select{
	width: 150px;
	margin-bottom: 20px;
	background-color: #3d9970;
	color: #ffff;
}

.comment{
	background-color: #3d9970; 
	border: 1px solid black; 
	height: 30px; 
	width: 375px;
	padding-top: 8px;
}

textarea{
	margin-top: -15px;
}

table{
	border: 1px solid #3d9970;
}


th {

	background-color: #3d9970;
	color: #ffff;
}

hr{
	background-color: #3d9970;
	height: 1px;
}

.long{
	width: 110px;
}

.com{
	margin-top: 20px;
}

.total {
	border: 1px solid #ffffff;
	height: 20px;
	background-color: #3d9970;
	padding: 3px;
}
}

h4 {
	color: #3d9970;
}

h2 {
	color: #3d9970;
}

p {
	line-height: 8px;
}

.spval {
	margin-left: 15px;
}

.col-md-12 {
	margin-top: 30px;
}

select{
	width: 150px;
	margin-bottom: 20px;
	background-color: #3d9970;
	color: #ffff;
}

.comment{
	background-color: #3d9970; 
	border: 1px solid black; 
	height: 30px; 
	width: 375px;
	padding-top: 8px;
}

textarea{
	margin-top: -15px;
}

table{
	border: 1px solid #3d9970;
}


th {

	background-color: #3d9970;
	color: #ffff;
}

hr{
	background-color: #3d9970;
	height: 1px;
}

.long{
	width: 110px;
}

.com{
	margin-top: 20px;
}

.total {
	border: 1px solid #ffffff;
	height: 20px;
	background-color: #3d9970;
	padding: 3px;
}

</style>