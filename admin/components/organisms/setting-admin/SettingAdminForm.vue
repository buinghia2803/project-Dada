<template>
    <div>
        <a-card class="mb-4 d-card-no-border d-head-title">
            <template slot="title">
                {{ $t("module.setting") }}
            </template>
            <div class="title-form">システム手数料</div>
            <ValidationObserver ref="observer">
                <a-form id="formLogin" ref="form" :label-col="{ md: 6 }" :wrapper-col="{ md: 6 }"
                    slot-scope="{ handleSubmit }" @submit.prevent="handleSubmit(focusIfError)">
                    <a-spin :spinning="loading">
                        <div class="py-3">
                            <a-row type="flex" :gutter="20">
                                <a-col :span="24" :xl="12">
                                    <ValidationProvider :name="$t('pages.setting.OpenSea')"
                                        rules="required|lessThan100:100|negative:0" v-slot="{ errors }">
                                        <a-form-item :label="$t('pages.setting.OpenSea')" class="percent" prop="name"
                                            :validateStatus="errors[0] ? 'error' : 'success'">
                                            <div class="form-item">
                                                <div class="input-form">
                                                    <input type="text" v-model.trim="data.system_percent"
                                                        class="input-wrapper"
                                                        :onkeydown="'javascript: return event.keyCode == 69 ? false : true'" />
                                                    <span>%</span>
                                                </div>
                                                <span class="error">{{ errors[0] }}</span>
                                            </div>
                                        </a-form-item>
                                    </ValidationProvider>
                                </a-col>
                            </a-row>
                            <a-row type="flex" :gutter="20">
                                <a-col :span="24" :xl="12">
                                    <ValidationProvider :name="$t('pages.setting.DadA')"
                                        rules="required|lessThan100:100|negative:0" v-slot="{ errors }">
                                        <a-form-item class="percent" :label="$t('pages.setting.DadA')" prop="name"
                                            :validateStatus="errors[0] ? 'error' : 'success'">
                                            <div class="form-item">
                                                <div class="input-form">
                                                    <input type="text" v-model.trim="data.opensea_percent"
                                                        class="input-wrapper"
                                                        :onkeydown="'javascript: return event.keyCode == 69 ? false : true'" />
                                                    <span>%</span>
                                                </div>
                                                <span class="error">{{ errors[0] }}</span>
                                            </div>
                                        </a-form-item>
                                    </ValidationProvider>
                                </a-col>
                            </a-row>
                        </div>

                        <div class="pb-3">
                            <a-row type="flex" :gutter="20">
                                <a-col :span="24" :xl="12">
                                    <a-row :gutter="0">
                                        <a-col :span="24" :md="6"></a-col>
                                        <a-col :span="24" :md="18">
                                            <a-form-item style="margin-top: 24px">
                                                <a-config-provider :autoInsertSpaceInButton="false">
                                                    <a-button size="large" html-type="submit"
                                                        class="btn-action btn-submit-lg">
                                                        {{ $t("common.change") }}
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
        </a-card>
    </div>
</template>
<script>
export default {
    props: {
        create: {
            type: Boolean,
        },
        data: {
            type: Object,
        },
    },
    components: {},
    data() {
        return {
            form: {},
            listOrganization: [],
            defaultOption: {
                label: this.$t("common.default_option"),
                value: 0,
            },
            loading: false,
            listRoles: [],
        };
    },

    computed: {},

    mounted() {
    },

    methods: {
        focusIfError() {
            this.$emit('submit', this.data)
        }
    },
};
</script>
<style>
.input-wrapper {
    width: 100px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    border-radius: 5px;
    height: 30px;
    direction: RTL;
    border: 1px solid #dbdbdb;
    margin-right: 5px;
}

.error {
    width: 240px;
    color: #FF4D76;
}

.form-item {
    display: grid;
    line-height: normal;
}

.input-form {
    height: 40px;
    display: flex;
    align-items: center
}
</style>

