<template>
	
</template>
<script>
	export default{
		data(){
			return {
				//porderid: this.$route.params.porderid,
				selectedItems: this.$route.params.selectedItems,
				porder: {}

			}
		},
		mounted(){
			// this.loadPOItems();
			//  setTimeout(() => {
 		// 		 // this.$htmlToPaper('printMe');
 		// 		 this.loadPrint();
   //  		}, 2000);
			
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
			console.log(this.$route.params.selectedItems);
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