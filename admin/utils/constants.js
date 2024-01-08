export const PAGE_SIZES = [10, 20, 50, 100, 200]

export const MAIL_TEMPLATE = [
    { id: 1, label: '契約登録' },
    { id: 2, label: '契約の確認' },
    { id: 3, label: 'パスワード再設定' },
    { id: 4, label: 'オファー' },
]

export const CONTRACT_STATUS = [
    { id: 6, label: 'すべて' },
    { id: 1, label: '契約前' },
    { id: 2, label: '契約破棄' },
    { id: 3, label: '契約中' },
    { id: 4, label: '契約満了' },
    { id: 5, label: '契約完了' },
]

export const OFFER_STATUS = [
    { id: 1, label: 'すべて' },
    { id: 2, label: '未確認' },
    { id: 3, label: '確認済み' },
    { id: 4, label: '満了' },
    { id: 5, label: '破棄' },
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

// TODO Fix status
export const STATUS_NOTIFICATION = {

}

export const STATUS_PAYMENT = [
    { value: 0, label: '未払い' },
    { value: 1, label: '支払い済' },
]


export const STATUS_UPDATE_PAYMENT = [
    { value: 0, label: '未払い' },
    { value: 1, label: '支払い済' },
]
