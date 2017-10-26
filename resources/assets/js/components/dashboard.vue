<template>
	<div class="dashboard">
		<div class="dashboard__sideBar">
			<div class="dashboard__sideBar--list">
				<div v-for="permission in permissions" :key="permission.name" class="dashboard__sideBar--list-item">
					<router-link class="dashboard__sideBar--list-item-title" :to="'/dashboard/' + permission.name">{{permission.name}}</router-link>
					<router-link 
					v-for="item in permission.items" 
					:key="item" 
					:to="'/dashboard/' + permission.name + '/' + item" 
					class="dashboard__sideBar--list-item-link" >{{item}}</router-link>
				</div>
			</div>			
		</div>
		<div class="container dashboard__content">
			<h1>Dashboard</h1>
			<router-view></router-view>
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
			permissions: Permissions.state
		}
	},
	created() {
		Permissions.init().then(response => {
			this.permissions = response.data.permissions
		})
	}
}
</script>

<style>
	.dashboard {
		display: flex;
		height: 100vh;
	}

	.dashboard__sideBar {
		background: #282C37;
		flex-basis: 200px;
		text-transform: capitalize;
		display: flex;
		flex-direction: column;
		padding: 60px 40px;
		}
	.dashboard__sideBar--list-item {
		display: flex;
		flex-direction: column;
	}
	.dashboard__sideBar--list-item-title {
		color: #fff;
		font-size: 1.5em;
	}

	.dashboard__sideBar--list-item-link {
		color: #6A7583;
		font-size: 1.3em;
	}
	.dashboard__content {
		flex: auto;
	}
</style>