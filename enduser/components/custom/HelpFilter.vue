<template>
    <!-- Start my page help menu -->
    <a-drawer
        :visible="visibleFilter"
        class="drawer_mypage_filter"
        title="ヘルプ"
        placement="right"
        @close="clickVisibleFilter"
    >
        <div>
            <a-config-provider :autoInsertSpaceInButton="false">
                <a-button style="text-align: left; font-size: 16px; padding-left: 16px;" class="btn-white size-md">
                    dfsfsfsf
                </a-button>
            </a-config-provider>
        </div>

    </a-drawer>
    <!-- End my page help menu -->
</template>

<script>

export default {
    name: 'HelpFilter',
    data() {
        return {}
    },
    props: {
        visibleFilter: {
            type: Boolean,
            required: true
        }
    },
    event: [
        'visibleFilterChange'
    ],
    methods: {
        clickVisibleFilter() {
            this.$emit('visibleFilterChange', false);
        }
    }
}
</script>

<style lang="less" scoped>
.drawer_mypage_filter {
    ::v-deep {
        .ant-drawer-content-wrapper {
            max-width: 327px;
            width: 100% !important;

            .ant-drawer-content {
                .ant-drawer-header {
                    display: flex;
                    justify-content: center;
                    margin: 10px 15px;
                    border-bottom: 1px solid #B3B3B3;
                    padding-bottom: 14px;

                    .ant-drawer-title {
                        font-weight: @fw-bold;
                        font-size: @fsj-bt-pc-large;
                    }

                    .ant-drawer-close {
                        right: none;
                        left: 0;

                        i {
                            transform: scale(2.5);
                        }
                    }
                }

                .ant-drawer-body {
                    padding-top: 20px !important;
                    padding-left: 42px;
                }
            }
        }
    }
}
</style>
