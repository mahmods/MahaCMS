<template>
	<div>
        <table class="table">
            <thead>
                <tr>
                    <th v-for="col in this.data.columns" :key="col">{{col[1]}}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in this.data.items" :key="item.id">
                    <td v-for="k in item" :key="k">{{k}}</td>
                </tr>
            </tbody>
        </table>
	</div>
</template>

<script>
import axios from 'axios'
import Auth from '../../store/Auth'
export default {
	data() {
		return {
			data: [],
			auth: Auth.state
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
			axios({
				method: 'GET',
				url: '/api/' + this.$route.params.p,
				headers: {
					'Authorization': 'Bearer ' + this.auth.api_token
				}
			})
			.then(response => {
				console.log(response.data)
				this.data = response.data
			})
		}
    },
}
</script>