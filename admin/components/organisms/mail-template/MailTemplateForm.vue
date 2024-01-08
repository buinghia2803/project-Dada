<template>
    <div>
        <a-spin :spinning="loading">
            <div class="row">
                <div>
                    <div class="">
                        <ValidationObserver ref="observer">
                            <a-form
                                ref="form"
                                :label-col="{ md: 2 }"
                                :wrapper-col="{ md: 22 }"
                                slot-scope="{ handleSubmit }"
                                @submit.prevent="handleSubmit(submit)"
                            >
                                <a-row>
                                    <a-col flex="100px">
                                        <ValidationProvider
                                            name="subject"
                                            rules="required|max:255"
                                        >
                                            <a-form-item
                                                prop="name"
                                                slot-scope="{ errors }"
                                                :validateStatus="errors[0]? 'error': 'success'"
                                                :help="errors[0]"
                                            >
                                                <span slot="label">
                                                    <label title="件名" class="d-ant-form-item-required">件名</label>
                                                </span>
                                                <a-input
                                                    v-model="model.subject"
                                                    placeholder="入力してください"
                                                >
                                                </a-input>
                                            </a-form-item>
                                        </ValidationProvider>
                                    </a-col>
                                    <a-col flex="auto">
                                        <ValidationProvider
                                            name="content"
                                            rules="required"
                                        >
                                            <a-form-item
                                                prop="name"
                                                slot-scope="{ errors }"
                                                :validateStatus="errors[0]? 'error': 'success'"
                                                :help="errors[0]"
                                            >
                                                <span slot="label">
                                                    <label title="内容" class="d-ant-form-item-required">内容</label>
                                                </span>
                                                <ckeditor-nuxt
                                                    v-model="model.content"
                                                    name="全社員への連絡"
                                                    :config="editorConfig"
                                                />
                                            </a-form-item>
                                        </ValidationProvider>
                                    </a-col>
                                </a-row>
                                <div class="btn-group">
                                    <a-config-provider :autoInsertSpaceInButton="false">
                                        <a-button :size="'large'" class="btn-action btn-cancel-lg" html-type="submit">保存</a-button>
                                    </a-config-provider>
                                </div>
                            </a-form>
                        </ValidationObserver>
                    </div>
                </div>
            </div>
        </a-spin>
    </div>
</template>
<script>
import { CKEDITOR_IMAGE_CONFIG } from '~/utils/constants'
import { mapActions } from 'vuex'
export default {
    components: {
        'ckeditor-nuxt': () => {
            if (process.client) {
                return import('@blowstack/ckeditor-nuxt')
            }
        }
    },

    data() {
        return {
            editorConfig: {
                placeholder: '内容を記入',
                image: CKEDITOR_IMAGE_CONFIG,
                removePlugins: ['Title'],
                language: 'ja',
                toolbar: {
                    items: [
                        'bold',
                        'italic',
                        'strikethrough',
                        'link',
                        '|',
                        'heading',
                        'blockQuote',
                        'code',
                        'numberedList',
                        'bulletedList',
                        '|',
                        'indent',
                        'outdent',
                        '|',
                        'imageupload',
                    ]
                },
                simpleUpload: {
                    // The URL that the images are uploaded to.
                    uploadUrl: this.$nuxt.context.env.VUE_APP_URL_API + '/admin/upload-file',
                },
            },
            loading: false
        }
    },

    props: {
        type: {
            type: Number,
            default: 1
        },

        model: {
            type: Object,
            default: () => { }
        },
    },

    watch: {
        model(val) {
            this.$refs.observer.reset()
        }
    },

    methods: {
        ...mapActions({
            actionAdd: 'mail-template/actionAdd',
            actionUpdate: 'mail-template/actionUpdate',
        }),

         /**
         * on submit form
         */
        submit () {
            this.loading = true
            this.model.type = this.type
            const action = this.model.id ? this.actionUpdate : this.actionAdd
            // call api update or create mail template
            action(this.model).finally(() => {
                this.loading = false
            })
        }
    }
}
</script>
<style scoped lang="less">
.input_first_name{
    width: 90%;
}

.btn-group {
    margin-left: 8.2%;
    justify-content: center;
}

</style>
