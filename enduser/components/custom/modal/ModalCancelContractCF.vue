<template>
    <a-modal id="notify-cancel-contract"
             v-model="visibleCancelContract"
             title=""
             ok-text=""
             :closable="false"
             cancel-text=""
             :footer="null"
             :dialogClass="'box-cancel-contract'"
             :width="318"
             :maskClosable="false"
             :destroyOnClose="false"
    >
        <button type="button" aria-label="Close" class="ant-modal-close" @click="clickCancelContract('No')">
                <span class="ant-modal-close-x">
                    <i aria-label="icon: close" class="anticon anticon-close ant-modal-close-icon">
                        <svg viewBox="64 64 896 896" data-icon="close" width="1em" height="1em" fill="currentColor"
                             aria-hidden="true" focusable="false" class="">
                            <path
                                d="M563.8 512l262.5-312.9c4.4-5.2.7-13.1-6.1-13.1h-79.8c-4.7 0-9.2 2.1-12.3 5.7L511.6 449.8 295.1 191.7c-3-3.6-7.5-5.7-12.3-5.7H203c-6.8 0-10.5 7.9-6.1 13.1L459.4 512 196.9 824.9A7.95 7.95 0 0 0 203 838h79.8c4.7 0 9.2-2.1 12.3-5.7l216.5-258.1 216.5 258.1c3 3.6 7.5 5.7 12.3 5.7h79.8c6.8 0 10.5-7.9 6.1-13.1L563.8 512z"></path>
                        </svg>
                    </i>
                </span>
        </button>
        <div class="box-guideline-act-notify text-center">
            <div class="icon-change">
                <p class="m-0 fw-bold">本当に契約を破棄しますか？</p>
                <p class="m-0">※この操作は戻ることができません。</p>
            </div>

            <div class="btn-action-offer-act">
                <a-config-provider :autoInsertSpaceInButton="false">
                    <a-button class="bg-discard-txt-gray mr-1" @click="clickCancelContract('No')">
                        いいえ
                    </a-button>
                </a-config-provider>
                <a-config-provider :autoInsertSpaceInButton="false">
                    <a-button class="bg-cancel-txt-white ml-1" @click="clickYesContract">
                        破棄する
                    </a-button>
                </a-config-provider>
            </div>
        </div>
    </a-modal>
</template>

<script>

export default {
    name: "ModalCancelContractCF",
    data() {
        return {};
    },
    event: [
        'eventCancelContract',
        'eventYesContract'
    ],
    props: {
        visibleCancelContract: {
            type: Boolean,
            required: true
        }
    },
    methods: {
        clickYesContract() {
            this.$emit('eventYesContract', {act: 'Yes'})
        },
        clickCancelContract(act) {
            this.$emit('eventCancelContract', {act: act})
        },
    }
};
</script>

<style lang="less" scoped>
.box-cancel-contract {
    margin: 16px auto;
    text-align: center;

    .box-guideline-act-notify {
        margin-top: 8px;
        text-align: center;
    }

    .btn-action-offer-act {
        .ant-btn {
            height: unset;
            margin-top: 16px;
            padding: 8px 24px;
        }
    }
}
</style>
