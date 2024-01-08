import {mapActions} from "vuex";


export default {
    data() {
        return {}
    },
    methods: {
        ...mapActions({
            actionUpdateType: 'user/actionUpdateType'
        }),
        async logoutUser() {
            this.$store.commit('logout')
            this.form = {
                id: this.$auth.user.id,
                type: this.role_dad
            }
            await this.$auth.logout()
            const result = await this.actionUpdateType(this.form)
            if (result) {
                this.$auth.setUser(null)
                // /* await localStorage.clear();
                //  await this.$forceUpdate()*/
                await this.deleteAllCookies();

                this.$router.push('/')
            }
        },
        deleteAllCookies() {
            const cookies = document.cookie.split(";");

            for (let i = 0; i < cookies.length; i++) {
                const cookie = cookies[i];
                const eqPos = cookie.indexOf("=");
                const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
                document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
            }
        }
    }
}
