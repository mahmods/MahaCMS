import axios from 'axios'
import { api_token } from './Auth'
export default {
	state: [],
	init() {
		return axios({
			method: 'GET',
			url: '/api/user/permissions',
			headers: {
				'Authorization': `Bearer ${api_token}`
			}
		})
	}
}