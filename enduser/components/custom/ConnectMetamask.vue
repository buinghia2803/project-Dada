<template>
    <div class="cn-metamask">
        <div class="line-1">
            以下のボタンからアカウント連携を行ってください。
        </div>
        <div class="role-btn btn-metamask" @click="login">
            <svg width="26" height="27" viewBox="0 0 26 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M24.1551 1L14.6387 9.125L16.4083 4.33667L24.1551 1Z" fill="#E17726" stroke="#E17726"
                      stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M2.20508 1L11.6367 9.20083L9.95185 4.33667L2.20508 1Z" fill="#E27625" stroke="#E27625"
                      stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M20.7293 19.8389L18.1973 24.3022L23.6191 26.0247L25.1722 19.9364L20.7293 19.8389Z"
                      fill="#E27625" stroke="#E27625" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M1.19727 19.9364L2.74097 26.0247L8.15336 24.3022L5.63071 19.8389L1.19727 19.9364Z"
                      fill="#E27625" stroke="#E27625" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M7.86152 12.2992L6.35547 14.9209L11.7208 15.2025L11.5419 8.54004L7.86152 12.2992Z"
                      fill="#E27625" stroke="#E27625" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M18.4979 12.2989L14.761 8.46387L14.6387 15.2022L20.004 14.9205L18.4979 12.2989Z" fill="#E27625"
                      stroke="#E27625" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M8.1543 24.303L11.4017 22.4938L8.60611 19.9805L8.1543 24.303Z" fill="#E27625" stroke="#E27625"
                      stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M14.959 22.4938L18.197 24.303L17.7546 19.9805L14.959 22.4938Z" fill="#E27625" stroke="#E27625"
                      stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M18.195 24.3023L14.957 22.4932L15.2206 24.9198L15.1924 25.949L18.195 24.3023Z" fill="#D5BFB2"
                      stroke="#D5BFB2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M8.15234 24.3023L11.1645 25.949L11.1456 24.9198L11.3998 22.4932L8.15234 24.3023Z"
                      fill="#D5BFB2" stroke="#D5BFB2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M11.2214 18.3765L8.5293 17.4665L10.4307 16.459L11.2214 18.3765Z" fill="#233447"
                      stroke="#233447" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M15.1387 18.3765L15.9293 16.459L17.8402 17.4665L15.1387 18.3765Z" fill="#233447"
                      stroke="#233447" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M8.15155 23.3022L8.62219 18.8389L5.62891 18.9364L8.15155 23.3022Z" fill="#CC6228"
                      stroke="#CC6228" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M17.7344 18.8389L18.1956 23.3022L20.7277 18.9364L17.7344 18.8389Z" fill="#CC6228"
                      stroke="#CC6228" stroke-linecap="round" stroke-linejoin="round"/>
                <path
                    d="M20.002 13.9209L14.6367 14.2026L15.1356 17.3767L15.9263 15.4592L17.8371 16.4667L20.002 13.9209Z"
                    fill="#CC6228" stroke="#CC6228" stroke-linecap="round" stroke-linejoin="round"/>
                <path
                    d="M8.52788 16.4667L10.4293 15.4592L11.22 17.3767L11.7188 14.2026L6.35352 13.9209L8.52788 16.4667Z"
                    fill="#CC6228" stroke="#CC6228" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M6.35547 14.9209L8.60514 19.9801L8.52984 17.4667L6.35547 14.9209Z" fill="#E27525"
                      stroke="#E27525" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M17.8386 17.4667L17.7539 19.9801L20.0036 14.9209L17.8386 17.4667Z" fill="#E27525"
                      stroke="#E27525" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M11.7196 15.2021L11.2207 18.3763L11.8514 22.1246L11.9926 17.1846L11.7196 15.2021Z"
                      fill="#E27525" stroke="#E27525" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M14.6386 15.2021L14.375 17.1738L14.5068 22.1246L15.1374 18.3763L14.6386 15.2021Z"
                      fill="#E27525" stroke="#E27525" stroke-linecap="round" stroke-linejoin="round"/>
                <path
                    d="M15.1385 18.3768L14.5078 22.1251L14.9596 22.4935L17.7552 19.9801L17.84 17.4668L15.1385 18.3768Z"
                    fill="#F5841F" stroke="#F5841F" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M8.5293 17.4668L8.6046 19.9801L11.4002 22.4935L11.852 22.1251L11.2214 18.3768L8.5293 17.4668Z"
                      fill="#F5841F" stroke="#F5841F" stroke-linecap="round" stroke-linejoin="round"/>
                <path
                    d="M14.9587 22.4933L14.5069 22.125H11.8524L11.4006 22.4933L11.1465 24.92L11.3818 24.6817H14.9775L15.2222 24.92L14.9587 22.4933Z"
                    fill="#161616" stroke="#161616" stroke-linecap="round" stroke-linejoin="round"/>
                <path
                    d="M24.5601 9.65583L25.3602 5.17083L24.1553 1L14.959 8.85417L18.4982 12.2992L23.4964 13.9783L24.5977 12.4942L24.1177 12.0933L24.8801 11.2917L24.2965 10.7717L25.059 10.1L24.5601 9.65583Z"
                    fill="#763E1A" stroke="#763E1A" stroke-linecap="round" stroke-linejoin="round"/>
                <path
                    d="M1 5.17083L1.8095 9.65583L1.2918 10.1L2.06365 10.7717L1.48005 11.2917L2.24249 12.0933L1.76244 12.4942L2.86374 13.9783L7.86196 12.2992L11.4012 8.85417L2.20484 1L1 5.17083Z"
                    fill="#763E1A" stroke="#763E1A" stroke-linecap="round" stroke-linejoin="round"/>
                <path
                    d="M23.4977 13.978L18.4995 12.2988L20.0055 14.9205L17.7559 19.9797L20.7303 19.9363H25.1732L23.4977 13.978Z"
                    fill="#F5841F" stroke="#F5841F" stroke-linecap="round" stroke-linejoin="round"/>
                <path
                    d="M7.86156 12.2988L2.86334 13.978L1.19727 19.9363H5.63071L8.60517 19.9797L6.3555 14.9205L7.86156 12.2988Z"
                    fill="#F5841F" stroke="#F5841F" stroke-linecap="round" stroke-linejoin="round"/>
                <path
                    d="M14.6407 15.2027L14.9608 8.85441L16.4103 4.33691H9.95312L11.4027 8.85441L11.7227 15.2027L11.8451 17.1961L11.8545 22.1252H14.5089L14.5184 17.1961L14.6407 15.2027Z"
                    fill="#F5841F" stroke="#F5841F" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="fw-bold">METAMASK</span>
        </div>
        <a class="role-btn line-2 d-block" target="_blank" href="#">
            <span class="decoration-under">アカウント連携にお困りの方はこちら</span>
            <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M5.83333 2.5V4.16667H1.66667V13.3333H10.8333V9.16667H12.5V14.1667C12.5 14.3877 12.4122 14.5996 12.2559 14.7559C12.0996 14.9122 11.8877 15 11.6667 15H0.833333C0.61232 15 0.400358 14.9122 0.244078 14.7559C0.0877973 14.5996 0 14.3877 0 14.1667V3.33333C0 3.11232 0.0877973 2.90036 0.244078 2.74408C0.400358 2.5878 0.61232 2.5 0.833333 2.5H5.83333ZM15 0V6.66667H13.3333V2.84417L6.83917 9.33917L5.66083 8.16083L12.1542 1.66667H8.33333V0H15Z"
                    fill="black"/>
            </svg>
        </a>

    </div>
