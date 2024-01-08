<template>
    <div class="main login-container">
        <a-card title="DadA" :bordered="false" class="ant-card-auth" :headStyle="headStyle">
            <div class="title_login">パスワード忘れ</div>
            <ValidationObserver ref="observer">
                <a-form
                    id="formLogin"
                    class="user-layout-login"
                    ref="formLogin"
                    slot-scope="{ handleSubmit }"
                    @submit.prevent="handleSubmit(forgotPassword)"
                >
                    <a-alert
                        v-if="loginError"
                        type="error"
                        show-icon
                        style="margin-bottom: 24px"
                        :message="loginError"
                    />
                    <ValidationProvider name="Email" rules="required|email_trimmed_no_dash">
                        <a-form-item
                            :label="$t('pages.login.email')"
                            slot-scope="{ errors }"
                            :validateStatus="errors[0] ? 'error' : 'success'"
                            :help="errors[0]"
                        >
                            <a-input
                                size="large"
                                type="text"
                                placeholder="メールアドレスを入力してください"
                                v-model="form.email"
                            >
                            </a-input>
                        </a-form-item>
                    </ValidationProvider>
                    <div class="button-submit" style="margin-top: 24px">
                        <a-config-provider :autoInsertSpaceInButton="false">
                            <button
                                html-type="submit"
                                class="btn-cancel login-btn"
                                :loading="state.loginBtn">
                                {{ $t("pages.login.send") }}
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

export default {
    layout: "blank",
    middleware: 'notAuthenticated',
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
            checkEmailBtn: false,
            loginType: 0,
            loginError: null,
            requiredTwoStepCaptcha: false,
            stepCaptchaVisible: false,
            form: {
                email: "",
            },
            state: {
                time: 60,
                checkEmailBtn: false,
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
                class: 'current-page-forgot-password'
            }
        }
    },
    methods: {
        ...mapActions('forgot-password', ['actionForgotPassword']),
        /**
         * forgot password
         *
         * @param {string} email - email admin
         */
        forgotPassword() {
            this.actionForgotPassword(this.form)
        }
    },
    mounted() {
    }
};
</script>

<style lang="less" src="assets/admin/auth.less"></style>
