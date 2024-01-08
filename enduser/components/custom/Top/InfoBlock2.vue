<template>
    <div class="info-block-2">
        <div class="d-content">
            <h2 id="problem-solved">DadAが解決する課題 </h2>

            <div class="d-card-info d-flex flex-wrap">
                <a-col v-for="(item, index) of items" :key="index">
                    <a-card hoverable class="d-card-item">
                        <template #cover>
                            <img alt="example"
                                 :src="require(`~/assets/images/${item.img}`)"
                            />
                        </template>
                        <a-card-meta>
                            <template #title>
                                <p class="m-0 fw-bold title-b3 text-align-justify">{{ item.title }}</p>
                            </template>
                            <template #description>
                                <p class="m-0 description-b3">{{ item.description }}</p>
                            </template>
                        </a-card-meta>
                    </a-card>
                </a-col>
            </div>
        </div>
    </div>
</template>

<script>


export default {
    name: 'InfoBlock2',
    auth: false,
    data() {
        return {
            items: [
                {
                    img: 'i-block-1.svg',
                    title: 'ブロックチェーンに刻み込むことで、契約内容の書き換えや金銭トラブルを防ぐ',
                    description: '作品を売り上げてから多くお金を持っていかれた、売れたり最初に話たことと状況が変わって不安、などが起きないようにする。',
                }, {
                    img: 'i-block-2.svg',
                    title: '作品ごとに異なった契約ができる',
                    description: 'アーティストとしての活動方針を売れるためにコントロールされてしまったりしないように、相性のいいdadに出会うまでに検討ができるように、作品毎に期間と配当を決めることができる仕組みにしています。',
                }, {
                    img: 'i-block-3.svg',
                    title: '自分の作品の値段をDadと相談して決めることができる',
                    description: 'なかなか自分の作品の値段を自分で決めたり、買う理由を考えることは困難です。自分の価値や良さを客観的に、また戦略的に、考えてもらえる人と組むことで価格設定や売り込みに悩んでいるアーティストを救いたいと考えています。',
                }, {
                    img: 'i-block-4.svg',
                    title: 'PRをDadに託すことで作品制作に集中できる',
                    description: '今までは作った作品を同じくらいの労力をかけて、発信したりPRする努力が必要でした。Dadという存在と分担することで、より作品に注力できる環境を作ることができると考えます。',
                }, {
                    img: 'i-block-5.svg',
                    title: 'NFTにする方法をサポート',
                    description: 'DadAとしてもプロセスの単純化やよりわかりやすい情報の発信、Dadの教育等、アーティストを守ることができるDad人材を世の中に増やしていきます。',
                }
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
