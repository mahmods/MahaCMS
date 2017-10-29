<template>
	<div v-if="!loading">
        <form @submit.prevent="save">
            <h1>Permissions</h1>
            <div v-for="permission in data.permissions" :key="permission[0]" class="form-check">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox" :value="permission[0]" v-model="selected">
                {{permission[1]}}
            </label>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
	</div>
</template>

<script>
import axios from 'axios'
export default {
	data() {
		return {
			data: [],
            loading: true,
            selected: []
		}
	},
	mounted() {
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
				url: '/api/roles/' + this.$route.params.id + '/permissions',
				headers: {
					'Authorization': 'Bearer ' + this.$auth.api_token
				}
			})
			.then(response => {
                this.data = response.data
                this.data.permissions.forEach(permission => {
                    if(permission[2]) {
                        this.selected.push(permission[0])
                    }
                })
				this.loading = false;
			})
        },
        save() {
            axios({
				method: 'POST',
                url: '/api/roles/' + this.$route.params.id + '/permissions',
                data: this.selected,
				headers: {
					'Authorization': 'Bearer ' + this.$auth.getToken()
				}
			})
			.then(response => {
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