<template>
	<div>
		<form @submit.prevent="create">
			<h1>Create a new {{$route.params.p}}</h1>
		  <div v-for="item in form" :key="item.name" class="form-group">
		    <label>{{item.label}}</label>
		    <input v-if="item.type == 'text'" v-model="item.value" type="text" class="form-control">
		    <textarea v-if="item.type == 'textarea'" v-model="item.value" class="form-control"></textarea>
		  </div>
		  <button type="submit" class="btn btn-primary">Create</button>
		</form>
	</div>
</template>

<script>
import axios from 'axios'
import Auth from '../../store/Auth'
export default {
	data() {
		return {
			form: [],
			auth: Auth.state
		}
	},
	mounted() {
		Auth.init()
		this.getForm()
	},
	watch: {
		'$route.params.p'() {
			this.getForm()
		}
	},
	methods: {
		getForm() {
			axios({
				method: 'GET',
				url: '/api/' + this.$route.params.p + '/create',
				headers: {
					'Authorization': 'Bearer ' + this.auth.api_token
				}
			})
			.then(response => {
				console.log(response.data)
				this.form = response.data.form
			})
		},
		create() {
			var payload = {}
			this.form.forEach(element => {
				payload[element.name] = element.value
			})
			console.log(payload)
			axios({
				method: 'POST',
				url: '/api/' + this.$route.params.p,
				data: payload,
				headers: {
					'Authorization': 'Bearer ' + this.auth.api_token
				}
			})
			.then(response => {
				console.log(response.data)
			})		
		}
	}
}
</script>