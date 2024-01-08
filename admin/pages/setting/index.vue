<template>
    <a-card class="mb-4 d-card-no-border d-head-title">
        <a-spin :spinning="loading">
            <template slot="title">
                {{ $t("module.setting") }}
            </template>
            <setting-admin-form :data="data" @submit="submit"/>
        </a-spin>
    </a-card>
</template>

<script>
import {SettingAdminModel} from "../../services/modules/setting-admin/SettingAdminModel";
import {mapActions} from "vuex";

export default {
    components: {
        SettingAdminForm: () => import("~/components/organisms/setting-admin/SettingAdminForm.vue"),
    },
    head() {
        return {
            title: `${this.$t('menu.setting.default')}`,
            bodyAttrs: {
                class: 'current-page-setting-index'
            }
        }
    },
    data() {
        return {
            data: new SettingAdminModel(),
            loading: false,
        };
    },

    mounted() {
        this.getData();
    },

    methods: {
        ...mapActions({
            actionGetAll: "setting-admin/actionGetAll",
            actionAdd: "setting-admin/actionAdd",
        }),

        async submit() {
            this.loading = true;
            await this.actionAdd(this.data);
            this.loading = false;
        },

        getData() {
            this.loading = true;
            this.actionGetAll().then(({data}) => {
                this.data = new SettingAdminModel(data);
                this.loading = false;
            });
        },
    },
};
</script>
