<template>
    <div class="main login-container">
        <a-card title="DadA" :bordered="false" class="ant-card-auth" :headStyle="headStyle">
            <div class="title_login">パスワード変更</div>
            <ValidationObserver ref="observer">
                <a-form
                    id="formLogin"
                    class="user-layout-login"
                    ref="formLogin"
                    slot-scope="{ handleSubmit }"
                    @submit.prevent="handleSubmit(resetPassword)"
                >
                    <a-alert
                        v-if="loginError"
                        type="error"
                        show-icon
                        style="margin-bottom: 24px"
                        :message="loginError"
                    />
                    <ValidationProvider name="password" rules="required|validatePassword">
                        <a-form-item
                            :label="$t('pages.login.password')"
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
                    <ValidationProvider name="password confirmation"
                                        rules="required|validatePassword|password:@password">
                        <a-form-item
                            :label="$t('pages.login.password confirmation')"
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

                    <div class="button-submit">
                        <a-config-provider :autoInsertSpaceInButton="false">
                            <button
                                html-type="submit"
                                class="btn-cancel login-btn"
                                :loading="state.loginBtn">
                                {{ $t("pages.login.change") }}
                            </button>
                        </a-config-provider>
                    </div>
                </a-form>
            </ValidationObserver>
        </a-card>
    </div>
</template>

<script>
import {mapActions} from "vuex";
// import SelectLang from '@/components/SelectLang'

export default {
    layout: "blank",
    components: {
        // SelectLang
    },

    props: {
        prefixCls: {
            type: String,
            default: "ant-pro-global-header-index-action"
        }
    },
    data() {
        return {
            changePasswordBtn: false,
            // login type: 0 email, 1 username, 2 telephone
            loginType: 0,
            loginError: null,
            form: {
                password: "",
                password_confirmation: ""
            },
            state: {
                time: 60,
                changePasswordBtn: false,
                // login type: 0 email, 1 username, 2 telephone
                loginType: 0,
                smsSendBtn: false
            },
            headStyle: {
                "font-size": '26px',
                "font-weight": "800",
            }
        };
    },
    head() {
        return {
            title: 'パスワード忘れ',
            bodyAttrs: {
                class: 'current-page-reset-password'
            }
        }
    },
    created() {
        this.token = this.$route.query.token
        this.email = this.$route.query.email
        //check token
        this.checkTokenReset()
    },
    methods: {
        ...mapActions('forgot-password', ['actionCheckTokenResetPassWord', 'actionResetPassword']),

        /**
         * check token reset password
         *
         * @param {string} email - email admin
         * @param {string} token - token
         */
        checkTokenReset() {
            this.actionCheckTokenResetPassWord({email: this.email, token: this.token})
        },

        /**
         * reset password
         *
         * @param {string} token - token
         * @param {string} password - password
         * @param {string} forgot_password - forgot_password
         */
        resetPassword() {
            this.form.token = this.token
            this.actionResetPassword(this.form)
        }
    },
    mounted() {
    }
};
</script>
<style lang="less" src="assets/admin/auth.less"></style>
