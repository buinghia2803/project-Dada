<template>
    <ValidationObserver ref="observer">
        <a-form
            id="formLogin"
            ref="form"
            :label-col="{ md: 6 }"
            :wrapper-col="{ md: 24 }"
            slot-scope="{ handleSubmit }"
            @submit.prevent="handleSubmit(submit)"
        >
            <a-spin :spinning="loading">
                <div class="py-3">
                    <a-row
                        type="flex"
                        :gutter="20"
                        orientation="left"
                    >
                        <a-col :span="24" :xl="12">
                            <ValidationProvider
                                name="public_address_main"
                                rules="required|max:126|validateWalletAddress"
                            >
                                <a-form-item
                                    prop="public_address_main"
                                    slot-scope="{ errors }"
                                    :validateStatus="errors[0] ? 'error' : 'success'"
                                    :help="errors[0]"
                                >
                                    <div class="ant-col-md-6 d-ant-form-item-required">{{$t('user.public_address_main')}}</div>
                                    <div class="ant-col-md-18">
                                        <a-input
                                            v-model="form.public_address_main"
                                            placeholder="入力してください"
                                        >
                                        </a-input>
                                    </div>
                                </a-form-item>
                            </ValidationProvider>
                        </a-col>
                    </a-row>
                    <a-row
                        type="flex"
                        :gutter="24"
                        orientation="left"
                    >
                        <a-col :span="24" :xl="12">
                            <ValidationProvider
                                name="full_name"
                                rules="required|max:126"
                            >
                                <a-form-item
                                    prop="name"
                                    slot-scope="{ errors }"
                                    :validateStatus="errors[0] ? 'error' : 'success'"
                                    :help="errors[0]"
                                >
                                    <div class="ant-col-md-6 d-ant-form-item-required">{{$t('user.full_name')}}</div>
                                    <div class="ant-col-md-18">
                                        <a-input
                                            v-model="form.full_name"
                                            placeholder="入力してください"
                                        >
                                        </a-input>
                                    </div>
                                </a-form-item>
                            </ValidationProvider>
                        </a-col>
                    </a-row>
                    <a-row
                        type="flex"
                        :gutter="24"
                        orientation="left"
                    >
                        <a-col :span="24" :xl="12">
                            <ValidationProvider
                                name="email"
                                rules="email_trimmed_no_dash|max:255"
                            >
                                <a-form-item
                                    prop="email"
                                    slot-scope="{ errors }"
                                    :validateStatus="errors[0] ? 'error' : 'success'"
                                    :help="errors[0]"
                                >
                                    <div class="ant-col-md-6">{{$t('user.email')}}</div>
                                    <div class="ant-col-md-18">
                                        <a-input
                                            v-model="form.email"
                                            placeholder="入力してください"
                                        >
                                        </a-input>
                                    </div>

                                </a-form-item>
                            </ValidationProvider>
                        </a-col>
                    </a-row>
                    <a-row
                        type="flex"
                        :gutter="20"
                        orientation="left"
                    >
                        <a-col :span="24" :xl="12">
                            <ValidationProvider
                                name="positions"
                                :rules="'max:126'"
                            >
                                <a-form-item
                                    prop="positions"
                                    slot-scope="{ errors }"
                                    :validateStatus="errors[0] ? 'error' : 'success'"
                                    :help="errors[0]"
                                >
                                    <div class="ant-col-md-6">{{$t('user.positions')}}</div>
                                    <div class="ant-col-md-18">
                                        <a-input
                                            v-model="form.positions"
                                            type="text"
                                            placeholder="入力してください"
                                        >
                                        </a-input>
                                    </div>
                                </a-form-item>
                            </ValidationProvider>
                        </a-col>
                    </a-row>
                    <a-row
                        type="flex"
                        :gutter="20"
                        orientation="left"
                    >
                        <a-col :span="24" :xl="12">
                            <ValidationProvider
                                name="description"
                                rules="max:500"
                            >
                                <a-form-item
                                    prop="description"
                                    slot-scope="{ errors }"
                                    :validateStatus="errors[0] ? 'error' : 'success'"
                                    :help="errors[0]"
                                >
                                    <div class="ant-col-md-6">{{$t('user.description')}}</div>
                                    <div class="ant-col-md-18">
                                        <a-textarea
                                            v-model="form.description"
                                            type="password"
                                            placeholder="入力してください"
                                            rows="4"
                                        >
                                        </a-textarea>
                                    </div>
                                </a-form-item>
                            </ValidationProvider>
                        </a-col>
                    </a-row>
                    <a-row
                        type="flex"
                        :gutter="20"
                        orientation="left"
                    >
                        <a-col :span="24" :xl="12">
                            <ValidationProvider
                                :name="$t('user.status.default')"
                            >
                                <a-form-item
                                    slot-scope="{ errors }"
                                    :validateStatus="errors[0] ? 'error' : 'success'"
                                    :help="errors[0]"
                                >
                                    <div class="ant-col-md-6">{{$t('user.status.default')}}</div>
                                    <div class="ant-col-md-18">
                                        <a-select
                                            v-model="form.status"
                                            :placeholder="$t('user.status.default')"
                                        >
                                            <a-select-option
                                                v-for="(item,index) in listStatus"
                                                :key="index"
                                                :value="item.key"
                                            >
                                                {{ item.value }}
                                            </a-select-option>
                                        </a-select>
                                    </div>
                                </a-form-item>
                            </ValidationProvider>
                        </a-col>
                    </a-row>
                    <a-row
                        type="flex"
                        :gutter="20"
                        orientation="left"
                    >
                        <a-col :span="24" :xl="12">
                            <a-form-item
                                prop="total_contract"
                            >
                                <div class="ant-col-md-6">{{$t('user.total_contract')}}</div>
                                <div class="ant-col-md-18">
                                    {{ form.count_contract }}
                                </div>

                            </a-form-item>
                        </a-col>
                    </a-row>

                    <a-row
                        type="flex"
                        :gutter="20"
                        orientation="left"
                    >
                        <a-col :span="24" :xl="12">
                            <ValidationObserver
                                name="image_url"
                                rules="validateImage"
                            >
                                <div class="ant-row ant-form-item">
                                    <div class="ant-col ant-col-md-6 ant-form-item-label">
                                        <div>{{$t('user.avatar')}}</div>
                                    </div>
                                    <div class="ant-col ant-col-md-18 ant-form-item-control-wrapper">
                                        <div class="ant-form-item-control">
                                            <img :src="file ? file : imageDefault" alt="avatar" height="120px" width="120px" class="border-radius-50">
                                            <span class="remove-img" @click="removeImage($event)">x</span>
                                            <a-input type="file" id="image_url" @change="avatarChange($event)" accept="image/*"></a-input>
                                        </div>
                                        <label for="image_url" class="mt-2 btn-upload">アップロード</label>
                                        <div :class="['avatar-error', checkErrorFile ? '' : 'd-none']">{{msgErrorFile}}</div>
                                    </div>
                                </div>
                            </ValidationObserver>

                        </a-col>
                    </a-row>
                </div>

                <div class="pb-3">
                    <a-row
                        type="flex"
                        :gutter="20"
                        orientation="left"
                    >
                        <a-col :span="24" :xl="12">
                            <a-row :gutter="0">
                                <a-col
                                    :span="24"
                                    :md="6"
                                >

                                </a-col>
                                <a-col
                                    :span="24"
                                    :md="18"
                                >
                                    <a-config-provider :autoInsertSpaceInButton="false">
                                        <a-button html-type="submit"
                                                  size="large"
                                                  class="btn-action btn-submit-lg">
                                            {{ '保存' }}
                                        </a-button>
                                    </a-config-provider>
                                    <a-config-provider :autoInsertSpaceInButton="false">
                                        <a-button html-type="button"
                                                  class="btn-action btn-cancel-lg ml-3"
                                                  @click="back()">
                                            戻る
                                        </a-button>
                                    </a-config-provider>
                                </a-col>
                            </a-row>
                        </a-col>
                    </a-row>
                </div>
            </a-spin>
        </a-form>
    </ValidationObserver>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import imageDefault from '@/assets/images/avatar.png'
