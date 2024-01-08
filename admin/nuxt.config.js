export default {
    // Disable server-side rendering (https://go.nuxtjs.dev/ssr-mode)
    ssr: false,
    telemetry: false,

    // Global page headers (https://go.nuxtjs.dev/config-head)
    head: {
        title: 'DadA',
        meta: [
            { charset: 'utf-8' },
            { name: 'viewport', content: 'width=device-width, initial-scale=1' },
            { hid: 'description', name: 'description', content: '' },
        ],
        // link: [{ rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }],
    },

    // Using loading of nuxt-loading.
    loading: { color: '#29d' },

    // Global CSS (https://go.nuxtjs.dev/config-css)
    css: [
        'ant-design-vue/dist/antd.css',
        '~/assets/less/spacing.less',
        '~/assets/less/main.less',
        '~/assets/less/common.less',
        '~/assets/admin/custom.less',
    ],

    // Style resources module configuration: https://github.com/nuxt-community/style-resources-module#readme
    styleResources: {
        less: [
            '~/assets/less/color.less',
            '~/assets/less/button.less',
            '~/assets/less/variables.less',
        ]
    },

    // Plugins to run before rendering page (https://go.nuxtjs.dev/config-plugins)
    plugins: [
        { src: '@/plugins/antd-ui' },
        { src: '@/plugins/axios' },
        { src: '@/plugins/auth' },
        { src: '@/plugins/vee-validate', ssr: true },
    ],

    // Auto import components (https://go.nuxtjs.dev/config-components)
    components: true,

    // Modules for dev and build (recommended) (https://go.nuxtjs.dev/config-modules)
    buildModules: [
        // https://go.nuxtjs.dev/eslint
        '@nuxtjs/eslint-module',
    ],

    // Modules (https://go.nuxtjs.dev/config-modules)
    modules: [
        '@nuxtjs/pwa',
        // Doc: https://github.com/nuxt-community/dotenv-module
        '@nuxtjs/dotenv',
        // https://auth.nuxtjs.org
        '@nuxtjs/auth',
        // https://go.nuxtjs.dev/axios
        '@nuxtjs/axios',
        // https://i18n.nuxtjs.org/
        '@nuxtjs/i18n',
        // https://github.com/nuxt-community/style-resources-module
        '@nuxtjs/style-resources',
        'vue-toastification/nuxt'
    ],

    toast: {
        // Vue Toastification plugin options
    },

    /*
    ** Axios module configuration
    */
    axios: {
        baseURL: process.env.VUE_APP_URL_API || ' http://localhost:8000/api/',
        debug: process.env.DEBUG || false,
        proxyHeaders: false,
        credentials: false,
    },

    // Auth module configuration: https://auth.nuxtjs.org
    auth: {
        localStorage: false,
        redirect: {
            login: '/login',
            logout: '/login',
            home: '/revenue',
            user: '/profile'
        },
        strategies: {
            local: {
                scheme: 'local',
                endpoints: {
                    login: { url: '/admin/login', method: 'post', propertyName: 'result.data.access_token' },
                    user: { url: '/admin/me', method: 'get', propertyName: 'result.data' },
                    logout: { url: '/admin/logout', method: 'post' }
                }
            }
        }
    },

    i18n: {
        locales: [
            { code: 'ja', iso: 'ja-JP' },
            { code: 'en', iso: 'en-US' },
            { code: 'vi', iso: 'vi-VN' }
        ],
        detectBrowserLanguage: false,
        defaultLocale: 'ja',
        strategy: 'no_prefix',
        locale: 'ja',
        vueI18n: {
            fallbackLocale: 'ja',
            messages: {
                ja: require('./lang/ja.json'),
                en: require('./lang/en.json'),
                vi: require('./lang/zh.json')
            },
            silentTranslationWarn: true
        }
    },


    router: {
        base: '/admin/',
        parseQuery(query) {
            return require('qs').parse(query)
        },
        stringifyQuery(query) {
            return require('qs').stringify(query, {
                arrayFormat: 'brackets',
                encode: false,
                addQueryPrefix: true,
                skipNulls: true,
            })
        },
        extendRoutes(routes) {
            routes.push({ path: '/auth/login', alias: '/login' })
            routes.push({ path: '/auth/forgot-password', alias: '/forgot-password' })
            routes.push({ path: '/auth/reset-password', alias: '/reset-password' })
            routes.push({ path: '/auth/logout', alias: '/logout' })
        },
    },

    // Build Configuration (https://go.nuxtjs.dev/config-build)
    build: {
        publicPath: '/_admin/', // Fix prefix for admin
        extend(config, ctx) {
            config.devServer = {
                hot: false
            }
        },
        transpile: ['vee-validate'],
        loaders: {
            less: {
                lessOptions: {
                    javascriptEnabled: true,
                },
            },
        },
    },
    server: {
        host: "0.0.0.0",
        port: 3000 // default: 3000
    },
}
