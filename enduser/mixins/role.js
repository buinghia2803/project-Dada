import {mapActions} from "vuex";

export default {
    data() {
        return {}
    },
    methods: {
        ...mapActions({
            actionUpdateType: "user/actionUpdateType",
        }),
        async switchAccount(type, options = {}) {
            this.changeAccount = !this.changeAccount;

            this.form = {
                id: this.$auth.user.id,
                type: type,
            };

            const result = await this.actionUpdateType(this.form);
            this.$auth.setUser(result.data);

            if (result) {
                if (Object.prototype.hasOwnProperty.call(options, 'action')) {
                    switch (options.action) {
                        case 'reload_page':
                            window.location.reload()
                            return
                        case 'update_page':
                            this.$forceUpdate()
                            return
                    }
                }
                await this.$router.push("/mypage");
                await this.$root.$emit('eventChangeRoleArtistOrDad', {options, typeAction: type, type: 'event_change_role'})
            }
        },
    }
}
