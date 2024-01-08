<template>
    <div>
        <a-spin :spinning="loading">
            <a-card class="mb-4 d-card-no-border d-head-title">
                <template slot="title">
                    {{ $t("module.mail_template") }}
                </template>
                <div class="mailtemplate-menu-bar">
                    <ul class="row list-menu">
                        <li
                            :class="
                                item.id === actived
                                    ? 'item-menu active'
                                    : 'item-menu'
                            "
                            v-for="(item, key) in MAIL_TEMPLATE"
                            :key="key"
                            @click="getDetailTemplate(item.id)"
                        >
                            {{ item.label }}
                        </li>
                    </ul>
                </div>
                <div class="mail-template-form">
                    <mail-template-form :type="selectedType" :model="detailMailTemplate"/>
                </div>
            </a-card>
        </a-spin>
    </div>
</template>
<script>
import {MAIL_TEMPLATE} from '~/utils/constants'
import {mapActions} from 'vuex'
import {MailTemplateModel} from '~/services/modules/mail-template/MailTemplateModel'

export default {
    components: {
        MailTemplateForm: () => import('~/components/organisms/mail-template/MailTemplateForm.vue')
    },

    data() {
        return {
            loading: false,
            MAIL_TEMPLATE,
            actived: 1,
            selectedType: 1,
            detailMailTemplate: new MailTemplateModel()
        }
    },
    head() {
        return {
            title: `${this.$t('menu.mail_template.default')}`,
            bodyAttrs: {
                class: 'current-page-mail-template-index'
            }
        }
    },
    mounted() {
        this.getDetailTemplate(this.selectedType)
    },
    methods: {
        ...mapActions({getMailTemplateByType: 'mail-template/getMailTemplateByType'}),

        /**
         * get detail mail template
         *
         * @param Integer type
         */
        getDetailTemplate(type) {
            this.loading = true
            this.actived = type
            this.selectedType = type
            // call api get mail template by type
            this.getMailTemplateByType({type}).then(({data}) => {
                if (data) {
                    this.detailMailTemplate = new MailTemplateModel(data)
                }
            }).catch(() => {
                this.detailMailTemplate = new MailTemplateModel()
            }).finally(() => {
                this.loading = false
            })
        }
    }
}
</script>
<style scoped lang="less">
.item-menu {
    list-style: none;
    padding: 10px 15px;
    cursor: pointer;
    margin-right: 10px;
    margin-left: 10px;
}

.list-menu {
    display: flex;
    padding-left: 0;
}

.item-menu:hover,
.active {
    background: #1890ff;
    color: #fff;
    border-radius: 5px;
}
</style>
