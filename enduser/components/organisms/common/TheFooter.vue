<template>
  <div class="footer_wrapper">
      <div class="footer-content__left">
        <div class="f-item mt-0">
          DadAが解決する課題
        </div>
        <div class="f-item">
          DadAのはじめ方
        </div>
        <div class="f-item">
          よくあるご質問
        </div>
        <div class="f-item">
          外部リンク
        </div>
        <div class="f-item">
          お問い合わせ
        </div>
        <div class="f-item">
          利用規約
        </div>
        <div class="f-item">
          プライバシーポリシー
        </div>
        <div class="f-item">
          運営会社
        </div>
      </div>
      <div class="footer-content__right">
        <div>
          <div class="f-item mt-0">新規登録</div>
          <div class="f-item">ログイン</div>
        </div>
        <div class="f-image-copy-right">
          <div>
            <img src="~/assets/images/logo.png" alt="" srcset="">
          </div>
          <div class="copy-right">
            © 2022 DadA
          </div>
        </div>
      </div>
  </div>
</template>

<script>
export default {
  name: 'TheFooter'
}
</script>

<style lang="less" scoped>
.footer_wrapper {
  display: flex;
  justify-content: space-between;
}
</style>