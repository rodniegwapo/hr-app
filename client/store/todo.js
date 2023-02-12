export const state = () => ({
    managers: null,
    userDetails: null,
    events: null
})

export const mutations = {

    setManagers(state, payload) {
        state.managers = payload
    },
    setUserDetails(state, payload) {
        state.userDetails = payload
    },
    setEvents(state, payload) {
        state.events = payload
    }
}