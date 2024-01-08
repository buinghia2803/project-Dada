<template>
  <div class="container">
    <template v-if="error.statusCode === 404">
      <a-result status="404" title="404" sub-title="Sorry, the page you visited does not exist.">
        <template #extra>
            <a-config-provider :autoInsertSpaceInButton="false">
              <a-button type="primary">
                <nuxt-link to="/"> ダッシュボードへ </nuxt-link>
              </a-button>
            </a-config-provider>
        </template>
      </a-result>
    </template>

    <template v-else-if="error.statusCode === 403">
      <a-result status="403" title="403" sub-title="Sorry, you are not authorized to access this page.">
        <template #extra>
            <a-config-provider :autoInsertSpaceInButton="false">
              <a-button type="primary">
                <nuxt-link to="/"> ダッシュボードへ </nuxt-link>
              </a-button>
            </a-config-provider>
        </template>
      </a-result>
    </template>

    <template v-else>
      <a-result status="500" title="500" sub-title="Sorry, the server is wrong.">
        <template #extra>
            <a-config-provider :autoInsertSpaceInButton="false">
              <a-button type="primary">
                <nuxt-link to="/"> ダッシュボードへ </nuxt-link>
              </a-button>
            </a-config-provider>
        </template>
      </a-result>
    </template>
  </div>
</template>

<script>
export default {
  layout: "blank",
  props: {
    error: {
      type: Object,
      default: () => ({})
    }
  }
};
</script>
