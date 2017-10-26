<template>
	<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div v-if="error !== null" class="alert alert-danger" role="alert">{{error}}</div>
                <form @submit.prevent="login">
                    <h1>Login</h1>
                <div class="form-group">
                    <label>Email Address</label>
                    <input v-model="form.email" type="email" class="form-control">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input v-model="form.password" type="password" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
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
                email: '',
                password: ''
            },
            auth: Auth.state,
            error: null
		}
	},
	created() {
		Auth.init()
	},
	methods: {
		login() {
			axios({
				method: 'POST',
				url: '/api/login',
				data: this.form,
			})
			.then(response => {
				if(response.data.authenticated) {
                    Auth.set(response.data.api_token, response.data.user_id)
                    this.$router.push('/dashboard')

                } else {
                    this.error = "Your email or password is wrong."
                }
			})
		}
	}
}
</script>