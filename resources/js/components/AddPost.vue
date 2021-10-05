<template>
    <div>
    <p id="success"></p>
        <h3 class="text-center">Add Post</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addPost">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" v-model="post.title">
                    </div>
                    <div class="form-group">
                        <label>Description</label><br>
                       <textarea style="width:500px;" v-model="post.description" placeholder="введите несколько строчек"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Price</label><br>
                      <input type="text" class="form-control" v-model="post.price" >
                    </div>
                     <div class="form-group">
                        <label>Categories</label>
						<select class='form-control' v-model='post.category_id' @change='getStates()'>
                              <option value='0' >Select Categories</option>
                              <option v-for='data in categories' :value='data.id'>{{ data.name }}</option>
						</select>
					</div>
                    <button type="submit" class="btn btn-primary">Add Post</button>
                </form>
            </div>
            <div class="col-md-6">
					<FlashMessage/>
					  <div class="container">
							<div class="large-12 medium-12 small-12 cell">
							  <label>File
								<input type="file" id="file" ref="file" v-on:change="handleFileUpload()"/>
							  </label>
							  <br>
							  <progress max="300" :value.prop="uploadPercentage"></progress>
							  <br>
							  <button v-on:click="submitFile()" v-show="showSubmit">Submit</button>
							  <br>
							  <img style="width:100%;" v-bind:src="imagePreview" v-show="showPreview"/>
							  <br>
							  <img style="width:100%;" v-bind:src="imageThumbnails" v-show="showPreview"/>
							</div>
							
					  </div>
				
            </div>
        </div>
    </div>
</template>
<!--
 <template>
 <form action="http://localhost/laravel8/new3/api/savephoto" method="post" enctype="multipart/form-data">
 <div>
   <label for="file">Choose file to upload</label>
   <input type="file" id="file" name="file" multiple>
 </div>
 <div>
   <button>Submit</button>
 </div>
</form>
</template>
-->
<script>
    export default {
        data() {
            return {
				categories: '',
				file: '',
				uploadPercentage: 0,
				showPreview: false,
				showSubmit: false,
				imagePreview: '',
				imageThumbnails: '',
                post: {}
            }
        },
         http: {
            root: '/root',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('#token').getAttribute('value')
            }
        },
        created() {
			this.getCategories(),
            this.axios
                .get('http://localhost/laravel8/new3/api/add')
                .then(response => {
                    this.posts = response.data;
                    console.log(response.data);
                });
        },
        methods: {
            addPost() {
                this.axios
                    .post('http://localhost/laravel8/new3/api/add', this.post)
                    .then(response => {
                       // this.$router.push({name: 'create'})
                       // document.getElementById.innerHTML = response.data;
                         console.log(response.data);
                         this.$router.push({name: 'items'});
                    })
                    .catch(error => console.log(error))
                    .finally(() => this.loading = false)
            },
            getCategories(){
              this.axios.get('http://localhost/laravel8/new3/api/getCategories')
              .then(function (response) {
                 this.categories = response.data;
              }.bind(this));
            },
            handleFileUpload(){
				this.file = this.$refs.file.files[0];
				let reader  = new FileReader();
				reader.addEventListener("load", function () {
					  this.showPreview = true;
					  this.imagePreview = reader.result;
					  this.showSubmit = true;
				}.bind(this), false);
				
				if ( /\.(jpe?g|png|gif)$/i.test( this.file.name ) ) {
					/*
					  Fire the readAsDataURL method which will read the file in and
					  upon completion fire a 'load' event which we will listen to and
					  display the image in the preview.
					*/
					reader.readAsDataURL( this.file );
				}
			},
			submitFile(){
				  /*
					Initialize the form data
				  */
				  let formData = new FormData();
				  /*
					Add the form data we need to submit
				  */
				  formData.append('file', this.file);
				  /*
					Make the request to the POST /single-file URL
				  */
				  this.axios
					.post( 'http://localhost/laravel8/new3/api/savephoto',
					formData,
					{
					  headers: {
						  'Content-Type': 'multipart/form-data'
					  },
					  onUploadProgress: function( progressEvent ) {
							this.uploadPercentage = Math.round( (progressEvent.loaded * 300) / progressEvent.total );
					  }.bind(this)
					}
				  ).then(response =>{
					console.log('SUCCESS!!');
					console.log(response.data);
					imageThumbnails: true;
					////
					showPreview: false;
					this.imagePreview = '';
					uploadPercentage: 0;
					this.flashMessage.show({
						status: 'success',
						title: 'Message Title',
						message: 'Message Here'
					});
				  })
				  .catch(function(){
					console.log('FAILURE!!');
					this.flashMessage.show({
						status: 'error',
						title: 'Error Message Title',
						message: 'Oh, you broke my heart! Shame on you!'
					});
				  });
			},
        }
    }
</script>
<style scoped lang="scss">
.imagePreviewWrapper {
    width: 250px;
    height: 250px;
    display: block;
    cursor: pointer;
    margin: 0 auto 30px;
    background-size: cover;
    background-position: center center;
}
</style>
