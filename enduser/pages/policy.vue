<template>
    <div class="main-policy">
        <div class="box-head-action">
            <div class="first-child role-btn" @click="() => this.$router.go(-1)">
                <svg class="role-btn" width="13" height="19" viewBox="0 0 13 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M4.7915 9.49958L12.0103 16.7183L9.94817 18.7804L0.667337 9.49958L9.94817 0.21875L12.0103 2.28083L4.7915 9.49958Z"
                        fill="black"/>
                </svg>
            </div>
            <h3>プライバシーポリシー</h3>
            <div></div>
        </div>
        <hr class="line-title">
        <div class="warp-content">
            <div class="warp-policy-1">
                <a-card :title="'第1条'" :bordered="false" class="content-profile">
                    <p>
                        プライバシーポリシーが入ります。プライバシーポリシーが入ります。プライバシーポリシーが入ります。プライバシーポリシーが入ります。プライバシーポリシーが入ります。プライバシーポリシーが入ります。プライバシーポリシーが入ります。プライバシーポリシーが入ります。</p>
                </a-card>
            </div>
            <div class="warp-policy-2">
                <a-card :title="'第2条'" :bordered="false" class="content-profile">
                    <p>
                        プライバシーポリシーが入ります。プライバシーポリシーが入ります。プライバシーポリシーが入ります。プライバシーポリシーが入ります。プライバシーポリシーが入ります。プライバシーポリシーが入ります。プライバシーポリシーが入ります。プライバシーポリシーが入ります。</p>
                </a-card>
            </div>
            <div class="warp-policy-3">
                <a-card :title="'第3条'" :bordered="false" class="content-profile">
                    <p>
                        プライバシーポリシーが入ります。プライバシーポリシーが入ります。プライバシーポリシーが入ります。プライバシーポリシーが入ります。プライバシーポリシーが入ります。プライバシーポリシーが入ります。プライバシーポリシーが入ります。プライバシーポリシーが入ります。</p>
                </a-card>
            </div>
        </div>

    </div>
</template>

<script>

export default {
    layout: "mainNo",
    // middleware: 'authenticated',
    components: {},
    data() {
        return {};
    },

    methods: {
    }
};
</script>

<style lang="less">

hr {
    margin-bottom: 40px;
}

.warp-content {
    padding: 16px;

    .ant-card-head {
        border-bottom: 1px solid black;
        font-size: 16px;
        width: 50%;
        padding: 0;
        min-height: unset;
        border-bottom: 2px solid black;

        .ant-card-head-title {
            padding: 0;
            font-size: 16px;
            font-weight: bold;
        }
    }

    .ant-card-body {
        padding: 16px 0;
    }
}

@media (max-width: 567px) {
    .box-head-action {
        svg {
            margin-right: 16px;
        }
    }
    .warp-content {
        width: 100%;
    }
}
</style>

