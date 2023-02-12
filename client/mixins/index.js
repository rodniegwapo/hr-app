import Vue from 'vue'

const mixin = {
	methods: {
		async addUser(data) {
			return await this.$axios.$post('/api/users', data)
		},
		async getUsers(page) {
			return await this.$axios.$get(`/api/get_users?page=${page ? page : 0}`)
		},
		async deleteUser(data) {
			return await this.$axios.delete(`/api/users/${data.id}`, data)
		},
		async updateUser(data) {
			return await this.$axios.$patch(`/api/users/${data.id}`, data)
		},
		async updateAccountInfo(data) {
			return await this.$axios.$post('/api/update_account', data)
		},
		async changePassword(data) {
			return await this.$axios.$post('/api/change_password', data)
		},
		getImageUser() {
			return this.$axios.$get('/api/get_image_user')
		},
		getRoles() {
			return this.$axios.$get('api/roles')
		},
		getManagers() {
			return this.$axios.$get('api/managers')
		},
		getUserDetails(data) {
			return this.$axios.$post('api/user_details', data)
		},

		addTimeOff(data) {
			return this.$axios.$post('api/time_ofss', data)
		},

		getTypes() {
			return this.$axios.get('api/types')
		},
		saveTimeOff(data) {
			return this.$axios.post('api/time_offs', data)
		},
		getTimeOffs(page) {
			return this.$axios.get(`api/time_offs?page=${page ? page : 1}`)
		},
		updateTimeOffs(data) {
			return this.$axios.patch(`api/time_offs/${data.id}`, data)
		},
		deleteTimeOffs(data) {
			return this.$axios.delete(`/api/time_offs/${data.id}`, data)
		},
		getTimeOffRequest(data) {
			return this.$axios.post(`/api/request_time_off/${data}`)
		},
		declineOrApprove(data) {
			return this.$axios.post(`/api/decline_or_approve`, data)
		},
		getApprovedTimeOffs() {
			return this.$axios.get('api/approved_time_offs')
		},
		getManagerTimeOffFromStaff() {
			return this.$axios.get('/api/manager_time_off_from_staff')
		},
		// searchByName(data) {
		// 	return this.$axios.get('/api/searchByName', data)
		// },
		// end of resource 
		to(data) {
			this.$router.push('/' + data)
		},
		capitalize(data) {
			return data
				.toLowerCase()
				.split(" ")
				.map((s) => s.charAt(0).toUpperCase() + s.substring(1))
				.join(" ");
		},
		firstLetter(data) {
			let item = data
				.toLowerCase()
				.split(" ")
				.map((s) => s.charAt(0).toUpperCase());
			return item[0];
		},
	}
}

Vue.mixin(mixin)