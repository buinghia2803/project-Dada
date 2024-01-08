<template>
    <div class="main-contract-finish">
        <div class="warp-contract-finish" v-if="type === 'art_init_finish'">
            <h3>契約内容がDadに送信されました</h3>
            <p class="mb-0 mt-6 text-center">Dadが契約内容を</p>
            <p class="mb-6 text-center"> 確認するまでお待ちください</p>
            <p class="role-btn decoration-under r2-mypage text-center" @click="r2Mypage">myページへ</p>
        </div>
        <div class="warp-contract-finish" v-else-if="type === 'art_reject'">
            <p>こちらの契約は破棄しました。</p>
            <p class="role-btn decoration-under r2-mypage text-center" @click="r2MyTop">TOPへ</p>
        </div>
        <div class="warp-contract-finish" v-else-if="type === 'art_expired'">
            <p>こちらの契約は満了しました。</p>
            <p class="role-btn decoration-under r2-mypage text-center" @click="r2MyTop">TOPへ</p>
        </div>
        <div class="warp-contract-finish" v-else-if="type === 'art_finish_done'">
            <p>こちらの契約は締結しています。</p>
            <p class="role-btn decoration-under r2-mypage text-center" @click="r2MyTop">TOPへ</p>
        </div>
        <div class="warp-contract-finish" v-else-if="type === 'art_fail'" >
            <p class="mb-0 mt-6">こちらの契約は存在しません。</p>
            <p class="role-btn decoration-under r2-mypage text-center" @click="r2MyTop">myページへ</p>
        </div>
        <div class="warp-contract-finish" v-else >
            <p class="mb-0 mt-6"></p>
            <p class="role-btn decoration-under r2-mypage text-center" @click="r2MyTop">TOPへ</p>
        </div>
    </div>
</template>

<script>

export default {
    name: 'contractFinish',
    props: {
      type: {
          type: String,
          required: true
      }
    },
    data() {
        return {};
    },
    methods: {
        r2Mypage() {
            this.$router.push({path: '/mypage'})
        },
        r2MyTop() {
            this.$router.push({path: '/'})
        }
    }
};
</script>

<style lang="less" src="assets/less/user/contract-finish.less"></style>


