<template>
    <div>
        <h3 class="text-center">Edit Item</h3>
        <div class="row">
			
			<div class="col-md-6">
				<div v-if="errors" class="bg-red-500 text-white py-2 px-4 pr-0 rounded font-bold mb-4 shadow-lg">
				  <div v-for="(v, k) in errors" :key="k">
					<p v-for="error in v" :key="error" class="text-sm">
					  {{ error }}
					</p>
				  </div>
				</div>
                <form @submit.prevent="updatePost">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" v-model="post.name"  @keydown="error_messages.name = null">
                        <span v-if="error_messages['name']">{{error_messages['name']}}</span>
                        
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
					<span v-if="error_messages['category_id']">{{error_messages['category_id']}}</span>
                    <button type="submit" class="btn btn-primary">Update Post</button>
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
						
							<img class="rounded img-thumbnail" src="https://picsum.photos/250/250/?image=54" alt="Image 1"></b-img>
						
            </div>
        </div>
       
    </div>
    
</template>

 

<script>
console.log('edit');
    export default {
        data() {
            return {
				error_messages: {
					name: '',
					category_id: ''
				},
				errors: null,
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
        created() {
			this.getCategories(),
            this.axios
                .get(`http://localhost/laravel8/new3/api/show/${this.$route.params.id}`)
                .then((response) => {
                    this.post = response.data;
                    console.log(response.data);
                });
        },
        methods: {
            updatePost() {
                this.axios
                    .post(`http://localhost/laravel8/new3/api/update/${this.$route.params.id}`, this.post)
                    .then((response) => {
						//this.axios.defaults.headers.common['X-CSRF-TOKEN'] = data;
						localStorage.name = "update";
						console.log('then!');
						//this.error_messages.name = '0000000';
						//this.$router.push({name: 'items'});
						//console.log(response.data)
                    })
					.catch((error) => {

						console.log(error)
						//vueObject.error_messages.name = 'ssssssss';
						if (error.response) {
						  
						  if(error.response.data.errors.name){
							//console.log(error.response.data.errors.name[0]);
							this.error_messages.name = error.response.data.errors.name[0];
						  }
						  if(error.response.data.errors.category_id){
							console.log(error.response.data.errors.category_id[0]);
							this.error_messages.category_id = error.response.data.errors.category_id[0];
						  }
						  
						  console.log(error.response.status);
						  console.log(error.response.headers);
						  ////////
						
						}
						//this.errors = error.response.data.errors;
						
					});
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
					this.errors = e.data.errors;
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
