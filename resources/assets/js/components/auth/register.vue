<template>
	<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div v-if="error !== null" class="alert alert-danger" role="alert">{{error}}</div>
                <form @submit.prevent="register">
                    <h1>Register</h1>
                    <div class="form-group">
                    <label>Name</label>
                    <input v-model="form.name" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input v-model="form.email" type="email" class="form-control">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input v-model="form.password" type="password" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
	</div>
</template>

<script>
import axios from 'axios'
import Auth from '../../store/Auth'
export default {
	data() {
		return {
			form: {
                name: '',
                email: '',
                password: ''
            },
            error: null
		}
	},
	methods: {
		register() {
			axios({
				method: 'POST',
				url: '/api/register',
				data: this.form,
			})
			.then(response => {
				if(response.data.registered) {
                    this.$router.push('/login')
                } else {
                    this.error = "Your email or password is wrong."
                }
			})
		}
	}
}
</script>