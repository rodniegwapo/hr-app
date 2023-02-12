

export default function ({ store, redirect, route, next }) {

    if (store.state.auth.user.roles[0].name !== 'Admin') {
        return redirect('/dashboard')
    }
}