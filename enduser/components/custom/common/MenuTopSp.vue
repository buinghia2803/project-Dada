<template>
    <a-drawer
        :visible="visibleTopMenu"
        class="drawer_top_menu"
        title=""
        placement="right"
        @close="clickVisibleHelp">

        <div class="sidebar-top-menu__content">
            <div class="s-item mt-0 role-btn" @click="clickScrollInToView('problem-solved')">DadAが解決する課題</div>
            <div class="s-item role-btn" @click="clickScrollInToView('get-started')">DadAのはじめ方</div>
            <div class="s-item role-btn" @click="clickScrollInToView('faq')">よくあるご質問</div>
            <div class="s-item role-btn" @click="clickOpenNewTab('X')"> 外部リンク</div>
            <!-- <div class="s-item role-btn" @click="clickOpenNewTab('')"> お問い合わせ</div>-->
            <div class="s-item role-btn" @click="clickOpenNewTab('/terms', '_self')"> 利用規約</div>
            <div class="s-item role-btn" @click="clickOpenNewTab('/policy', '_self')"> プライバシーポリシー</div>
            <div class="s-item role-btn" @click="clickOpenNewTab('#')"> 運営会社</div>
            <div v-if="$auth.loggedIn" class="s-item role-btn" @click="clickOpenNewTab('/mypage', '_self')"> マイページ</div>
        </div>
    </a-drawer>
</template>


<script>
export default {
    name: 'MenuTopSp',
    data() {
        return {}
    },
    props: {
        visibleTopMenu: {
            type: Boolean,
            required: true
        }
    },
    event: [
        'visibleSpChange'
    ],
    methods: {
        clickVisibleHelp() {
            this.$emit('visibleSpChange', false);
        },
        clickScrollInToView(id = '') {
            Promise.resolve()
                .then(() => {
                    this.$router.push({path: '/'})
                })
                .then(() => {
                    this.$nextTick(() => {
                        setTimeout(() => {
                            const element = document.getElementById(id);
                            if (element) {
                                element.scrollIntoView(true);
                                setTimeout(() => this.$emit('visibleSpChange', false), 400)
                            }
                        }, 200)
                    })
                })
        },
        clickOpenNewTab(url, option = '') {
            window.open(url, option ? option : "_blank");
            setTimeout(() => this.$emit('visibleSpChange', false), 400)
        }
    }
}
</script>

<style lang="less" scoped>
.drawer_top_menu {
    ::v-deep {
        .ant-drawer-content-wrapper {
            width: 100% !important;

            .ant-drawer-content {
                background-color: @main-color;
                color: @base-color;

                .ant-drawer-header-no-title {
                    .ant-drawer-close {
                        top: 17px;
                        right: 15px;
                        height: 36px;
                        width: 36px;
                        line-height: 36px;
                        font-size: 12px;

                        i {
                            color: white;
                            transform: scale(3.5);
                        }
                    }
                }

                .ant-drawer-wrapper-body {
                    .sidebar-top-menu__content {
                        margin-top: 115px - 24px;
                        font-size: @fsj-bt-pc-large;

                        .s-item {
                            margin-left: 20px;
                            margin-top: 16px;
                            height: 29px;
                            font-size: @fsj-bt-pc-large;
                        }
                    }
                }
            }
        }
    }
}
</style>
