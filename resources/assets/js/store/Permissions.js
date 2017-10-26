import axios from 'axios'
import Auth from './Auth'
export default {
	state: [],
	auth: Auth.state,
	init() {
		Auth.init()
		return axios({
			method: 'GET',
			url: '/api/user/permissions',
			headers: {
				'Authorization': `Bearer ${this.auth.api_token}`
			}
		})
	}
}