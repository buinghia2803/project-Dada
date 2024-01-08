<template>
    <a-modal id="notify-not-enough"
             v-model="visibleNotEnough"
             title=""
             ok-text=""
             :closable="false"
             cancel-text=""
             :footer="null"
             :dialogClass="'box-not-enough'"
             :width="576"
             :maskClosable="false"
             :destroyOnClose="false"
    >
        <button type="button" aria-label="Close" class="ant-modal-close" @click="visibleNotEnoughClose">
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
        <div class="box-act-not-enough text-center">
            <div class="info-change-high">
                <p class="m-0 fw-bold">ガス代を払う仮想通貨が足りません</p>
            </div>
            <div class="info-change d-flex">
                <p class="m-0">DadAを使用するには、</p>
                <p class="m-0 ">ガス代として仮想通貨が必要です。</p>
                <p class="m-0">仮想通貨を購入してください。</p>
            </div>
            <div class="d-flex role-btn align-item-baseline justify-content-center mt-7 mb-2"
                 @click="redirectOther">
                <p class="m-0 pl-1 decoration-under">仮想通貨を購入する</p>
                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M4 2V3H1.5V8.5H7V6H8V9C8 9.13261 7.94732 9.25979 7.85355 9.35355C7.75979 9.44732 7.63261 9.5 7.5 9.5H1C0.867392 9.5 0.740215 9.44732 0.646447 9.35355C0.552678 9.25979 0.5 9.13261 0.5 9V2.5C0.5 2.36739 0.552678 2.24021 0.646447 2.14645C0.740215 2.05268 0.867392 2 1 2H4ZM9.5 0.5V4.5H8.5V2.2065L4.6035 6.1035L3.8965 5.3965L7.7925 1.5H5.5V0.5H9.5Z"
                        fill="black"/>
                </svg>
            </div>
        </div>
    </a-modal>
</template>

<script>

export default {
    name: "ModalNotEnough",
    data() {
        return {};
    },
    event: [
        'eventNotEnough'
    ],
    props: {
        visibleNotEnough: {
            type: Boolean,
            required: true
        }
    },
    methods: {
        redirectOther(payload) {

        },
        visibleNotEnoughClose(payload) {
            this.$emit('eventNotEnough', {})
        },
    }
};
</script>

<style lang="less" scoped>
.box-not-enough {
    .info-change-high {
        width: 288px;
        background: #FFD8D8;
        text-align: center;
        border-radius: 6px;
        margin: 16px auto 8px auto;

        p {
            padding: 16px;
            color: #FF0000;
        }
    }

    .info-change {
        margin-top: 32px;
        flex-direction: column;
        align-items: center;
        color: black;
    }
}
</style>
