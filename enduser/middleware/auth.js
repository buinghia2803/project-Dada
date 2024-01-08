export default function (ctx) {
    const {store, route, $axios, redirect} = ctx
    if (!store.state.authenticated) {
        return redirect('/login')
    }
}
