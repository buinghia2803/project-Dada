export const PAGE_SIZES = [10, 20, 50, 100, 200]

export const VUE_APP_URL_END_USER = process.env.VUE_APP_URL_END_USER

export const MAIL_TEMPLATE = [
    { id: 1, label: '契約登録' },
    { id: 2, label: '契約の確認' },
    { id: 3, label: 'Dadレビュー' },
    { id: 4, label: 'アーティストに送金' },
    { id: 5, label: 'パスワード再設定' },
    { id: 6, label: 'オファー' },
]

export const CONTRACT_STATUS = [
    { id: 6, label: 'すべて' },
    { id: 1, label: '契約前' },
    { id: 2, label: '契約破棄' },
    { id: 3, label: '契約中' },
    { id: 4, label: '契約満了' },
    { id: 5, label: '契約完了' },
]

export const CKEDITOR_IMAGE_CONFIG = {
    resizeUnit: '%',
    resizeOptions: [{
            name: 'resizeImage:original',
            value: null,
            label: '初期値'
        },
        {
            name: 'resizeImage:10',
            value: '10',
            label: '10%'
        },
        {
            name: 'resizeImage:20',
            value: '20',
            label: '20%'
        },
        {
            name: 'resizeImage:30',
            value: '30',
            label: '30%'
        },
        {
            name: 'resizeImage:40',
            value: '40',
            label: '40%'
        },
        {
            name: 'resizeImage:50',
            value: '50',
            label: '50%'
        },
        {
            name: 'resizeImage:60',
            value: '60',
            label: '60%'
        },
        {
            name: 'resizeImage:70',
            value: '70',
            label: '70%'
        },
        {
            name: 'resizeImage:80',
            value: '80',
            label: '80%'
        },
        {
            name: 'resizeImage:90',
            value: '90',
            label: '90%'
        }
    ],
    toolbar: ['resizeImage', '|', 'imageStyle:alignLeft', 'imageStyle:full', 'imageStyle:alignRight', 'side'],
    styles: [
        // This option is equal to a situation where no style is applied.
        'full',
        // This represents an image aligned to the left.
        'alignLeft',
        // This represents an image aligned to the right.
        'alignRight'
    ],

}

export const EDITOR_CONFIG = {
    placeholder: '内容を記入',
    image: CKEDITOR_IMAGE_CONFIG,
    removePlugins: ['Title'],
    language: 'ja',
    toolbar: {
        items: [
            'bold',
            'italic',
            'strikethrough',
            'link',
            '|',
            'heading',
            'blockQuote',
            'code',
            'numberedList',
            'bulletedList',
            '|',
            'indent',
            'outdent',
            '|',
            'imageupload',
        ]
    },
    simpleUpload: {
        // The URL that the images are uploaded to.
        uploadUrl: process.env.VUE_APP_URL_API + '/admin/upload-file',
    },
}

export const TYPE_DAD_ROLE = 1
export const TYPE_ARTIST_ROLE = 2

export const STATUS_CONTRACT_OFFER = {
    WAIT_FOR_SIGNING:  0,
    IS_EFFECT: 1,
    REJECT: 2,
    SOLD: 3,
    CONTRACT_EXPIRATION: 4
}

export const STATUS_NFT_OFFER = {
    WAIT_FOR_CONFIRM: 0,
    APPROVE: 1,
    REJECT: 2,
    APPROVE_OPENSEA: 3,
    REJECT_OPENSEA: 4
}
