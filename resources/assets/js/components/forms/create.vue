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
			<div v-else-if="item.type == 'select'" class="form-group">
				<select class="form-control" v-model="item.value">
					<option v-for="option in item.options" :key="option.id" :value="option.id">{{option.name}}</option>
				</select>
			</div>
			<div v-else-if="item.type == 'image'" class="form-group">
			<input @change="onImageChange(item, $event)" type="file" accept="images/*" class="form-control-file">
		</div>
		  </div>
		  <button type="submit" class="btn btn-primary">Create</button>
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
			data: [],
			loading: true,
			selected: []
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
			this.loading = true;
			axios({
				method: 'GET',
				url: '/api/' + this.$route.params.p + '/create',
				headers: {
					'Authorization': 'Bearer ' + this.$auth.getToken()
				}
			})
			.then(response => {
				this.data = response.data
				this.loading = false;
			})
		},
		onImageChange(item, e) {
			let files = e.target.files || e.dataTransfer.files;
			if (!files.length)
				return;
			this.createImage(files[0], item);
		},
		createImage(file, item) {
			let reader = new FileReader();
			reader.onload = (e) => {
				item.value = e.target.result;
			};
			reader.readAsDataURL(file);
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
					'Authorization': 'Bearer ' + this.$auth.getToken()
				}
			})
			.then(response => {
				this.data.form.id = response.data.id
				if(response.data.success) {
						this.$router.push('/dashboard/' + this.$route.params.p)
						this.$toasted.show(this.$route.params.p + ' created successfully!', {type: 'success'})
					}
			
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
						'Authorization': 'Bearer ' + this.$auth.getToken()
					}
				})
				.then(response => {
					
				})	
				}
			})	
			})
		}
	}
}
</script>