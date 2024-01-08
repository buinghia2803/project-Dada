<template>
    <div class="footer-top">
        <div class="d-left-info">
            <div class="link-map">
                <a class="text-white" href="javascript:void(0)" @click="clickScrollInToView('problem-solved')">DadAが解決する課題 </a>
                <a class="text-white" href="javascript:void(0)" @click="clickScrollInToView('get-started')">DadAのはじめ方 </a>
                <a class="text-white" href="javascript:void(0)" @click="clickScrollInToView('faq')">よくあるご質問 </a>
                <a class="text-white" href="/">外部リンク </a>
                <a class="text-white" href="/">お問い合わせ </a>
                <a class="text-white" href="/terms">利用規約 </a>
                <a class="text-white" href="/policy">プライバシーポリシー </a>
                <a class="text-white" href="/">運営会社 </a>
            </div>
        </div>
        <div class="d-right-info">
            <div>
                <div class="link-map">
                    <a class="text-white" v-if="!$auth.loggedIn" href="/signup">新規登録 </a>
                    <a class="text-white" href="javascript:void(0)" v-if="$auth.loggedIn" @click="logoutUser">ログアウト </a>
                    <a class="text-white" v-else href="/login">ログイン </a>
                </div>
            </div>
            <div class="link-map-logo">
                <a class="other-footer text-white" href="/">
                    <img src="~/assets/images/logo.png" alt="logo">
                    © 2022 DadA
                </a>
            </div>
        </div>
    </div>
</template>

<script>

import authBase from "@/mixins/auth";

export default {
    name: 'TopFooter',
    mixins:[
        authBase
    ],
    data() {
        return {}
    },
    methods: {
        clickScrollInToView(id = '') {
            const element = document.getElementById(id);
            if (element) {
                element.scrollIntoView(true);
                setTimeout(() => this.$emit('visibleSpChange', false), 400)
            }
        },
    }
}
</script>

<style lang="less" src="assets/less/user/top.less"></style>
