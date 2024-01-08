<template>
    <div class="main-setting-notify">
        <a-spin :spinning="loading">
            <div class="box-head-action">
                <div class="first-child">
                    <svg class="role-btn" width="13" height="19" viewBox="0 0 13 19" fill="none"
                        xmlns="http://www.w3.org/2000/svg" @click="r2ToNews">
                        <path
                            d="M4.7915 9.49958L12.0103 16.7183L9.94817 18.7804L0.667337 9.49958L9.94817 0.21875L12.0103 2.28083L4.7915 9.49958Z"
                            fill="black" />
                    </svg>
                </div>
                <h3>通知の設定</h3>
                <div></div>
            </div>
            <hr class="line-title" />

            <div class="box-content-notify">
                <div class="item-line">
                    <div class="box-right">
                        <div class="title fw-bold">契約関係の通知のみ</div>
                        <div class="description">
                            契約の破棄や承認などの通知のみを許可します。
                        </div>
                    </div>
                    <div class="box-action-left">
                        <label class="switch">
                            <input type="checkbox" v-model="data.contract_notify" @change="submit" />
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
                <div class="item-line">
                    <div class="box-right">
                        <div class="title fw-bold">サービス情報の通知のみ</div>
                        <div class="description">
                            サービス情報の通知を許可します。
                        </div>
                    </div>
                    <div class="box-action-left">
                        <label class="switch">
                            <input type="checkbox" v-model="data.system_notify" @change="submit" />
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
            </div>
        </a-spin>
    </div>
</template>



<script>
import { mapActions } from "vuex";
import { SettingUserModel } from "@/services/modules/setting-user/SettingUserModel";

export default {
    layout: "main",
    components: {},
    data() {
        return {
            data: new SettingUserModel(),
            loading: false,
        };
    },

    mounted() {
        if (this.$auth.loggedIn) {
            this.getDataSetting();
        }
    },

    methods: {
        r2ToNews() {
            this.$router.push({ path: "/mypage/news" });
        },
        ...mapActions({
            getByUserId: "setting-user/getByUserId",
            getNotificationByUser: "setting-user/getNotificationByUser",
            actionAdd: "setting-user/actionAdd",
        }),

        /**
         * Get Data Setting User
         */
        getDataSetting() {
            this.loading = true;
            //   Call Api Setting User
            const user_id = this.$auth.user.id;
            this.getByUserId({ user_id })
                .then((res) => {
                    this.getNotificationByUser()
                    if (res && res.data && res.data.result && res.data.result.data) {
                        this.data = new SettingUserModel(res.data.result.data);
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        /**
         * Update Notify Setting User
         */
        submit() {
            this.loading = true;
            this.data.user_id = this.data.user_id || 1;
            //   Update and Add Contract Notify , System Notify
            this.actionAdd(this.data).finally(() => {
                this.loading = false;
                this.getDataSetting();
            });
        },
    },
};
</script>

<style lang="less">
.main-setting-notify {
    hr {
        width: 32px;
        text-align: center;
        margin-bottom: 40px;
    }
}

.box-content-notify {
    display: flex;
    justify-content: center;
    flex-direction: column;

    .item-line {
        display: inline-flex;
        align-self: center;
        width: 400px;

        .title {
            font-weight: 500;
            font-size: 16px;
            line-height: 23px;
            color: black;
        }

        .description {
            font-size: 12px;
            line-height: 17px;
            /* gray_border */
            color: #bcbcbc;
        }

        .box-right {
            width: calc(100% - 140px);
        }

        .box-action-left {
            justify-content: flex-end;
            width: 160px;
            display: flex;
        }

        &:not(:first-child) {
            margin-top: 32px;
        }
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;

        input[type="checkbox"] {
            height: 0;
            width: 0;
            visibility: hidden;
        }
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: 0.4s;
        transition: 0.4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: 0.4s;
        transition: 0.4s;
    }

    input:checked+.slider {
        //background-color: #2196F3;
        background-color: black;
    }

    input:focus+.slider {
        //box-shadow: 0 0 1px #2196F3;
        box-shadow: 0 0 1px black;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */

    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
}

@media (max-width: 567px) {
    .main-setting-notify {
        padding: 16px;

        .box-content-notify {
            .item-line {
                width: 100%;
            }
        }
    }
}
</style>

