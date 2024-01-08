<template>
    <div class="info-block-1">
        <h1 class="d-title">あなたの感性は、<br>もっと社会を動かす。</h1>
        <!--        <h1 class="d-title">もっと社会を動かす。</h1>-->

        <p class="m-0">DadAは </p>
        <p class="m-0">アーティスト保護を目的とした</p>
        <p class="m-0">デジタル作品をNFT化する際に</p>
        <p class="m-0">売り上げを安全に分配するシステムです。</p>

        <p class="d-note">※特許申請中</p>
        <a-config-provider :autoInsertSpaceInButton="false">
            <a-button html-type="button" v-if="!$auth.loggedIn" type="bg-cwhite" @click="clickSignup">新規登録</a-button>
        </a-config-provider>
        <a-config-provider :autoInsertSpaceInButton="false">
            <a-button html-type="button" v-if="!$auth.loggedIn" type="bwhite-cblack" @click="clickLogin">ログイン</a-button>
        </a-config-provider>
    </div>
</template>

<script>


export default {
    name: 'InfoBlock1',
    auth: false,
    data() {
        return {}
    },
    computed: {},
    methods: {
        clickLogin() {
            return this.$router.push({path: '/login'})
        },
        clickSignup() {
            return this.$router.push({path: '/signup'})
        }
    },
    created() {
    }
}
</script>

<style lang="less" src="assets/less/user/top.less"></style>
