<template>
    <div class="info-block-4">
        <div class="d-content">
            <h2 id="faq">よくあるご質問 </h2>

            <a class="d-item-link d-flex d-item-link-hover" role="button" target="_blank" href="#">
                <span class="p-0">NFTとは？</span>
                <img alt="example" src="~/assets/images/c-open-tab.svg">
            </a>
            <a class="d-item-link d-flex d-item-link-hover" role="button" target="_blank" href="#">
                <span class="p-0">アップロードするのに準備することって？</span>
                <img alt="example" src="~/assets/images/c-open-tab.svg">
            </a>
            <a class="d-item-link d-flex d-item-link-hover d-last-b4" role="button" target="_blank" href="#">
                <span class="p-0">気をつけなきゃいけないことって？</span>
                <img alt="example" src="~/assets/images/c-open-tab.svg">
            </a>
        </div>
    </div>
</template>

<script>


export default {
    name: 'InfoBlock4',
    auth: false,
    data() {
        return {}
    },
    computed: {},
    methods: {},
    created() {
    }
}
</script>

<style lang="less" src="assets/less/user/top.less"></style>
