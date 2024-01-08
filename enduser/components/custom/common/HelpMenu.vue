<template>
    <!-- Start my page help menu -->
    <a-drawer
        :visible="visibleHelp"
        class="drawer_mypage_help"
        title="ヘルプ"
        placement="right"
        @close="clickVisibleHelp"
    >
        <div>
            <a-config-provider :autoInsertSpaceInButton="false">
                <a-button style="text-align: left; font-size: 16px; padding-left: 16px;" class="btn-white size-md"
                          @click="clickVisibleHelp">
                    困ったらまずはこちら
                    <span class="icon-navigate">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                          d="M8.33333 5V6.66667H4.16667V15.8333H13.3333V11.6667H15V16.6667C15 16.8877 14.9122 17.0996 14.7559 17.2559C14.5996 17.4122 14.3877 17.5 14.1667 17.5H3.33333C3.11232 17.5 2.90036 17.4122 2.74408 17.2559C2.5878 17.0996 2.5 16.8877 2.5 16.6667V5.83333C2.5 5.61232 2.5878 5.40036 2.74408 5.24408C2.90036 5.0878 3.11232 5 3.33333 5H8.33333ZM17.5 2.5V9.16667H15.8333V5.34417L9.33917 11.8392L8.16083 10.6608L14.6542 4.16667H10.8333V2.5H17.5Z"
                          fill="black"/>
                    </svg>
                  </span>
                </a-button>
            </a-config-provider>
        </div>
        <div class="mt-3">
            <a-config-provider :autoInsertSpaceInButton="false">
                <a-button style="text-align: left; font-size: 16px; padding-left: 16px;" class="btn-white size-md"
                          @click="clickVisibleHelp">
                    公式LINEで質問する
                    <span class="icon-navigate">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path
                          d="M8.33333 5V6.66667H4.16667V15.8333H13.3333V11.6667H15V16.6667C15 16.8877 14.9122 17.0996 14.7559 17.2559C14.5996 17.4122 14.3877 17.5 14.1667 17.5H3.33333C3.11232 17.5 2.90036 17.4122 2.74408 17.2559C2.5878 17.0996 2.5 16.8877 2.5 16.6667V5.83333C2.5 5.61232 2.5878 5.40036 2.74408 5.24408C2.90036 5.0878 3.11232 5 3.33333 5H8.33333ZM17.5 2.5V9.16667H15.8333V5.34417L9.33917 11.8392L8.16083 10.6608L14.6542 4.16667H10.8333V2.5H17.5Z"
                          fill="black"/>
                    </svg>
                  </span>
                </a-button>
            </a-config-provider>
        </div>
<!--        <div class="mt-3">
            <a-config-provider :autoInsertSpaceInButton="false">
                <a-button style="font-size: 18px;" class="btn-black size-md" @click="clickVisibleHelp">
                    お問い合わせ
                </a-button>
            </a-config-provider>
        </div>-->
    </a-drawer>
    <!-- End my page help menu -->
</template>

<script>

export default {
    name: 'HelpMenu',
    data() {
        return {}
    },
    props: {
        visibleHelp: {
            type: Boolean,
            required: true
        }
    },
    event: [
        'visibleHelpChange'
    ],
    methods: {
        clickVisibleHelp() {
            this.$emit('visibleHelpChange', false);
        }
    }
}
</script>

<style lang="less" scoped>

.icon-navigate {
    margin-top: 3px;
    height: auto;
    margin-left: 8px;
    vertical-align: -4px;
}

.drawer_mypage_help {
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

    .ant-btn.btn-white:hover {
        .icon-navigate {
            svg path {
                fill: #ffffff;
            }
        }
    }
}
</style>
