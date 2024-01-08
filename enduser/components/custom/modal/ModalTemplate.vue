<template>
    <a-modal id="d-modal-template"
             v-model="visibleTemplate"
             title=""
             ok-text=""
             :closable="false"
             cancel-text=""
             :footer="null"
             :dialogClass="`box-${classTemplate}`"
             :width="widthTemplate"
             :maskClosable="false"
             :destroyOnClose="false"
    >
        <button type="button" aria-label="Close" :class="['ant-modal-close', `d-close-${classTemplate}`]"
                @click="visibleTemplateClose">
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
        <div :class="[`box-act-${classTemplate}`, classContentTemplate]">
            <slot name="content"></slot>
        </div>
    </a-modal>
</template>

<script>

export default {
    name: "ModalTemplate",
    data() {
        return {};
    },
    event: [
        'eventVisibleClose',
    ],
    props: {
        visibleTemplate: {
            type: Boolean,
            required: true
        },
        classTemplate: {
            type: String,
            required: false,
            default: 'modal-template'
        },
        classContentTemplate: {
            type: String,
            required: false,
            default: 'modal-content-template'
        },
        widthTemplate: {
            type: Number,
            required: false,
            default: 576
        }
    },
    methods: {
        visibleTemplateClose(payload) {
            this.$emit('eventVisibleClose', payload)
        },
    }
};
</script>

<style lang="less">
.box-modal-template {
    .box-cancel-content-done {
        height: 124px;

        .box-cancel-offer-done {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
    }
}
</style>