</template>

<script>
import {mapActions} from "vuex";
import {VUE_APP_URL_END_USER} from "~/utils/constants";

const Cookie = process.client ? require("js-cookie") : undefined;

export default {
    middleware: "notAuthenticated",
    name: 'cnMetamask',
    components: {},
    data() {
        return {
            form: {}
        }
    },

    methods: {
        ...mapActions('forgot-password', ['loginUser']),
        async login() {
            if (window.ethereum) {
                if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                    window.open("https://metamask.app.link/dapp/" + VUE_APP_URL_END_USER)
                    // document.location.href = "https://metamask.app.link/dapp/"+process.env.VUE_APP_URL_END_USER
                }
                try {
                    const account = await window.ethereum.request({method: 'eth_requestAccounts'})
                    this.form.public_address_main = account[0]
                    const {state} = this;
                    // state.loginBtn = true;
                    this.$auth
                        .loginWith("local", {data: this.form})
                        .then(data => {
                            // state.loginBtn = false;
                            Cookie.set('auth_user', true)
                            this.$router.push({path: '/mypage'}).catch(()=>{});
                        })
                        .catch(e => {
                            Cookie.set('auth_user', false)
                        });
                } catch (error) {
                    console.error('Connect metamask::Fall', error)
                }
            } else {
                console.info('meta mask not detected')
            }
        }
    }
}
</script>

<style lang="less" scoped>
.cn-metamask {
    .line-1 {
        font-weight: 400;
        font-size: 16px;
        line-height: 23px;
        margin-bottom: 16px;
    }

    .line-2 {
        font-size: 16px;
        line-height: 23px;
        margin-top: 16px;
        color: black;
    }

    .btn-metamask {
        text-align: start;
        border: 1px solid black;
        background: #FFFFFF;
        width: 544px;
        border-radius: 6px;
        margin: 0 auto;
        padding: 14px 0;
        display: flex;

        svg {
            margin-left: 20px;
        }

        span {
            margin-left: 15px;
            letter-spacing: 3px;
            font-size: 18px;
            align-self: center;
        }
    }
}

@media (max-width: 567px) {
    .cn-metamask {
        margin-top: 110px;

        .btn-metamask {
            width: calc(100% - 36px);
            margin: 0 auto;
        }

        .line-1,
        .line-2 {
            font-size: 12px;
            width: calc(100% - 36px);
            margin: 0 auto;
        }

        .line-1 {
            margin-bottom: 16px;
        }

        .line-2 {
            margin-top: 16px;
        }
    }
}
</style>
