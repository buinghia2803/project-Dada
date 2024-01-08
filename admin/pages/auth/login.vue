<template>
    <div class="main login-container">
        <a-card title="DadA" :bordered="false" class="ant-card-auth" :headStyle="headStyle">
            <div class="title_login">{{ $t('pages.login.login admin') }}</div>
            <ValidationObserver ref="observer">
                <a-form
                    id="formLogin"
                    class="user-layout-login"
                    ref="formLogin"
                    slot-scope="{ handleSubmit }"
                    @submit.prevent="handleSubmit(login)"
                >
                    <a-alert
                        v-if="loginError"
                        type="error"
                        show-icon
                        style="margin-bottom: 24px"
                        :message="loginError"
                    />
                    <ValidationProvider name="email" rules="required|email_trimmed">
                        <a-form-item
                            :label="$t('pages.login.email')"
                            slot-scope="{ errors }"
                            :validateStatus="errors[0] ? 'error' : 'success'"
                            :help="errors[0]"
                        >
                            <a-input
                                size="large"
                                type="text"
                                v-model="form.email"
                                placeholder="メールアドレスを入力してください"
                            >
                            </a-input>
                        </a-form-item>
                    </ValidationProvider>
                    <ValidationProvider name="password" rules="required">
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
                    <div class="button-submit" style="margin-top: 24px">
                        <a-config-provider :autoInsertSpaceInButton="false">
                            <button
                                html-type="submit"
                                class="btn-cancel login-btn"
                                :loading="state.loginBtn">
                                {{ $t("pages.login.submit") }}
                            </button>
                        </a-config-provider>
                    </div>
                    <div class="forge-password">
                        <router-link
                            :to="{ name: 'auth-forgot-password'}"
                            style="color: black;text-decoration: underline; font-size: 16px"
                        >
                            {{ $t("pages.login.forgot_password") }}
                        </router-link>
                    </div>
                </a-form>
            </ValidationObserver>
        </a-card>
    </div>
</template>

<script>
// import SelectLang from '@/components/SelectLang'

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
            loginBtn: false,
            // login type: 0 email, 1 username, 2 telephone
            loginType: 0,
            loginError: null,
            requiredTwoStepCaptcha: false,
            stepCaptchaVisible: false,
            form: {
                email: "",
                password: ""
            },
            state: {
                time: 60,
                loginBtn: false,
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
            title: '管理者ログイン',
            bodyAttrs: {
                class: 'current-page-admin-login'
            }
        }
    },
    methods: {
        resolveState({errors, flags}) {
            if (errors[0]) {
                return "error";
            }

            if (flags.pending) {
                return "validating";
            }

            if (flags.valid) {
                return "success";
            }

            return "";
        },
        /**
         * login
         *
         * @param {string} email - email admin
         * @param {string} password - password
         */
        login() {
            const {state} = this;
            state.loginBtn = true;
            this.$auth
                .loginWith("local", {data: this.form})
                .then(data => {
                    state.loginBtn = false;
                    this.$router.push("/revenue").catch(()=>{});
                })
                .catch(e => {
                    // this.$toast.error('必須項目に入力してください。');
                    state.loginBtn = false;
                });
        }
    }
};
</script>

<style lang="less" src="assets/admin/auth.less"></style>
