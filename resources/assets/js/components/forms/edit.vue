<template>
	<div>
		<form @submit.prevent="create">
			<h1>Edit {{$route.params.p}}</h1>
		  <div v-for="item in form" :key="item.name" class="form-group">
		    <label>{{item.label}}</label>
		    <input v-if="item.type == 'text'" v-model="item.value" type="text" class="form-control">
		    <textarea v-if="item.type == 'textarea'" v-model="item.value" class="form-control"></textarea>
		  </div>
		  <button type="submit" class="btn btn-primary">Edit</button>
		</form>
	</div>
</template>

<script>
import axios from 'axios'
export default {
	data() {
		return {
			form: [],
			auth: Auth.state
		}
	},
	mounted() {
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
				url: '/api/' + this.$route.params.p + '/' + this.$route.params.id + '/edit',
				headers: {
					'Authorization': 'Bearer ' + this.$auth.getToken()
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
				method: 'PUT',
				url: '/api/' + this.$route.params.p + '/' + this.$route.params.id,
				data: payload,
				headers: {
					'Authorization': 'Bearer ' + this.$auth.getToken()
				}
			})
			.then(response => {
				console.log(response.data)
			})		
		}
	}
}
</script>