import {UserModel} from '@/services/modules/users/UserModel'

export default {
        name: "UserAdminForm",
        props: {
            create: {
                type: Boolean
            }
        },
        components: {
        },
        data () {
            return {
                imageDefault: imageDefault,
                file: '',
                checkErrorFile: false,
                msgErrorFile: '',
                form: new UserModel(),
                listOrganization: [],
                defaultOption: {
                    label: this.$t('common.default_option'),
                    value: 0
                },
                loading: false,
                listRoles: [],
                listStatus: [{
                    key: 1,
                    value: this.$t('user.status.active')
                },
                    {
                        key: 0,
                        value: this.$t('user.status.deactive')
                    }]
            }
        },

        computed: {
            ...mapGetters('user', [
                'getterShow'
            ])
        },

        mounted () {
            const id = +this.$route.params.id || 0
            // check id -> get detail user
            if (id) {
                this.loading = true
                this.actionShow({ id }).then(response => {
                    this.form = new UserModel(response.data)
                    this.form._method = 'PUT';
                    this.file = this.form.image_url ? this.$nuxt.context.env.IMAGE_URL+this.form.image_url : ''
                }).finally(() => {
                    this.loading = false
                })
            }
        },

        methods: {
            ...mapActions({
                actionAdd: 'user/actionAdd',
                actionUpdate: 'user/actionUpdate',
                actionShow: 'user/actionShow',
            }),

            /**
             * submit
             */
            async submit () {
                this.loading = true
                // check action update or create
                const action = this.form.id ? this.actionUpdate : this.actionAdd
                let dataSendApi = structuredClone(this.form);
                delete dataSendApi.count_contract;
                // send api update or create user
                const data = await action(dataSendApi)
                this.loading = false
                if(data) {
                    this.form = new UserModel();
                    this.$refs.observer.reset();
                    this.$router.push('/user')
                }
            },
            back() {
                this.$router.push('/user')
            },
            avatarChange(event) {
                const file = event.target.files[0];
                this.checkErrorFile = false;
                if (file) {
                    // validate file
                    if (file.type != 'image/jpeg' && file.type != 'image/jpg' && file.type != 'image/png') {
                        this.resetImage()
                        this.checkErrorFile = true;
                        this.msgErrorFile = this.$t('messages.error.invalid_image')
                        return;
                    }
                    if (file.size > 1000000) {
                        this.resetImage()
                        this.checkErrorFile = true;
                        this.msgErrorFile = this.$t('messages.error.max_file_size')
                        return;
                    }
                    this.form.image_url = file;
                    var reader = new FileReader();
                    reader.readAsDataURL(file);
                    let $this = this;
                    reader.onload = function () {
                        $this.file = reader.result
                    };
                } else {
                    this.resetImage();
                }
            },
            removeImage(event) {
                this.resetImage();
            },
            resetImage() {
                this.file = this.imageDefault;
                this.form.image_url = null;
            }
        }
    }
</script>
