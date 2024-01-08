<template>
    <div class="footer-main">
        <div class="d-center-info">
            <div class="line-1">
                <a class="text-white" href="/terms">利用規約 </a>
                <a class="text-white" href="/policy">プライバシーポリシー </a>
                <a v-if="$auth.loggedIn" class="text-white" @click="logoutUser">ログアウト</a>
            </div>
            <div class="link-map">
                <span class="text-white"> copyright ©︎2022 DadA Right Reserved </span>
            </div>
        </div>
    </div>
</template>

<script>
import auth from "@/mixins/auth";


export default {
    name: 'Footer',
    mixins:[
        auth
    ],
    data() {
        return {
            cookieData: '',
            role_dad: 1
        }
    },
    mounted () {
    },
    methods: {
    }
}
</script>

<style lang="less">
.footer-main {
    background: black;
}

.d-center-info {
    padding: 20px 0;

    .line-1 {
        display: flex;
        justify-content: center;
        font-size: 10px;

        & a:not(:first-child) {
            padding-left: 20px;
        }
    }

    .link-map {
        display: flex;
        font-size: 12px;
        justify-content: center;
    }
}
</style>
