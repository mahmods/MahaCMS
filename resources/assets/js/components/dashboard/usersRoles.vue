<template>
	<div v-if="!loading">
        <form @submit.prevent="save">
            <h1>Roles</h1>
            <div v-for="role in data.roles" :key="role[0]" class="form-check">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox" :value="role[0]" v-model="selected">
                {{role[1]}}
            </label>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
	</div>
</template>

<script>
import axios from 'axios'
import Auth from '../../store/Auth'
export default {
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
				url: '/api/users/' + this.$route.params.id + '/roles',
				headers: {
					'Authorization': 'Bearer ' + this.auth.api_token
				}
			})
			.then(response => {
                this.data = response.data
                this.data.roles.forEach(role => {
                    if(role[2]) {
                        this.selected.push(role[0])
                    }
                })
				this.loading = false;
			})
        },
        save() {
            console.log(this.selected)
            axios({
				method: 'POST',
                url: '/api/users/' + this.$route.params.id + '/roles',
                data: this.selected,
				headers: {
					'Authorization': 'Bearer ' + this.auth.api_token
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