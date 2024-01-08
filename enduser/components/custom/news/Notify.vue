<template>
    <div class="content-tab-2">
        <template v-if="data.length > 0">
            <div class="items" v-for="(item, key) in data" :key="key">
                <div :class="[{'fw-bold': item.status == 0 }]">
                    <p class="m-0 d-date">
                        {{ item.notification.date_public | formatDate }}
                    </p>
                    <p class="title fw-bold">
                        {{ item.notification.title }}
                    </p>
                    <p class="m-0 content">
                        {{ item.notification.content }}
                    </p>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="text">お知らせがありません。</div>
        </template>

        <div class="d-pagination">
            <a-pagination v-if="dataPagination.last_page !== 1" v-model="current" :total="dataPagination.total"
                :pageSize="perPage" show-less-items @change="changePage" />
        </div>
        <a-config-provider :autoInsertSpaceInButton="false">
            <a-button class="text-white bg-black mt-3"> 編集ページへ </a-button>
        </a-config-provider>
    </div>
</template>

<script>
export default {
    props: {
        data: {
            type: Array,
        },
        dataPagination: {
            type: Object,
        },
        perPage: {
            type: Number,
        },
        activeKey: {
            type: String,
            requried: true,
        },

    },
    data() {
        return {
            user: this.$auth.user,
            current: 1,

        };
    },
    methods: {
        /**
         * Pagination Notify
         */
        changePage(value) {
            this.$emit("change-page", value);
        },


    },
};
</script>

<style>
.text {
    text-align: center;
}
</style>
