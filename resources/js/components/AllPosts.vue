<template>
    <div>
        <h3 class="text-center">All Posts</h3><br/>
	<FlashMessage :position="'left top'"></FlashMessage>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Catalog name</th>
                <th>Price</th>
                <!--<th>Created At</th>
                <th>Updated At</th>-->
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="post in posts.data" :key="post.id">
                <td>{{ post.id }}</td>
                <td>{{ post.name }}</td>
                <td>{{ post.category_name }}</td>
                <td>{{ post.price }}</td>
                  <!--<td>{{ post.content }}</td>
                  <td>{{ post.updated_at }}</td>-->
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'edit', params: { id: post.id }}" class="btn btn-primary">Edit
                        </router-link>
                        <button class="btn btn-danger" @click="deletePost(post.id)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <pagination :data="posts" @pagination-change-page="getResults"></pagination>
        <!--<pagination :data="posts">
			<span slot="prev-nav">&lt; Previous</span>
			<span slot="next-nav">Next &gt;</span>
		</pagination>-->
		<br>
    </div>
</template>
  
<script>
    export default {
        data() {
            return {
                posts: {},
                name: ''
            }
        },
        mounted() {
        // Fetch initial results
			this.getResults();
			if (localStorage.name) {
				let title = '';
				if(localStorage.name == "update"){
					title = 'Item has been updated';
				}else{
					title = 'Item has been created';
				}
				localStorage.name = '';
				this.flashMessage.show({
					status: 'success',
					title: title,
					message: 'Message Here'
				});
			}
		},
       /* created() {
            this.axios
                .get('http://localhost/laravel8/new3/api/items')
                .then(response => {
                    this.posts = response.data;
                    console.log('created');
                    console.log(response.data.data);
                });
        },*/
        methods: {
			getResults(page = 1) {
				axios.get('http://localhost/laravel8/new3/api/items?page=' + page)
					.then(response => {
						console.log('response.data');
						console.log(response.data.data);
						//this.posts = response.data.data.data;
						this.posts = response.data;
					})
                    .catch(response => {
                        this.errors = response.errors;
                        console.log('error');
                        console.log(response.data);
                    });
			},
            deletePost(id) {
                this.axios
                    .delete(`http://127.0.0.1:8000/api/post/delete/${id}`)
                    .then(response => {
                        let i = this.posts.map(item => item.id).indexOf(id); // find index of your object
                        this.posts.splice(i, 1)
                    });
            }
        }
    }
</script>
