<template>
	<div v-if="!loading">
		<form @submit.prevent="create">
			<h1>Create a new {{$route.params.p}}</h1>
		  <div v-for="item in data.form" :key="item.name" class="form-group">
		    <label>{{item.label}}</label>
		    <input v-if="item.type == 'text'" v-model="item.value" type="text" class="form-control" >
			<vue-editor v-if="item.editor" v-model="item.value"></vue-editor>
		    <textarea v-else-if="item.type == 'textarea'" v-model="item.value" class="form-control"></textarea>
			<div v-else-if="item.type == 'selectCheckBox'">
				<div v-for="key in data[item.name]" :key="key.id" class="form-check">
				<label class="form-check-label">
					<input class="form-check-input" type="checkbox" :value="key.id" v-model="selected">
					{{key.name}}
				</label>
				</div>
			</div>
		  </div>
		  <button type="submit" class="btn btn-primary">Create</button>
		</form>
	</div>
</template>

<script>
import axios from 'axios'
import Auth from '../../store/Auth'
import { VueEditor } from 'vue2-editor'

export default {
	components: {
      VueEditor
   },
	data() {
		return {
			data: [],
			auth: Auth.state,
			loading: true,
			selected: []
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
			this.loading = true;
			axios({
				method: 'GET',
				url: '/api/' + this.$route.params.p + '/create',
				headers: {
					'Authorization': 'Bearer ' + this.auth.api_token
				}
			})
			.then(response => {
				this.data = response.data
				this.loading = false;
			})
		},
		create() {
			var payload = {}
			this.data.form.forEach(element => {
				if(element.type !== "selectCheckBox") {
					payload[element.name] = element.value
				}
			})
			axios({
				method: 'POST',
				url: '/api/' + this.$route.params.p,
				data: payload,
				headers: {
					'Authorization': 'Bearer ' + this.auth.api_token
				}
			})
			.then(response => {
				this.data.form.id = response.data.id
			
			this.data.form.forEach(element => {
				if(element.type == "selectCheckBox") {
					var payload2 = {};
					Object.keys(this.data.form[this.data.form.indexOf(element)].value).forEach(e => {
						if(e) {
							payload2[e] = ''
						}
					})
					axios({
						method: 'POST',
					url: '/api/' + this.$route.params.p + '/' + this.data.form.id + '/' + element.name,
					data: this.selected,
					headers: {
						'Authorization': 'Bearer ' + this.auth.api_token
					}
				})
				.then(response => {
					//console.log(response.data)
				})	
				}
			})	
			})
		}
	}
}
</script>