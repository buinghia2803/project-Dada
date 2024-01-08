<template>
    <div class="main-art">
        <div class="box-head-action-left">
            <svg class="f-left mb-2 role-btn" width="13" height="19" viewBox="0 0 13 19" fill="none"
                 xmlns="http://www.w3.org/2000/svg"
                 @click="redirectDetailIndex">
                <path
                    d="M4.79102 9.49958L12.0098 16.7183L9.94768 18.7804L0.666848 9.49958L9.94768 0.21875L12.0098 2.28083L4.79102 9.49958Z"
                    fill="black"/>
            </svg>
        </div>
        <div class="warp-art">
            <div class="wrap-art">
                <img src="~/assets/images/logo.png" alt="avatar">
            </div>
            <a-card :bordered="false" class="content-art">
                <div class="box-c1">
                    <div class="c1-right">
                        <div>
                            <span>Artist：shou_morimoto</span>
                            <span class="dad">Dad：morimoto</span>
                        </div>
                        <div class="metamask-id">MetamaskID：0000000000000000</div>
                    </div>
                    <div class="c1-action">
                        <a-config-provider :autoInsertSpaceInButton="false">
                            <a-button class="action-art">編集</a-button>
                        </a-config-provider>
                        <p class="m-0">契約を破棄する</p>
                    </div>
                </div>

                <div class="box-c2">
                    <div class="title">Jade VIP Access Pass</div>
                </div>

                <div class="box-c2">
                    <div class="">契約期間</div>
                    <div class="">2021.05.12 ~ 2021.05.12</div>
                </div>
                <div class="box-cmore">
                    <div class="role-btn" @click="showMore = !showMore">
                        <span>詳細</span>
                        <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg"
                             v-if="showMore">
                            <path
                                d="M5.00019 2.21856L1.70019 5.51856L0.757524 4.57589L5.00019 0.333222L9.24286 4.57589L8.30019 5.51855L5.00019 2.21856Z"
                                fill="black"/>
                        </svg>
                        <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg"
                             v-else>
                            <path
                                d="M4.99981 3.78145L8.29981 0.481445L9.24248 1.42411L4.99981 5.66678L0.757141 1.42411L1.69981 0.481445L4.99981 3.78145Z"
                                fill="black"/>
                        </svg>

                    </div>
                </div>

                <div class="more-detail" v-if="showMore">
                    <div class="process-pre">
                        <div class="pre-1"></div>
                        <div class="pre-2"></div>
                        <div class="pre-3"></div>
                    </div>
                    <div class="note-process-pre d-flex">
                        <div class="note-pre-1"><span>Artist</span></div>
                        <div class="note-pre-2"><span>Dad</span></div>
                        <div class="note-pre-3"><span>システム手数料</span></div>
                    </div>

                    <div class="content-items-art">
                        <div class="items">
                            <p class="m-0 d-date">販売価格</p>
                            <div class="m-0 content">
                                <img src="~/assets/images/c-eth.svg" alt="eth">
                                <span>1.0</span>
                            </div>
                        </div>
                        <div class="items">
                            <p class="m-0 d-date">配当金</p>
                            <div class="m-0 content">
                                <img src="~/assets/images/c-eth.svg" alt="eth">
                                <span>0.7</span>
                            </div>
                        </div>
                        <div class="items">
                            <p class="m-0 d-date">販売配当率</p>
                            <div class="m-0 content">
                                <span>70%</span>
                            </div>
                        </div>
                        <div class="items">
                            <p class="m-0 d-date">相手の配当率</p>
                            <div class="m-0 content">
                                <span>30%</span>
                            </div>
                        </div>
                        <div class="items">
                            <p class="m-0 d-date">システム手数料</p>
                            <div class="m-0 content">
                                <span>30%</span>
                            </div>
                        </div>
                        <div class="items">
                            <p class="m-0 d-date">ガス代</p>
                            <div class="m-0 content">
                                <img src="~/assets/images/c-eth.svg" alt="eth">
                                <span>0.03</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="btn-action-upload-work mt-3">
                    <a-config-provider :autoInsertSpaceInButton="false">
                        <a-button class="bg-green-txt-white mr-1" @click="visibleUploadWork = true">
                            作品をアップロードする
                        </a-button>
                    </a-config-provider>
                </div>
            </a-card>
        </div>

        <ModalUploadWork :visibleUploadWork="visibleUploadWork" @eventUploadWork="funcUploadWork"/>
    </div>
