<template>
    <div>
        <ValidationObserver ref="observer">
            <a-form
                id="formLogin"
                ref="form"
                :label-col="{ md: 10 }"
                :wrapper-col="{ md: 10 }"
                slot-scope="{ handleSubmit }"
                @submit.prevent="handleSubmit(submit)"
            >
                <a-spin :spinning="loading">
                    <div class="py-3">
                        <a-row type="flex" :gutter="20">
                            <a-col :span="24" :xl="12">
                                <ValidationProvider name="old_password" rules="required">
                                    <a-form-item
                                        label="現在のパスワード*："
                                        slot-scope="{ errors }"
                                        :validateStatus="errors[0] ? 'error' : 'success'"
                                        :help="errors[0]"
                                    >
                                        <a-input-password
                                            size="large"
                                            v-model="form.old_password"
                                        >
                                        </a-input-password>
                                    </a-form-item>
                                </ValidationProvider>

                            </a-col>
                        </a-row>
                        <a-row type="flex" :gutter="20"
                        >
                            <a-col :span="24" :xl="12"
                            >
                                <ValidationProvider name="password" rules="required|validatePassword">
                                    <a-form-item
                                        label="新しいパスワード*："
                                        slot-scope="{ errors }"
                                        :validateStatus="errors[0] ? 'error' : 'success'"
                                        :help="errors[0]"
                                    >
                                        <a-input-password
                                            size="large"
                                            v-model="form.password"
                                        >
                                        </a-input-password>
                                    </a-form-item>
                                </ValidationProvider>

                            </a-col>
                        </a-row>
                        <a-row type="flex" :gutter="20"
                        >
                            <a-col :span="24" :xl="12"
                            >
                                <ValidationProvider name="password_confirmation" rules="required|password:@password">
                                    <a-form-item
                                        label="新しいパスワード（確認）*："
                                        slot-scope="{ errors }"
                                        :validateStatus="errors[0] ? 'error' : 'success'"
                                        :help="errors[0]"
                                    >
                                        <a-input-password
                                            size="large"
                                            v-model="form.password_confirmation"
                                        >
                                        </a-input-password>
                                    </a-form-item>
                                </ValidationProvider>

                            </a-col>
                        </a-row>
                    </div>

                    <div class="pb-3">
                        <a-row type="flex" :gutter="20">
                            <a-col :span="24" :xl="12">
                                <a-row :gutter="0">
                                    <a-col :span="24" :md="10">
                                    </a-col>
                                    <a-col :span="24" :md="14">
                                        <a-form-item style="margin-top: 24px">
                                            <a-config-provider :autoInsertSpaceInButton="false">
                                                <a-button
                                                    size="large"
                                                    html-type="submit"
                                                    class="btn-submit-lg btn-action">
                                                    {{ $t('common.change') }}
                                                </a-button>
                                            </a-config-provider>
                                        </a-form-item>
                                    </a-col>
                                </a-row>
                            </a-col>
                        </a-row>
                    </div>
                </a-spin>
            </a-form>
        </ValidationObserver>
    </div>
</template>
<script>
import {mapActions} from "vuex";

export default {
    props: {
        create: {
            type: Boolean
        }
    },
    components: {
    },
    data () {
        return {
            form: {
                old_password: '',
                password: '',
                password_confirmation: ''
            },
            listOrganization: [],
            defaultOption: {
                label: this.$t('common.default_option'),
                value: 0
            },
            loading: false,
            listRoles: []
        }
    },

    computed: {
    },

    mounted () {},

    methods: {
    ...mapActions('admin-change-password', ['changePassword']),

        /**
         * change password
         *
         * @param {string} old_password - old password
         * @param {string} password - password change
         * @param {string} password_confirmation - password change confirm
         */
        async submit () {
            this.loading = true
            this.changePassword(this.form)
            this.$store.commit('logout')
            await this.$auth.logout();
            await localStorage.clear();
            await this.$forceUpdate()
            this.$router.push('/login')
            this.loading = false
        },
    }
}
</script>
<style scoped>
/*.percent:after {*/
/*    content: '%';*/
/*    position: absolute;*/
/*    top: 10px;*/
/*    right: 350px;*/
/*    width: 23px;*/
/*    height: calc(100% - 20px);*/
/*    font-size: 15px*/
/*}*/
</style>
