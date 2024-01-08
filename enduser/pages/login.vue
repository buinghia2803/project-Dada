<template>
    <div class="main-login">
        <h3>
            Log in
        </h3>
        <hr class="line-title">
        <div class="fw-bold txt-head">
            DadAを使用するにはMETAMASKのアカウントが必要です。
        </div>

        <ConnectMetamask/>
    </div>
</template>

<script>

export default {
    components: {
        ConnectMetamask: () => import('~/components/custom/ConnectMetamask.vue'),
    },
    layout: "login",
    middleware: ['isAuth']
};
</script>

<style lang="less">
.main-login {
    margin-top: 64px;
    text-align: center;

    h3 {
        font-size: 32px;
        font-weight: bold;
        letter-spacing: 0.02em;
        margin-bottom: 0;
    }

    .txt-head {
        //font-weight: 500;
        font-size: 20px;
        margin-top: 110px;
        margin-bottom: 48px;
    }
}

@media (max-width: 567px) {
    .main-login {
        margin-top: 16px;

        .txt-head {
            width: calc(100% - 36px);
            margin: 0 auto;
            margin-top: 148px;
        }
    }
}
</style>

