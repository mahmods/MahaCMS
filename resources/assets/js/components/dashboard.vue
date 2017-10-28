<template>
	<div class="dashboard">
		<div class="dashboard__sideBar">
			<img class="dashboard__sideBar--image" src="/img/logo2.png">
			<div class="dashboard__sideBar--list">
				<div v-for="m in menu" :key="m.name" class="dashboard__sideBar--list-item">
					<router-link v-if="menuHasSingleItem(m)" :to="'/dashboard'" class="dashboard__sideBar--list-item-title">{{m.items[0].text}}</router-link>


					<h1 v-if="!menuHasSingleItem(m)" class="dashboard__sideBar--list-item-title">{{m.name}}</h1>
					<router-link 
					v-if="!menuHasSingleItem(m)"
					v-for="item in m.items" 
					:key="item.name" 
					:to="'/dashboard'+item.url" 
					class="dashboard__sideBar--list-item-link" >{{item.text}}</router-link>
				</div>
			</div>			
		</div>
		<div class="dashboard__content">
			<div class="dashboard__content--header">
				<h1>Dashboard</h1>
				<div>
					<router-link to="/dashboard">Home</router-link><span v-if="$route.params.p">  /  </span>
					<router-link v-if="$route.params.p" :to="'/dashboard/'+$route.params.p">{{$route.params.p}}</router-link>
				</div>
			</div>
			<router-view class="dashboard__content--container"></router-view>
		</div>
	</div>
</template>

<script>
import axios from 'axios'
import Auth from '../store/Auth'
import Permissions from '../store/Permissions'
export default {
	data() {
		return {
			auth: Auth.state,
			permissions: Permissions.state,
			menu: []
		}
	},
	created() {
		Auth.init()
		axios({
			method: 'GET',
			url: '/api/menu',
			headers: {
				'Authorization': `Bearer ${this.auth.api_token}`
			}
		}).then(response => this.menu = response.data.menu)
	},
	methods: {
		menuHasSingleItem: (m) => {
			if(m.items.length == 1 )
			{
				return true;
			}
			return false;
		}
	}
}
</script>

<style>
body {
	background: #f4f7fa;
	}

	.dashboard__sideBar {
		position: fixed;
		width: 300px;
		overflow-y: scroll;
		top: 0;
		bottom: 0;
		background: #282c37;
		flex-basis: 300px;
		padding: 30px;
		display: flex;
		flex-direction: column;
		text-transform: capitalize;
	}

	.dashboard__sideBar--list {
		padding: 10px 10px;
	}

	.dashboard__sideBar--list-item {
		margin-bottom: 40px;
		display: flex;
		flex-direction: column;
	}

	.dashboard__sideBar--list-item-title {
		color: #fff;
		font-size: 1.5em;
	}

	.dashboard__sideBar--list-item-link {
		color: #6a7583;
		font-size: 1.2em;
		padding-left: 10px;
	}

	.dashboard__sideBar--image {
		margin-bottom: 40px;
		margin-top: 20px;
		width: 100%;
		height: auto;
		padding: 0 50px;
	}

	.dashboard__content {
		margin-left: 300px;
		display: flex;
		flex-direction: column;
	}

	.dashboard__content--header {
		background: #fff;
		padding: 50px;
	}

	.dashboard__content--container {
		padding: 50px;
	}
</style>