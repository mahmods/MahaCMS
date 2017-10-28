<template>
	<div v-if="!loading">
        <form @submit.prevent="save">
            <div class="form-group">
		    <label>Application Name</label>
		    <input v-model="settings[0].setting_value" type="text" class="form-control" >
		  </div>
		  <div class="form-group">
		    <label>Application Description</label>
		    <input v-model="settings[1].setting_value" type="text" class="form-control" >
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
			settings: [],
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
				url: '/api/settings',
				headers: {
					'Authorization': 'Bearer ' + this.auth.api_token
				}
			})
			.then(response => {
				this.settings = response.data.settings
				this.loading = false;
			})
		},
		save() {
			axios({
				method: 'POST',
				url: '/api/settings',
				headers: {
					'Authorization': 'Bearer ' + this.auth.api_token
				},
				data: this.settings
			})
			.then(response => {
				//this.settings = response.data.settings
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