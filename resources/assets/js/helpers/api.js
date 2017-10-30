import axios from 'axios'

export function get(url, vue) {
	return axios({
		method: 'GET',
		url: '/api/' + url,
		headers: {
			'Authorization': 'Bearer ' + vue.$auth.getToken()
		}
	})
}

export function post(url, data, vue) {
	return axios({
		method: 'POST',
		url: '/api/' + url,
		data: data,
		headers: {
			'Authorization': 'Bearer ' + vue.$auth.getToken()
		}
	})
}

export function del(url, vue) {
	return axios({
		method: 'DELETE',
		url: '/api/' + url,
		headers: {
			'Authorization': 'Bearer ' + vue.$auth.getToken()
		}
	})
}