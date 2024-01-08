<template>
    <div class="info-block-3">
        <h2 id="get-started">DadAのはじめ方</h2>

        <div class="d-card-info">
            <a-col v-for="(item, index) of items" :key="index">
                <a-card hoverable :class="['d-card-item', `d-item-index-${index}`]">
                    <template #cover>
                        <img alt="example"
                             :src="require(`~/assets/images/${item.img}`)"
                        />
                    </template>
                    <a-card-meta>
                        <template #title>
                            <p class="m-0 fw-bold text-center title-b3">{{ item.title }}</p>
                        </template>
                        <template #description>
                            <p class="m-0">{{ item.description }}</p>
                        </template>
                    </a-card-meta>
                </a-card>
            </a-col>
        </div>
    </div>
</template>

<script>


export default {
    name: 'InfoBlock3',
    auth: false,
    data() {
        return {
            items: [
                {
                    img: 'dad-block-1.svg',
                    title: 'Dadから契約依頼が送られてくる',
                }, {
                    img: 'dad-block-2.svg',
                    title: '直接やりとりをして契約内容を確定',
                }, {
                    img: 'dad-block-3.svg',
                    title: 'DadAを利用して作品をアップロードする',
                }, {
                    img: 'dad-block-4.svg',
                    title: '売り上げた際に自動的に配当が入金されます',
                },
            ]
        }
    },
    computed: {},
    methods: {},
    created() {
    }
}
</script>

<style lang="less" src="assets/less/user/top.less"></style>