</template>

<script>

export default {
    layout: "main",
    components: {
        ModalUploadWork: () => import('~/components/custom/modal/ModalUploadWork.vue'),
    },
    validate({params}) {
        return params.id && !!params.id.length
    },
    data() {
        return {
            showMore: false,
            role: 'dad', // art, dad
            visibleUploadWork: false
        };
    },

    methods: {
        redirectDetailIndex(payload) {
            this.$router.push({path: '/mypage'})
        },
        funcUploadWork(payload) {
            this.visibleUploadWork = false
        },
    }
};
</script>

<style lang="less" scoped>
.main-art {
    margin: 20px auto;

    .box-head-action-left {
        margin-bottom: 32px;
    }
}

.warp-art {
    width: 100%;
    display: flex;
    justify-content: center;

    .wrap-art {
        width: 50%;
        display: flex;
        justify-content: center;

        img {
            max-width: 500px;
            width: calc(100% - 56px);
            height: 583px;
            //object-fit: cover;
            //padding-right: 32px;
        }
    }

    .ant-card-body {
        width: calc(50% - 24px);
        min-width: 343px;
        padding: 0 0;

        .box-c1 {
            display: flex;
            justify-content: space-around;

            .dad {
                margin-left: 10px;
            }

            .metamask-id {
                font-size: 12px;
                padding-top: 8px;
            }

            .c1-action {
                margin-left: 20px;

                .action-art {
                    font-size: 14px;
                    padding: 8px 16px;
                    height: auto;
                    align-self: flex-end;
                    border: 1px solid #00E600;
                }

                p {
                    padding-top: 8px;
                    font-size: 10px;
                }

            }
        }

        .box-c2 {
            font-size: 16px;

            .title {
                font-weight: bold;
                font-size: 20px;
                padding-top: 4px;
            }

            padding: 4px 0 8px 0;

            div {
                padding: 4px 0;
            }
        }
    }

    .box-cmore {
        font-size: 16px;
        margin-bottom: 8px;

        span {
            margin-right: 8px;
        }
    }

    .more-detail {
        .process-pre {
            width: 100%;
            height: 34px;
            display: inline-flex;
            background: #EEEEEE;
            border-radius: 0 6px 6px 0;

            .pre-1 {
                background: black;
                width: 70%;
                height: auto;
                border-radius: 6px 0 0 6px;
            }

            .pre-2 {
                background: #959595;
                width: 24%;
            }

            .pre-3 {
            }
        }

        .note-process-pre {
            .note-pre-1,
            .note-pre-2,
            .note-pre-3 {
                &:before {
                    content: '';
                    width: 11px;
                    height: 11px;
                    padding-left: 15px;
                    border-radius: 50%;
                }

                span {
                    padding: 0 16px 0 8px;
                }
            }

            .note-pre-1 {
                &:before {
                    background: black;
                }
            }

            .note-pre-2 {
                &:before {
                    background: #959595;
                }
            }

            .note-pre-3 {
                &:before {
                    background: #EEEEEE;
                }
            }
        }
    }

    .content-items-art {
        margin-top: 16px;
        display: flex;
        justify-content: space-around;
        flex-direction: column;

        .items {
            flex-direction: row;
            display: flex;
            justify-content: space-between;
            padding: 16px 0;
            border-bottom: 1px solid #E6E9EC;
            font-size: 16px;

            .content {
                span {
                    padding-left: 8px;
                }
            }
        }
    }
}

@media (max-width: 567px) {
    .main-art {
        margin-top: 24px;

        .warp-art {
            display: block;

            .wrap-art {
                display: block;
                width: 100%;

                img {
                    width: 100%;
                    max-width: unset;
                }
            }
        }

        .ant-card-body {
            padding: 16px;
            width: 100%;

            .box-c1 {
                margin-top: 16px;
            }
        }
    }
}
</style>
