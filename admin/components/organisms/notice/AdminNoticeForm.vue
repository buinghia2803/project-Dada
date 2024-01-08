<template>
    <div>
        <ValidationObserver ref="observer">
            <a-form
                id="formLogin"
                ref="form"
                :label-col="{ md: 4 }"
                :wrapper-col="{ md: 20 }"
                slot-scope="{ handleSubmit }"
                @submit.prevent="handleSubmit(submit)"
            >
                <a-spin :spinning="loading">
                    <div class="py-3">
                        <a-row>
                            <a-col :span="24" :xl="30">
                                <ValidationProvider
                                    name="title"
                                    rules="required|maxlength:255"
                                >
                                    <a-form-item
                                        class=""
                                        :label="$t('pages.notice.title')"
                                        prop="name"
                                        slot-scope="{ errors }"
                                        :validateStatus="errors[0] ? 'error' : 'success'"
                                        :help="errors[0]"
                                    >
                                        <a-input
                                            placeholder="タイトル"
                                            v-model="form.title"
                                        >
                                        </a-input>
                                    </a-form-item>
                                </ValidationProvider>
                            </a-col>
                        </a-row>
                        <a-row>
                            <a-col :span="24" :xl="30" class="input_first_name">
                                <ValidationProvider name="content" rules="required">
                                    <a-form-item
                                        :label="$t('pages.notice.content')"
                                        prop="name"
                                        slot-scope="{ errors }"
                                        :validateStatus="errors[0]? 'error': 'success'"
                                        :help="errors[0]"
                                    >
                                        <ckeditor-nuxt
                                            name="全社員への連絡"
                                            :config="editorConfig"
                                            v-model="form.content"
                                        />
                                    </a-form-item>
                                </ValidationProvider>
                            </a-col>
                        </a-row>
                        <a-row>
                            <a-col :span="24" :xl="30">
                                <ValidationProvider
                                    name="type"
                                    rules="required"
                                >
                                    <a-form-item
                                        :label="$t('pages.notice.dad/artist')"
                                        prop="name"
                                        slot-scope="{ errors }"
                                        :validateStatus="errors[0] ? 'error' : 'success'"
                                        :help="errors[0]"
                                    >
                                        <a-radio-group v-model="form.type">
                                            <a-radio :value="3">
                                                <span>{{ $t('pages.notice.all') }}</span>
                                            </a-radio>
                                            <a-radio :value="1">
                                                <span>{{ $t('pages.notice.dad') }}</span>
                                            </a-radio>
                                            <a-radio  :value="2">
                                                <span>{{ $t('pages.notice.artist') }}</span>
                                            </a-radio>
                                        </a-radio-group>
                                    </a-form-item>
                                </ValidationProvider>
                            </a-col>
                        </a-row>
                        <a-row>
                            <a-col :span="24" :xl="30">
                                <ValidationProvider
                                    name="date_public"
                                    rules="required"
                                >
                                    <a-form-item
                                        :label="$t('notice.release date')"
                                        prop="name"
                                        slot-scope="{ errors }"
                                        :validateStatus="errors[0] ? 'error' : 'success'"
                                        :help="errors[0]"
                                    >
                                        <a-config-provider :locale="localeDateTime">
                                            <a-date-picker  v-model="form.date_public"
                                                            type="datetime"
                                                            class="ant-col-3 pl-1"
                                                            placeholder="yyy-mm-dd hh:mm"
                                                            :format="'YYYY.MM.DD HH:MM'"
                                                            :disabled-date="disabledDate"
                                                            :show-time="{ defaultValue: moment('00:00:00', 'HH:mm') }"
                                                            @change="onChangeDatePublic"
                                            />
                                        </a-config-provider>
                                    </a-form-item>
                                </ValidationProvider>
                            </a-col>
                        </a-row>
                    </div>

                    <div class="pb-3">
                        <a-row type="flex" :gutter="20">
                            <a-col :span="24" :xl="30">
                                <a-row :gutter="0">
                                    <a-col :span="24" :md="4"></a-col>
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
<style scoped>
.percent:after {
    content: '%';
    position: absolute;
    top: 10px;
    right: 350px;
    width: 23px;
    font-size: 15px
}
</style>
<script>
import {EDITOR_CONFIG, STATUS_NOTIFICATION} from '~/utils/constants'
import {NotifyModel} from "~/services/modules/notifies/NotifyModel";
import {mapActions} from "vuex";
import 'moment/locale/ja';
// moment.locale('ja');
import ja_JP from 'ant-design-vue/es/locale/ja_JP';
import {UserModel} from "~/services/modules/users/UserModel";
import moment from "moment";
// import {UserModel} from "~/services/modules/users/UserModel";

export default {
    props: {
        create: {
            type: Boolean
        }
    },
    components: {
        'ckeditor-nuxt': () => {
            if (process.client) {
                return import('@blowstack/ckeditor-nuxt')
            }
        }
    },
    data() {
        return {
            status: STATUS_NOTIFICATION,
            localeDateTime: ja_JP,
            form: new NotifyModel(),
            listOrganization: [],
            defaultOption: {
                label: this.$t('common.default_option'),
                value: 0
            },
            loading: false,
            listRoles: [],
            editorConfig: EDITOR_CONFIG
        }
    },

    computed: {
        moment: () => moment,
    },

    mounted () {
        // this.getRoles()
        const id = +this.$route.params.id || 0
        // check id -> get detail user
        if (id) {
            this.loading = true
            this.actionShow({ id }).then(response => {
                this.form = new NotifyModel(response.data)
            }).finally(() => {
                this.loading = false
            })
        }
    },

    methods: {
        ...mapActions({
            actionAdd: 'notification/actionAdd',
            actionUpdate: 'notification/actionUpdate',
            actionShow: 'notification/actionShow',
            // actionGetAllNotify: "notification/actionGetAll",
        }),
        /**
         * submit
         */
        async submit () {
            this.loading = true
            if (!this.form.id) {
                this.form.sender_type = 1
                this.form.status = 0
            }
            //check action update or create
            const action = this.form.id ? await this.actionUpdate : await this.actionAdd
            // send api update or create notice
            const data = await action(this.form)
            this.loading = false
            if(data) {
                // this.form = new UserModel();
                this.$refs.observer.reset();
                this.$router.push('/notice')
            }
        },
        onChangeDatePublic(value, dateString) {
            this.form.date_public = dateString
        },
        disabledDate(current) {
            // Can not select days before today and today
            return current && current <= moment().endOf('day');
        },

        // disabledDateTime() {
        //     return {
        //         disabledHours: () => this.range(0, 24).splice(4, 20),
        //         disabledMinutes: () => this.range(30, 60),
        //         disabledSeconds: () => [55, 56],
        //     };
        // },
    }
}
</script>
<!--<style lang="less" src="../../../assets/admin/custom.less"></style>-->

