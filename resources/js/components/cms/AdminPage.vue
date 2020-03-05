<template>	
	<div class="container pt-5">
        <div class="row">
            <div class="col-md-3 d-flex justify-content-center">   
                <img :src="pageContent.page_logo" class="img-thumbnail" style="width:50px; height: 50px;"/>
            </div>
            <div class="col-md-3">
                 <div class="form-group">
                    <label for="title">Store Logo</label>
                    <input type="file" accept="image/jpeg" class="form-control" @change=uploadImage>
                </div>
            </div>
             <div class="col-md-3">
                <div class="form-group">
                    <label for="title">Store Title</label>
                    <input type="text" class="form-control" v-model="pageContent.title" @keyup="changeTitle">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="title">Text Color</label>
                    <input type="color"  value="#ff0000" class="form-control" v-model="pageContent.title_color" @change="changeTitleColor">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"> 
                <div class="form-group">
                    <label for="exampleInputEmail1">Background Color</label>
                    <input type="color" class="form-control" value="#ff0000" v-model="pageContent.page_color" @change="changeBackgroundPage">
                </div>
            </div>
            <div class="col-md-3"> 
                <div class="form-group">
                    <label for="exampleInputEmail1">Background Color Menu</label>
                    <input type="color" class="form-control" value="#ff0000" v-model="pageContent.menu_color" @change="changeBackgroundMenu">
                </div>
            </div>
            <div class="col-md-3"> 
                <div class="form-group">
                    <label for="exampleInputEmail1">Text Color Menu</label>
                    <input type="color" class="form-control" value="#ff0000" v-model="pageContent.text_menu" @change="changeTextColorMenu">
                </div>
            </div>
            <div class="col-md-3"> 
                <div class="form-group">
                    <label for="exampleInputEmail1">Background Color Header</label>
                    <input type="color" class="form-control" value="#ff0000" v-model="pageContent.header_color" @change="changeBackgroundHeader">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                 <div class="form-group">
                    <label for="exampleInputEmail1">Table Color</label>
                    <input type="color" class="form-control" value="#ff0000"v-model="pageContent.table_color" @change="changeTableColor">
                </div>
                <button @click="updateContent">Update</button>
            </div>
             <div class="col-md-3"> 
                <div class="form-group">
                    <label for="exampleInputEmail1">Background Footer</label>
                    <input type="color" class="form-control" value="#ff0000" v-model="pageContent.footer_color" @change="changeBackgroundFooter">
                </div>
            </div>
             <div class="col-md-3"> 
                <div class="form-group">
                    <label for="exampleInputEmail1">Footer Content</label>
                    <input type="color" class="form-control" value="#ff0000" v-model="pageContent.footer_content" @change="changeFooterContent">
                </div>
            </div>
             <div class="col-md-3"> 
                <div class="form-group">
                    <label for="exampleInputEmail1">Footer Text Color</label>
                    <input type="color" class="form-control" value="#ff0000" v-model="pageContent.footer_text" @change="changeFooterText">
                </div>
            </div>
        </div>
	</div>

</template>

<script>
	export default {
        name:'imageUpload',
        data(){
            return{

            	pageContent: new Form({
                    id: null,
                    theme_name: "",
            		page_logo: "",
                    title: "",
                    title_color: "",
	               page_color: "",
	               menu_color: "",
                   text_menu: "",
	               header_color: "",
	               footer_color: "",
                   footer_content: "",
                   footer_text: "",
	               table_color: "",
                   is_active: null
            	}),

                contents: []

               // previewImage:null,
               // pageColor: "#0000",
               // menuColor: "#0000",
               // headerColor: "#0000",
               // footerColor: "#0000",
               // tableColor: "#0000"
            }
        },
        methods:{
            uploadImage(e){
                const image = e.target.files[0];
                const reader = new FileReader();
                reader.readAsDataURL(image);
                reader.onload = e =>{
                    this.pageContent.page_logo = e.target.result;
                    console.log(this.pageContent.page_logo);
                    $('.brand-image').attr('src', this.pageContent.page_logo);
                };
            },

            changeTitle(){
                    $('#title').html(this.pageContent.title);
            },

            changeTitleColor(){
                    $('span').removeClass('text-light'); 
                   $('#title').css('color', this.pageContent.title_color); 
            },

            updateContent(){
                this.pageContent.page_logo = this.pageContent.page_logo;
            	this.pageContent.put('/api/cms/'+1)
                    .then(() => {
                        this.$Progress.finish();
                        $('#addStaff').modal('hide');
                        Toast.fire({
                            type: 'success',
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
            },

            changeBackgroundPage() {
            		// this.pageColor = this.pageColor.substring(4, 4)
            	 $('.content-wrapper').removeAttr('background-color');
            	$('.content-wrapper').css('background-color', this.pageContent.page_color);
            },

            changeBackgroundMenu() {
            	 $('.main-sidebar').removeAttr('background-color');
            	$('.main-sidebar').css('background-color', this.pageContent.menu_color);
            },

            changeTextColorMenu() {
                $('.nav-item p').css('color',  this.pageContent.text_menu);
            },

            changeBackgroundHeader() {
            	 $('.main-header').removeAttr('background-color');
            	$('.main-header').css('background-color', this.pageContent.header_color);

            	$('.brand-link').removeAttr('background-color');
            	$('.brand-link').css('background-color', this.pageContent.header_color);
            },

            changeBackgroundFooter() {
            	$('.main-footer').removeAttr('background-color');
            	$('.main-footer').css('background-color', this.pageContent.footer_color);
            },

            changeFooterContent() {
                    $('.main-footer').html(this.pageContent.footer_content);
            },

            changeFooterText() {
                    $('.main-footer').css('color',this.pageContent.footer_text);
            },

            changeTableColor() {
            	  $('.table .thead-dark th').css('background-color', this.pageContent.table_color);
                  window.localStorage.setItem('contents', JSON.stringify(this.pageContent));
            }
        },

        created(){
            this.contents = JSON.parse(window.localStorage.getItem('contents'));
            this.pageContent.fill(this.contents);
        }
     };
</script>

<style>
/*.table .thead-dark th{
    color: #ffffff;
    background-color: #343a40;
    border-color: #454d55;
}*/

</style>