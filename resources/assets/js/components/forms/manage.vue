<template>
	<div v-if="!loading">
        <table class="table">
            <thead>
                <tr>
                    <th v-for="col in this.data.columns" :key="col">{{col[1]}}</th>
					<th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in this.data.items" :key="item.id">
                    <td v-for="k in item" :key="k">{{k}}</td>
					<td>
						<router-link class="btn btn-primary" :to="'/dashboard/'+ $route.params.p + '/' +item.id+'/update'">Edit</router-link>
						<button class="btn btn-danger" v-on:click="remove(item.id)">Delete</button>
					</td>
                </tr>
            </tbody>
        </table>
	</div>
</template>

<script>
import axios from 'axios'
export default {
	data() {
		return {
			data: [],
			loading: true
		}
	},
	mounted() {
		Permissions.init()
		this.getData()
	},
	watch: {
		'$route.params.p'() {
			this.getData()
		}
	},
	methods: {
		getData() {
			this.loading = true;
			axios({
				method: 'GET',
				url: '/api/' + this.$route.params.p,
				headers: {
					'Authorization': 'Bearer ' + this.$auth.getToken()
				}
			})
			.then(response => {
				this.data = response.data
				this.loading = false;
			})
		},
		remove(id) {
			axios({
				method: 'DELETE',
				url: '/api/' + this.$route.params.p + '/' + id,
				headers: {
					'Authorization': 'Bearer ' + this.$auth.getToken()
				}
			})
			.then(response => {
				if(response.data.success) {
					this.getData();
				}
			})
		}
    },
}
</script>

<style>
	button {
		cursor: pointer;
	}
</style>