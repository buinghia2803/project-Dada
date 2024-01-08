<template>
    <div class="main-signup">
        <h3>
            Sign up
        </h3>
        <hr class="line-title">
        <a class="btn-line-1 role-btn d-block" target="_blank" href="#">
            <span class="decoration-under">連携方法</span>
            <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M5.83333 2.5V4.16667H1.66667V13.3333H10.8333V9.16667H12.5V14.1667C12.5 14.3877 12.4122 14.5996 12.2559 14.7559C12.0996 14.9122 11.8877 15 11.6667 15H0.833333C0.61232 15 0.400358 14.9122 0.244078 14.7559C0.0877973 14.5996 0 14.3877 0 14.1667V3.33333C0 3.11232 0.0877973 2.90036 0.244078 2.74408C0.400358 2.5878 0.61232 2.5 0.833333 2.5H5.83333ZM15 0V6.66667H13.3333V2.84417L6.83917 9.33917L5.66083 8.16083L12.1542 1.66667H8.33333V0H15Z"
                    fill="black"/>
            </svg>
        </a>

        <a class="btn-line-2 role-btn d-block" target="_blank" href="#">
            <span class="decoration-under">登録方法</span>
            <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M5.83333 2.5V4.16667H1.66667V13.3333H10.8333V9.16667H12.5V14.1667C12.5 14.3877 12.4122 14.5996 12.2559 14.7559C12.0996 14.9122 11.8877 15 11.6667 15H0.833333C0.61232 15 0.400358 14.9122 0.244078 14.7559C0.0877973 14.5996 0 14.3877 0 14.1667V3.33333C0 3.11232 0.0877973 2.90036 0.244078 2.74408C0.400358 2.5878 0.61232 2.5 0.833333 2.5H5.83333ZM15 0V6.66667H13.3333V2.84417L6.83917 9.33917L5.66083 8.16083L12.1542 1.66667H8.33333V0H15Z"
                    fill="black"/>
            </svg>

        </a>
        <div class="fw-bold txt-head">
            DadAを使用するにはMETAMASKのアカウントが必要です。
        </div>


        <div class="box-info-note fw-bold">
            <p class="fw-bold">重要</p>
            <span>シークレットリカバリーフレーズを無くすと二度とログインできなくなります。また、他人に決して知られないように厳重に保管してください。</span>
        </div>

        <a class="btn-line-3 fw-bold role-btn d-block" target="_blank" href="#">
            <span class="decoration-under">シークレットリカバリーフレーズとは</span>
            <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M5.83333 2.5V4.16667H1.66667V13.3333H10.8333V9.16667H12.5V14.1667C12.5 14.3877 12.4122 14.5996 12.2559 14.7559C12.0996 14.9122 11.8877 15 11.6667 15H0.833333C0.61232 15 0.400358 14.9122 0.244078 14.7559C0.0877973 14.5996 0 14.3877 0 14.1667V3.33333C0 3.11232 0.0877973 2.90036 0.244078 2.74408C0.400358 2.5878 0.61232 2.5 0.833333 2.5H5.83333ZM15 0V6.66667H13.3333V2.84417L6.83917 9.33917L5.66083 8.16083L12.1542 1.66667H8.33333V0H15Z"
                    fill="black"/>
            </svg>
        </a>


        <ConnectMetamask/>
    </div>
</template>

<script>

export default {
    name: 'signup',
    layout: "login",
    middleware: ['isAuth'],
    components: {
        ConnectMetamask: () => import('~/components/custom/ConnectMetamask.vue'),
    },
    data() {
        return {};
    },
    methods: {},
}
</script>

<style lang="less">
.main-signup {
    text-align: center;
    margin-top: 24px;

    .btn-line-1 {
        margin-top: 40px;
        color: black;
    }

    .btn-line-2 {
        margin-top: 8px;
        color: black;
    }

    .txt-head {
        margin-top: 32px;
        font-weight: 500;
        font-size: 20px;
        margin-bottom: 16px;
    }

    h3 {
        font-size: 32px;
        font-weight: bold;
        letter-spacing: 0.02em;
        margin-bottom: 0;
    }

    .box-info-note {
        border-radius: 6px;
        color: #FF0000;
        background: #FFE6E6;
        max-width: 544px;
        margin: 0 auto;
        padding: 24px 16px;

        p {
            margin-top: 0px;
        }
    }

    .btn-line-3 {
        margin-top: 16px;
        color: black;
        margin-bottom: 39px;
    }
}

@media (max-width: 567px) {
    .main-signup {
        margin-top: 16px;

        .btn-line-1 {
            margin-top: 40px;
            color: black;
        }

        .btn-line-2 {
            margin-top: 8px;
        }

        .txt-head {
            width: calc(100% - 36px);
            margin: 0 auto;
            margin-top: 32px;
            font-size: 16px;
        }

        .box-info-note {
            width: 288px;
            font-size: 14px;
        }

        .btn-line-3 {
            margin-top: 8px;
        }

        .cn-metamask {
            margin-top: 48px;
        }
    }
}
</style>
