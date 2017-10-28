<template>
	<div v-if="!loading">
        <form @submit.prevent="save">
            <div class="form-group">
		    <label>Nickname</label>
		    <input v-model="profile.nickname" type="text" class="form-control" >
		  </div>
		  <div class="form-group">
		    <label>First Name</label>
		    <input v-model="profile.first_name" type="text" class="form-control" >
		  </div>
		  <div class="form-group">
		    <label>Last Name</label>
		    <input v-model="profile.last_name" type="text" class="form-control" >
		  </div>
		  <div class="form-group">
		    <label>Description</label>
		    <textarea v-model="profile.description" type="text" class="form-control" ></textarea>
		  </div>
		  <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
	</div>
</template>

<script>
import axios from 'axios'
import Auth from '../../store/Auth'
export default {
	data() {
		return {
			profile: [],
			auth: Auth.state,
			loading: true
		}
	},
	mounted() {
		Auth.init()
		this.getData()
	},
	methods: {
		getData() {
			this.loading = true;
			axios({
				method: 'GET',
				url: '/api/profile',
				headers: {
					'Authorization': 'Bearer ' + this.auth.api_token
				}
			})
			.then(response => {
				this.profile = response.data.profile
				this.loading = false;
			})
		},
		save() {
			axios({
				method: 'POST',
				url: '/api/profile',
				headers: {
					'Authorization': 'Bearer ' + this.auth.api_token
				},
				data: this.profile
			})
			.then(response => {
				console.log(response.data)
			})
		}
    }
}
</script>

<style>
	button {
		cursor: pointer;
	}
</style>