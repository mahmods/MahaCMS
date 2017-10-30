<template>
	<div v-if="!loading">
		<form @submit.prevent="create">
			<h1>Create a new {{$route.params.p}}</h1>
		  <div v-for="item in data.form" :key="item.name" class="form-group">
		    <label>{{item.label}}</label>
		    <!-- asdasd -->
		    <input v-if="item.type == 'text'" v-model="item.value" type="text" class="form-control" >
			<vue-editor v-if="item.editor" v-model="item.value"></vue-editor>
		    <textarea v-else-if="item.type == 'textarea'" v-model="item.value" class="form-control"></textarea>
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
import { get, post } from '../../helpers/api'
import { VueEditor } from 'vue2-editor'

export default {
	components: {
      VueEditor
   },
	data() {
		return {
			data: [],
			loading: true,
		}
	},
	created() {
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
			get(`${this.$route.params.p}/create`, this)
			.then(response => {
				this.data = response.data
				this.loading = false;
			})
		},
		onFileChange(item, e) {
			let files = e.target.files || e.dataTransfer.files;
			if (!files.length)
				return;
			item.value = files[0]
		},
		create() {
			var form = new FormData()
			this.data.form.forEach(input => {
				form.set(input.name, input.value)
			})
			post(this.$route.params.p, form, this)
			.then(response => {
				this.data.form.id = response.data.id
				if(response.data.success) {
					this.$router.push('/dashboard/' + this.$route.params.p)
					this.$toasted.show(this.$route.params.p + ' created successfully!', {type: 'success'})
				}
			})
		}
	}
}
</script>