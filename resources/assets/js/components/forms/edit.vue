<template>
	<div>
		<form @submit.prevent="create">
			<h1>Edit {{$route.params.p}}</h1>
		  <div v-for="item in form" :key="item.id" class="form-group">
		    <label>{{item.label}}</label>
		    <input v-if="item.type == 'text'" v-model="item.value" type="text" class="form-control">
			<vue-editor v-if="item.editor" v-model="item.value"></vue-editor>
		    <textarea v-else-if="item.type == 'textarea'" v-model="item.value" class="form-control"></textarea>
			<div v-if="item.type == 'select'" class="form-group">
				<select class="form-control" v-model="item.value">
					<option v-for="option in item.options" :key="option.id" :value="option.id">{{option.name}}</option>
				</select>
			</div>
		  </div>

		  <button type="submit" class="btn btn-primary">Edit</button>
		</form>
	</div>
</template>

<script>
import axios from 'axios'
import { VueEditor } from 'vue2-editor'

export default {
	components: {
      VueEditor
   },
	data() {
		return {
			form: [],
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