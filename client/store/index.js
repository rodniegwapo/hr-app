export const state = () => ({
  route: null,
  managers: null
})

export const mutations = {
  SET_ROUTE(state, route) {
    state.route = route;
  },
  setManagers(state, payload) {
    state.managers = payload
  }
}