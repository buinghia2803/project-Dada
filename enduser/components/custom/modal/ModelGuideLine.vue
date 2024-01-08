<template>
    <div>
        <a-modal id="change-gl"
                 v-if="visibleGuideline"
                 v-model="visibleGuideline"
                 title=""
                 ok-text=""
                 cancel-text=""
                 :footer="null"
                 :dialogClass="'box-guideline-change'"
                 :width="318"
                 :closable="false"
                 :maskClosable="false"
                 :destroyOnClose="false"
        >
            <button type="button" aria-label="Close" class="ant-modal-close" @click="afterCloseChange">
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
            <div class="box-guideline-change-role">
                <div class="icon-change d-flex">
                    <svg width="41" height="32" viewBox="0 0 41 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M13.9443 13H11.7773L11.791 11.4004H13.9443C14.4821 11.4004 14.9355 11.2796 15.3047 11.0381C15.6738 10.792 15.9518 10.4342 16.1387 9.96484C16.3301 9.49544 16.4258 8.92806 16.4258 8.2627V7.77734C16.4258 7.26693 16.3711 6.81803 16.2617 6.43066C16.1569 6.04329 15.9997 5.71745 15.79 5.45312C15.5804 5.1888 15.3229 4.99056 15.0176 4.8584C14.7122 4.72168 14.3613 4.65332 13.9648 4.65332H11.7363V3.04688H13.9648C14.6302 3.04688 15.2386 3.16081 15.79 3.38867C16.346 3.61198 16.8268 3.93327 17.2324 4.35254C17.638 4.77181 17.9502 5.27311 18.1689 5.85645C18.3923 6.43522 18.5039 7.08008 18.5039 7.79102V8.2627C18.5039 8.96908 18.3923 9.61393 18.1689 10.1973C17.9502 10.7806 17.638 11.2819 17.2324 11.7012C16.8314 12.1159 16.3506 12.4372 15.79 12.665C15.234 12.8883 14.6188 13 13.9443 13ZM12.9395 3.04688V13H10.8887V3.04688H12.9395Z"
                            fill="black"/>
                        <path
                            d="M34.0508 10.2129L30.1836 22H27.0684L32.3516 7.78125H34.334L34.0508 10.2129ZM37.2637 22L33.3867 10.2129L33.0742 7.78125H35.0762L40.3887 22H37.2637ZM37.0879 16.707V19.002H29.5781V16.707H37.0879Z"
                            fill="black"/>
                        <path
                            d="M14.625 12L25.875 20L14.625 28V23C8.41162 23 3.375 18.523 3.375 13C3.375 12.727 3.38625 12.457 3.411 12.19C5.1075 15.05 8.48475 17 12.375 17H14.625V12Z"
                            fill="black"/>
                    </svg>
                    <svg width="41" height="32" viewBox="0 0 41 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M32.6348 22H29.5391L29.5586 19.7148H32.6348C33.403 19.7148 34.0508 19.5423 34.5781 19.1973C35.1055 18.8457 35.5026 18.3346 35.7695 17.6641C36.043 16.9935 36.1797 16.1829 36.1797 15.2324V14.5391C36.1797 13.8099 36.1016 13.1686 35.9453 12.6152C35.7956 12.0618 35.571 11.5964 35.2715 11.2188C34.972 10.8411 34.6042 10.5579 34.168 10.3691C33.7318 10.1738 33.2305 10.0762 32.6641 10.0762H29.4805V7.78125H32.6641C33.6146 7.78125 34.4837 7.94401 35.2715 8.26953C36.0658 8.58854 36.7526 9.04753 37.332 9.64648C37.9115 10.2454 38.3574 10.9616 38.6699 11.7949C38.9889 12.6217 39.1484 13.543 39.1484 14.5586V15.2324C39.1484 16.2415 38.9889 17.1628 38.6699 17.9961C38.3574 18.8294 37.9115 19.5456 37.332 20.1445C36.7591 20.737 36.0723 21.196 35.2715 21.5215C34.4772 21.8405 33.5983 22 32.6348 22ZM31.1992 7.78125V22H28.2695V7.78125H31.1992Z"
                            fill="black"/>
                        <path
                            d="M14.9355 4.74902L12.2285 13H10.0479L13.7461 3.04688H15.1338L14.9355 4.74902ZM17.1846 13L14.4707 4.74902L14.252 3.04688H15.6533L19.3721 13H17.1846ZM17.0615 9.29492V10.9014H11.8047V9.29492H17.0615Z"
                            fill="black"/>
                        <path
                            d="M14.625 12L25.875 20L14.625 28V23C8.41162 23 3.375 18.523 3.375 13C3.375 12.727 3.38625 12.457 3.411 12.19C5.1075 15.05 8.48475 17 12.375 17H14.625V12Z"
                            fill="black"/>
                    </svg>
                </div>
                <div class="content-guide">
                    アイコンでDadとArtistの切り替えができます。
                </div>
            </div>
        </a-modal>

        <a-modal id="notify-gl"
                 v-else-if="visibleGuideNotify"
                 v-model="visibleGuideNotify"
                 title=""
                 ok-text=""
                 :closable="false"
                 cancel-text=""
                 :footer="null"
                 :dialogClass="'box-guideline-notify'"
                 :width="318"
                 :maskClosable="false"
                 :destroyOnClose="false"
        >
            <button type="button" aria-label="Close" class="ant-modal-close" @click="afterCloseNotify">
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
            <div class="box-guideline-change-notify text-center">
                <div class="icon-change">
                    <p class="m-0">おめでとうございます</p>
                    <p class="m-0">契約完了です</p>
                </div>
                <div class="content-guide mt-4">
                    <p class="m-0">契約内容が承認されました</p>
                    <a class="d-block" href="#">投稿作品を見る</a>
                    <a class="d-block" href="#">myページへ</a>
                </div>
            </div>
        </a-modal>
    </div>
</template>

<script>

export default {
    name: 'ModelGuideLine',
    data() {
        return {
            visibleGuideline: false, // Todo check first show page
            visibleGuideNotify: false, // Todo check first show page
        }
    },
    mounted() {
        this.$nextTick(() => {
            Promise.resolve().then(async () => {
                const gLchange = await localStorage.getItem('gLchange')
                this.visibleGuideline = !gLchange
                if (gLchange) {
                    return true
                }
                return;
            }).then(async res => {
                if (res) {
                    const gNchange = await localStorage.getItem('gNchange')
                    this.visibleGuideNotify = !gNchange
                }
            })
        })
    },
    methods: {
        async afterCloseChange() {

            await localStorage.setItem('gLchange', 1)
            this.$nextTick(() => {
                const gNchange = localStorage.getItem('gNchange')
                this.visibleGuideNotify = !gNchange
            })
            this.visibleGuideline = false
        },
        async afterCloseNotify() {
            this.visibleGuideNotify = false
            await localStorage.setItem('gNchange', 1)
        }
    }
}
</script>

<style lang="less">
.text-center {
    text-align: center;
}

@media (max-width: 567px) {
    .box-guideline-change,
    .box-guideline-notify {
        right: -5%;
        top: 40px;
    }
}
</style>
