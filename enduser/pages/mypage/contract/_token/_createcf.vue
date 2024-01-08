<template>
    <div class="main-contract-creat-cf">
        <div class="box-head-action">
            <div></div>
            <h3>作品アップロード</h3>
            <div></div>
        </div>
        <hr class="line-title">

        <div class="warp-contract-create">
            <ValidationObserver ref="observer">
                <a-form :model="formState"
                        :label-col="labelCol"
                        slot-scope="{ handleSubmit }"
                        @submit.prevent="handleSubmit(isConfirmData)"
                >

                    <div class="box-avatar">
                        <div class="icon-change d-flex" id="d-box-image-nft">
                            <div class="d-no-image d-block" v-if="1">
                                <ValidationProvider name="image" rules="required">
                                    <a-form-item slot-scope="{ errors }"
                                                 :validateStatus="errors[0] ? 'error' : 'success'"
                                    >
                                        <a-input class="d-hint-input-file"
                                                 type="file"
                                                 id="uploadNft"
                                                 placeholder=""
                                                 @change="changeFileNft"
                                                 size="large"/>
                                        <svg @click="clickOpenUploadNft" class="default role-btn" width="190"
                                             height="75" viewBox="0 0 190 75" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M7.8 31.392L5.976 30.816C5.848 31.28 5.56 31.92 5.368 32.256C4.6 33.68 3.016 36 0.248 37.712L1.608 38.768C3.32 37.584 4.776 36.032 5.832 34.576H10.888C10.584 35.744 9.832 37.312 8.888 38.608C7.816 37.872 6.696 37.152 5.736 36.592L4.632 37.728C5.56 38.32 6.712 39.104 7.816 39.904C6.44 41.36 4.504 42.752 1.768 43.584L3.224 44.864C5.832 43.872 7.736 42.464 9.16 40.912C9.816 41.44 10.424 41.936 10.872 42.352L12.056 40.944C11.56 40.544 10.936 40.064 10.264 39.584C11.432 37.952 12.264 36.144 12.712 34.752C12.824 34.432 13 34.032 13.144 33.76L11.848 32.96C11.544 33.072 11.096 33.136 10.648 33.136H6.792C6.856 33.024 6.904 32.928 6.968 32.816C7.144 32.496 7.48 31.872 7.8 31.392ZM22.888 34.656L21.384 35.152C21.752 35.92 22.472 37.92 22.664 38.672L24.168 38.128C23.96 37.424 23.176 35.328 22.888 34.656ZM28.728 35.68L26.968 35.12C26.744 37.136 25.944 39.216 24.84 40.592C23.512 42.24 21.4 43.456 19.592 43.968L20.92 45.328C22.728 44.64 24.712 43.344 26.184 41.456C27.304 40.032 27.992 38.336 28.424 36.624C28.488 36.368 28.584 36.08 28.728 35.68ZM19.16 35.488L17.656 36.032C18.008 36.656 18.84 38.832 19.112 39.68L20.632 39.12C20.328 38.24 19.528 36.224 19.16 35.488ZM43.88 32.4C43.88 31.856 44.328 31.392 44.872 31.392C45.416 31.392 45.88 31.856 45.88 32.4C45.88 32.944 45.416 33.392 44.872 33.392C44.328 33.392 43.88 32.944 43.88 32.4ZM43.032 32.4C43.032 32.544 43.048 32.688 43.08 32.832C42.824 32.864 42.584 32.864 42.392 32.864H34.632C34.104 32.864 33.352 32.8 32.904 32.752V34.544C33.32 34.512 33.96 34.48 34.632 34.48H42.504C42.28 35.936 41.592 37.984 40.504 39.392C39.176 41.056 37.368 42.432 34.248 43.2L35.624 44.704C38.52 43.792 40.52 42.256 41.976 40.368C43.272 38.656 44.008 36.128 44.376 34.496C44.392 34.4 44.424 34.288 44.44 34.192C44.584 34.224 44.728 34.24 44.872 34.24C45.896 34.24 46.728 33.424 46.728 32.4C46.728 31.392 45.896 30.56 44.872 30.56C43.848 30.56 43.032 31.392 43.032 32.4ZM52.664 31.44L50.616 31.424C50.728 31.952 50.792 32.608 50.792 33.28C50.792 34.816 50.632 38.944 50.632 41.216C50.632 43.872 52.264 44.912 54.696 44.912C58.28 44.912 60.44 42.848 61.496 41.328L60.36 39.936C59.208 41.648 57.528 43.232 54.728 43.232C53.336 43.232 52.296 42.656 52.296 40.96C52.296 38.752 52.408 35.056 52.488 33.28C52.504 32.704 52.568 32.032 52.664 31.44ZM63.7796 33.2L63.9556 34.96C65.7316 34.576 69.4596 34.192 71.0756 34.016C69.7796 34.864 68.3556 36.816 68.3556 39.216C68.3556 42.752 71.6356 44.432 74.7716 44.576L75.3636 42.88C72.7076 42.768 69.9876 41.792 69.9876 38.88C69.9876 36.976 71.4116 34.704 73.5396 34.064C74.3716 33.84 75.7636 33.824 76.6436 33.824V32.208C75.5396 32.256 73.9396 32.352 72.2276 32.496C69.2836 32.736 66.4356 33.008 65.2676 33.12C64.9636 33.152 64.4036 33.184 63.7796 33.2ZM92.4836 33.36L91.2516 32.56C90.8996 32.656 90.4996 32.672 90.2276 32.672H82.4676C81.9396 32.672 81.1876 32.608 80.7396 32.544V34.336C81.1396 34.304 81.7796 34.272 82.4676 34.272H90.3236C90.1156 35.744 89.4276 37.792 88.3236 39.184C87.0116 40.864 85.2036 42.224 82.0676 42.992L83.4436 44.496C86.3556 43.584 88.3556 42.064 89.8116 40.16C91.1076 38.464 91.8436 35.92 92.1956 34.288C92.2756 33.968 92.3556 33.616 92.4836 33.36ZM108.532 35.968L107.604 35.12C107.38 35.168 106.836 35.2 106.548 35.2H98.8516C98.3396 35.2 97.7476 35.152 97.2676 35.088V36.736C97.8116 36.688 98.3396 36.672 98.8516 36.672H106.18C105.764 37.408 104.66 38.704 103.62 39.36L104.916 40.24C106.228 39.312 107.636 37.296 108.132 36.48C108.228 36.352 108.404 36.096 108.532 35.968ZM103.108 37.616H101.348C101.412 37.952 101.46 38.304 101.46 38.656C101.46 40.72 101.14 42.32 99.1396 43.68C98.7076 43.968 98.3236 44.144 97.9396 44.288L99.3156 45.392C102.868 43.44 103.044 40.848 103.108 37.616ZM111.732 38.032L112.516 39.616C114.628 38.976 116.74 38.048 118.42 37.136V42.704C118.42 43.36 118.372 44.24 118.324 44.592H120.308C120.228 44.24 120.196 43.36 120.196 42.704V36.064C121.78 35.024 123.284 33.792 124.5 32.56L123.156 31.28C122.068 32.576 120.372 34.064 118.708 35.088C116.932 36.192 114.532 37.28 111.732 38.032ZM134.756 43.648L135.812 44.528C135.94 44.432 136.132 44.288 136.42 44.128C138.26 43.2 140.516 41.52 141.876 39.712L140.9 38.336C139.748 40.032 137.94 41.392 136.548 42.016V33.168C136.548 32.512 136.612 31.984 136.628 31.888H134.772C134.772 31.984 134.868 32.512 134.868 33.168V42.64C134.868 43.008 134.82 43.376 134.756 43.648ZM127.38 43.504L128.916 44.528C130.276 43.376 131.284 41.808 131.764 40.048C132.196 38.448 132.26 35.04 132.26 33.216C132.26 32.656 132.324 32.064 132.34 31.936H130.484C130.58 32.304 130.612 32.688 130.612 33.232C130.612 35.072 130.612 38.192 130.148 39.616C129.684 41.088 128.772 42.544 127.38 43.504ZM150.068 31.264L148.404 31.136C148.372 31.712 148.244 32.384 148.036 33.04C147.716 33.056 147.396 33.056 147.092 33.056C146.324 33.056 145.188 33.008 144.34 32.88V34.384C145.236 34.448 146.34 34.48 147.012 34.48C147.156 34.48 147.316 34.48 147.476 34.48C146.82 35.84 145.732 37.392 143.86 39.152L145.236 40.176C145.764 39.504 146.228 38.912 146.692 38.464C147.364 37.824 148.372 37.312 149.348 37.312C149.94 37.312 150.452 37.552 150.66 38.112C148.804 39.056 146.884 40.304 146.884 42.272C146.884 44.256 148.74 44.816 151.124 44.816C152.564 44.816 154.42 44.672 155.572 44.528L155.62 42.912C154.212 43.168 152.468 43.328 151.172 43.328C149.556 43.328 148.516 43.104 148.516 42.016C148.516 41.072 149.38 40.336 150.756 39.584C150.74 40.368 150.724 41.28 150.692 41.84H152.212C152.196 41.072 152.18 39.792 152.164 38.88C153.284 38.368 154.324 37.952 155.14 37.632C155.62 37.44 156.308 37.184 156.772 37.04L156.116 35.568C155.604 35.824 155.14 36.032 154.596 36.272C153.844 36.624 153.028 36.96 152.036 37.424C151.732 36.528 150.9 36.064 149.892 36.064C149.268 36.064 148.372 36.24 147.844 36.544C148.292 35.936 148.724 35.184 149.076 34.432C150.804 34.384 152.772 34.24 154.34 34.016V32.528C152.884 32.784 151.204 32.928 149.636 32.992C149.844 32.304 149.972 31.712 150.068 31.264ZM170.74 33.408V35.232H165.94V33.408H170.74ZM171.348 39.04V41.136H165.94V39.04H171.348ZM164.484 42.384H172.82V37.792H165.94V36.464H172.18V32.192H168.692C168.9 31.76 169.108 31.28 169.3 30.784L167.572 30.528C167.476 31.024 167.3 31.648 167.108 32.192H164.484V42.384ZM163.284 33.392C162.74 32.624 161.54 31.632 160.548 30.944L159.444 31.84C160.452 32.544 161.604 33.616 162.116 34.368L163.284 33.392ZM162.852 36.784H159.348V38.16H161.396V41.92C160.644 42.528 159.796 43.12 159.076 43.568L159.844 45.104C160.676 44.416 161.444 43.776 162.196 43.12C163.204 44.352 164.58 44.88 166.612 44.96C168.436 45.04 171.652 45.008 173.46 44.928C173.54 44.464 173.78 43.76 173.956 43.408C171.956 43.536 168.404 43.584 166.628 43.52C164.868 43.456 163.556 42.944 162.852 41.84V36.784ZM178.964 33.504C178.98 32.624 178.98 31.712 178.98 30.8H177.508C177.508 31.728 177.508 32.624 177.492 33.504H175.428V34.96H177.46C177.348 38.832 176.9 42.128 175.012 44.208C175.364 44.432 175.876 44.928 176.116 45.264C178.228 42.928 178.772 39.232 178.916 34.96H180.996C180.868 40.72 180.74 42.816 180.404 43.248C180.26 43.488 180.116 43.52 179.86 43.52C179.588 43.52 178.948 43.504 178.244 43.472C178.5 43.872 178.66 44.512 178.676 44.96C179.412 44.992 180.116 44.992 180.564 44.928C181.076 44.848 181.38 44.688 181.7 44.224C182.196 43.504 182.308 41.136 182.436 34.224C182.452 34.032 182.452 33.504 182.452 33.504H178.964ZM184.996 42.416V33.92H187.62V42.416H184.996ZM183.572 32.48V44.992H184.996V43.84H187.62V44.864H189.124V32.48H183.572Z"
                                                fill="black"/>
                                            <g opacity="0.5">
                                                <g opacity="0.5">
                                                    <path
                                                        d="M72.5441 58.5161H119.433C120.337 58.5161 121.168 58.0148 121.589 57.216C122.006 56.4149 121.946 55.4468 121.433 54.7052L111.303 40.043C110.378 38.7063 108.845 37.9166 107.215 37.9487C105.586 37.9807 104.08 38.823 103.205 40.1985L100.317 44.7372L92.2852 33.1123C91.3605 31.7688 89.8247 30.9838 88.1951 31.0135C86.5654 31.0432 85.0594 31.8879 84.1851 33.2634L70.4933 54.7829C70.0173 55.5313 69.9852 56.4789 70.4156 57.2549C70.8412 58.0331 71.6561 58.5161 72.5441 58.5161Z"
                                                        fill="#4B4B4B"/>
                                                    <path
                                                        d="M105.266 32.799C108.736 32.799 111.553 29.9837 111.553 26.5116C111.553 23.0417 108.736 20.2266 105.266 20.2266C101.794 20.2266 98.9785 23.0418 98.9785 26.5116C98.9785 29.9839 101.794 32.799 105.266 32.799Z"
                                                        fill="#4B4B4B"/>
                                                    <path
                                                        d="M58 2.8877V72.1153H133V68.4074V2.8877H58ZM125.584 64.6996H65.4158V10.3035H125.584V64.6996Z"
                                                        fill="#4B4B4B"/>
                                                </g>
                                            </g>
                                        </svg>

                                    </a-form-item>
                                </ValidationProvider>
                            </div>
                            <template v-else>
                                <img class="image-avatar" src="~/assets/images/logo.png" alt="logo">
                                <button type="button" aria-label="Close" class="ant-modal-close"
                                        v-if="!isConfirm">
                                        <span class="ant-modal-close-x text-white">
                                            <span role="img" aria-label="close"
                                                  class="anticon anticon-close ant-modal-close-icon">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M22.5 1.5L1.5 22.5" stroke="white" stroke-width="2"/>
                                                    <path d="M1.5 1.5L22.5 22.5" stroke="white" stroke-width="2"/>
                                                </svg>
                                            </span>
                                        </span>
                                </button>

                            </template>
                        </div>

                        <div class="box-right">
                            <template v-if="!isConfirm">
                                <ValidationProvider name="title" rules="required|max:50">
                                    <a-form-item label="作品名"
                                                 class="label-bold"
                                                 slot-scope="{ errors }"
                                                 :validateStatus="errors[0] ? 'error' : 'success'"
                                                 :help="errors[0]">
                                        <a-input v-model="formState.title"
                                                 :maxLength="50"
                                                 placeholder=""
                                                 size="large"/>
                                    </a-form-item>
                                </ValidationProvider>

                                <a-form-item label="契約期間" class="label-bold">
                                    <div class="d-flex">
                                        <ValidationProvider name="date_start" rules="required">
                                            <a-form-item slot-scope="{ errors }"
                                                         :validateStatus="errors[0] ? 'error' : 'success'"
                                                         :help="errors[0]"
                                            >
                                                <a-config-provider :locale="localeDate">
                                                    <a-date-picker v-model="formState.startDate"
                                                                   placeholder=""
                                                                   :default-value="startDateDefault"
                                                                   :locale="'ja_JP'"
                                                                   :format="'YYYY.MM.DD'"
                                                                   :disabled-date="disabledStartDate"
                                                                   size="large"/>
                                                </a-config-provider>
                                            </a-form-item>
                                        </ValidationProvider>
                                        <span class="ml-3 mr-3 black">~</span>
                                        <ValidationProvider name="date_end" rules="required">
                                            <a-form-item slot-scope="{ errors }"
                                                         :validateStatus="errors[0] ? 'error' : 'success'"
                                                         :help="errors[0]"
                                            >
                                                <a-config-provider :locale="localeDate">
                                                    <a-date-picker v-model="formState.endDate"
                                                                   :locale="'ja_JP'"
                                                                   :default-value="endDateDefault"
                                                                   placeholder=""
                                                                   :disabled-date="disabledEndDate"
                                                                   :format="'YYYY.MM.DD'"
                                                                   size="large"/>
                                                </a-config-provider>
                                            </a-form-item>
                                        </ValidationProvider>
                                    </div>
                                </a-form-item>
                            </template>
                            <template v-else>
                                <a-form-item label="作品名" class="label-bold">
                                    <span class="black">{{ 'text_ART' }}</span>
                                </a-form-item>
                                <a-form-item label="契約期間" class="label-bold">
                                    <div class="d-flex">
                                        <span class="black">
                                            {{ formState.startDate ? formState.startDate.format('YYYY.MM.DD') : '' }}
                                        </span>
                                        <span class="ml-4 mr-4 black">~</span>
                                        <span class="black">
                                            {{ formState.endDate ? formState.endDate.format('YYYY.MM.DD') : '' }}
                                        </span>
                                    </div>
                                </a-form-item>
                            </template>
                        </div>
                    </div>

                    <div class="warp-content-grid">
                        <a-form-item label="自己紹介" class="label-bold">
                            <template v-if="!isConfirm">
                                <ValidationProvider name="bio" rules="max:2000">
                                    <a-form-item slot-scope="{ errors }"
                                                 :validateStatus="errors[0] ? 'error' : 'success'"
                                                 :help="errors[0]"
                                    >
                                        <a-textarea v-model="formState.bio" :rows="7" placeholder="初めてのNFT作品です。"/>
                                    </a-form-item>
                                </ValidationProvider>
                            </template>
                            <template v-else>
                                <div class="description">{{ '初めてのNFT作品です' }}</div>
                            </template>
                        </a-form-item>

                        <a-form-item label="販売金額" class="label-bold" :wrapper-col="{ span: 12}">
                            <template v-if="!isConfirm">
                                <ValidationProvider name="priceEth" rules="required|selling_price">
                                    <a-form-item slot-scope="{ errors }"
                                                 :validateStatus="errors[0] ? 'error' : 'success'"
                                                 :help="errors[0]"
                                    >
                                        <a-input v-model="formState.priceEth" placeholder="初めてのNFT作品です。" size="large">
                                            <img src="~/assets/images/c-eth.svg" alt="eth" slot="prefix">
                                        </a-input>
                                    </a-form-item>
                                </ValidationProvider>
                            </template>
                            <template v-else>
                                <div class="d-flex">
                                    <span class="black">0.1</span>
                                </div>
                            </template>
                        </a-form-item>

                        <a-form-item label="販売配当率" class="label-bold" :wrapper-col="{ span: 12}">
                            <div class="d-flex black" v-if="!isConfirm">
                                <div class="label">Artist</div>
                                <ValidationProvider name="percentArt" rules="required|isPercent">
                                    <a-form-item slot-scope="{ errors }"
                                                 :validateStatus="errors[0] ? 'error' : 'success'"
                                                 :help="errors[0]"
                                    >
                                        <a-input v-model="formState.percentArt" class="ant-col-9 ml-2 pl-1 mr-2"
                                                 placeholder=""
                                                 :maxLength="3"
                                                 addon-after="%"
                                                 size="large"/>
                                        <div class="d-flex">
                                            <div class="label ml-3">Dad</div>
                                            <div class="ml-2">{{ formState.percentDad }}%</div>
                                        </div>
                                    </a-form-item>
                                </ValidationProvider>

                            </div>
                            <div class="d-flex black" v-else>
                                <div class="label">Artist</div>
                                <div class="ml-2">{{ formState.percentDad }}%</div>
                                <div class="label ml-3 black">Dad</div>
                                <div class="ml-2 black">{{ formState.percentDad }}%</div>
                            </div>
                        </a-form-item>

                        <a-form-item label="Artist配当金" class="label-bold" :wrapper-col="{ span: 12}">
                            <div class="d-block">
                                <div class="label black">メタマスクID</div>
                                <p class="decoration-under wallet-color m-0">
                                    {{ contractInfo.public_address_main }} xxxxxxxxxxxxxxxxxx
                                </p>
                                <div class="d-flex">
                                    <img src="~/assets/images/c-eth.svg" alt="eth">
                                    <span class="pl-1 black">0.7</span>
                                </div>
                            </div>
                        </a-form-item>

                        <a-form-item label="Dad配当金" class="label-bold" :wrapper-col="{ span: 12}">
                            <div class="d-block">
                                <div class="label black">メタマスクID</div>
                                <p class="decoration-under wallet-color m-0">
                                    {{
                                        contractInfo && contractInfo.dad && contractInfo.dad.public_address_main
                                            ? contractInfo.dad.public_address_main : ''
                                    }}
                                </p>
                                <div class="d-flex">
                                    <img src="~/assets/images/c-eth.svg" alt="eth">
                                    <span class="pl-1 black">0.3</span>
                                </div>
                            </div>
                        </a-form-item>

                        <a-form-item label="システム手数料(Dad負担)" class="label-bold" :wrapper-col="{ span: 12}">
                            <div class="d-block">
                                <p class="m-0 black">Opensea({{ contractInfo.opensea_percent }}%)</p>
                                <p class="m-0 black">DadA(Dadから仮{{ +contractInfo.opensea_price }}%)</p>
                            </div>
                        </a-form-item>

                    </div>

                    <div class="btn-action-offer">
                        <a-config-provider :autoInsertSpaceInButton="false">
                            <a-button class="bg-discard-txt-gray mr-1" v-if="!isConfirm"
                                      @click="visibleCancelContract = true">
                                破棄する
                            </a-button>
                            <a-button class="bg-discard-txt-gray mr-1" v-else @click="isConfirm = false">
                                編集する
                            </a-button>
                        </a-config-provider>
                        <a-config-provider :autoInsertSpaceInButton="false">
                            <a-button class="bg-green-txt-white ml-1" html-type="submit" v-if="!isConfirm"
                                      @click="isConfirmData">
                                確認する
                            </a-button>
                            <a-button class="bg-green-txt-white ml-1" v-else>
                                確定する
                            </a-button>
                        </a-config-provider>
                    </div>
                </a-form>
            </ValidationObserver>
        </div>

        <ModalCancelContractCF :visibleCancelContract="visibleCancelContract"
                               @eventYesContract="eventFuncYesContract"
                               @eventCancelContract="funcCancelContract"/>

        <ModalTemplate :visibleTemplate="visibleTemplate"
                       :widthTemplate="318"
                       :classContentTemplate="'box-cancel-content-done text-center'"
                       @eventVisibleClose="funcCancelTemplate">
            <template slot="content">
                <div class="box-cancel-offer-done">
                    <span>契約を破棄しました</span>
                </div>
            </template>
        </ModalTemplate>
    </div>
</template>

<script>
import moment from 'moment'
import 'moment/locale/ja';
import ja_JP from 'ant-design-vue/es/locale/ja_JP';
import offerUser from "@/mixins/offerUser";

moment.locale('ja');

export default {
    layout: "mainNo",
    middleware: ['auth'],
    components: {
        ModalCancelContractCF: () => import('~/components/custom/modal/ModalCancelContractCF.vue'),
        ModalTemplate: () => import('~/components/custom/modal/ModalTemplate.vue'),
    },
    validate({params}) {
        const isToken = params.token && params.token.length // string
        const isTokenCf = params.createcf && params.createcf.length // string

        return isToken && isTokenCf
    },
    mixins: [
        offerUser
    ],
    data() {
        return {
            startDateDefault: null,
            endDateDefault: null,
            tokenConfirm: '',
            token: '',
            localeDate: ja_JP,
            visibleCancelContract: false,
            visibleTemplate: false,
            isConfirm: false,
            labelCol: {span: 4},
            formState: {
                name: '',
                title: '',
                startDate: '',
                endDate: '',
                priceEth: '',
                percentArt: '',
                percentDad: ''
            }
        };
    },
    asyncData({params}) {
        return {
            token: params.token,
            tokenConfirm: params.createcf
        }
    },
    async fetch() {
        // Init check role of Art
        await this.initCheckRoleOfArt()
        // Check validate of Offer
        const payload = {
            token: this.token
        }
        await this.initValidateOffer(payload).then(data => {
            try {
                console.log(3424, data)
                if (Object.prototype.hasOwnProperty.call(data, 'date_start')) {
                    this.formState.startDate = moment(data.date_start)
                    this.startDateDefault = moment(data.date_start, 'YYYY.MM.DD')
                }
                if (Object.prototype.hasOwnProperty.call(data, 'date_end')) {
                    this.formState.endDate = moment(data.date_end)
                    this.endDateDefault = moment(data.date_end, 'YYYY.MM.DD')
                }

                if (Object.prototype.hasOwnProperty.call(data, 'selling_price')) {
                    this.formState.priceEth = data.selling_price // To String
                }
                if (Object.prototype.hasOwnProperty.call(data, 'artist_percent')) {
                    this.formState.percentArt = data.artist_percent + ''
                    this.formState.percentDad = (100 - +data.artist_percent) + '' // To String
                }
            } catch (e) {
                console.log(32424, e)
            }
        }).then(() => this.$nextTick(() => this.$forceUpdate()))
    },
    head() {
        return {
            title: `Create | Dada`,
            bodyAttrs: {
                class: 'current-page-create'
            }
        }
    },
    watch: {
        'formState.percentArt': {
            handler(newVal, oldVal) {
                this.formState.percentDad = 100 - newVal
            },
            deep: true
        },
        startDateDefault(newVal, oldVal) {
            console.log(23342, newVal)
            this.$nextTick(() => this.$forceUpdate())
        },
    },
    created() {
        if (process.client) {
            this.$root.$on('eventChangeRoleArtistOrDad', payload => {
                if (!payload || !Object.prototype.hasOwnProperty.call(payload, "type")) {
                    return;
                }

                window.location.href = '/mypage'
            })
        }
    },
    methods: {
        changeFileNft(event) {
            const sNft = document.getElementById('d-box-image-nft')
            if (sNft) {
                sNft.classList.remove('has-error-img-nft')
            }
            console.log(34234242)
        },
        clickOpenUploadNft() {
            document.getElementById('uploadNft').click()
        },
        funcCancelContract(payload) {
            this.visibleCancelContract = false
        },
        funcCancelTemplate(payload) {
            this.visibleTemplate = false
            setTimeout(() => {
                this.$router.push({path: '/'})
            }, 100)
        },
        eventFuncYesContract(payload) {
            this.visibleCancelContract = false
            // Todo call Api cancel

            this.visibleTemplate = true
        },
        disabledStartDate(startValue) {
            const endValue = this.formState.endDate;

            if (!startValue) {
                return false;
            }
            if (startValue.format('YYYYMMDD') < moment().add(1, 'days').format('YYYYMMDD')) {
                return true
            }

            if (startValue.format('YYYYMMDD') > moment().add(6, 'months').format('YYYYMMDD')) {
                return true;
            }

            if (!endValue) {
                return false;
            }

            return startValue.valueOf() > endValue.valueOf();
        },
        disabledEndDate(endValue) {
            const startValue = this.formState.startDate;
            if (!startValue) {
                return true;
            }
            if (endValue.format('YYYYMMDD') > moment().add(6, 'months').add(1, 'days').format('YYYYMMDD')) {
                return true;
            }

            return startValue.valueOf() > endValue.valueOf();
        },
        async isConfirmData() {
            const isValid = await this.$refs.observer.validate();
            const sNft = document.getElementById('d-box-image-nft')
            if (!isValid) {
                if (this.$refs.observer && Object.prototype.hasOwnProperty.call(this.$refs.observer, 'errors') && Object.prototype.hasOwnProperty.call(this.$refs.observer.errors, 'image')) {
                    if (Array.isArray(this.$refs.observer.errors.image) && this.$refs.observer.errors.image.length) {
                        if (sNft) {
                            sNft.classList.add('has-error-img-nft')
                        }
                    }
                }
                return
            }

            this.isConfirm = true
        }
    }
};
</script>

<style lang="less">
.main-contract-creat-cf {
    padding-top: 16px;

    .d-hint-input-file {
        display: none !important;
    }

    .ant-form-item-label {
        text-align: left;
    }

    .d-no-image {
        .ant-form-item-control-wrapper {
        }
    }

    .warp-contract-create .has-error-img-nft {
        border: 1px solid red !important;
    }

    .warp-contract-create {
        div.black,
        p.black,
        span.black {
            font-size: 16px;
            color: black;
        }

        input {
            color: black;
        }

        .box-avatar {
            justify-content: center;
            align-items: center;
            display: flex;
            color: black;
            padding: 32px 0;

            .icon-change {
                border: 1px solid #C4C4C4;
                border-radius: 6px;
                width: 318px;
                height: 237px;
                justify-content: center;
                vertical-align: middle;
                align-items: center;
                position: relative;

                svg.default {
                    align-self: center;
                    justify-content: center;
                }

                img.image-avatar {
                    height: 100%;
                    width: 100%;
                    border-radius: 50%;
                    overflow: hidden;
                    -o-object-fit: contain;
                    object-fit: contain;
                }

                .ant-modal-close {
                    top: 8px;
                    right: 8px;

                    span.ant-modal-close-x {
                        background: black;
                        width: 42px;
                        height: 42px;
                        line-height: 48px;
                        border-radius: 50%;
                    }
                }
            }

            .box-right {
                margin-left: 32px;

                .ant-form-item {
                    display: grid;
                }

                .ant-form-item-label {
                    padding-bottom: 0;

                    & > label {
                        color: #808080;
                        font-size: 16px;
                        font-weight: normal !important;
                    }
                }
            }
        }

        .warp-content-grid {
            color: black;

            .ant-form-item {
                display: grid;

                .ant-form-item-label > label {
                    color: #808080;
                    font-size: 16px;
                    font-weight: normal !important;
                }
            }
        }

        .btn-action-offer {
            display: flex;
            justify-content: center;
            margin: 96px auto;
        }
    }
}

@media (max-width: 1280px) {
    .main-contract-creat-cf {
        padding: 16px;
    }
}

@media (max-width: 567px) {
    .main-contract-creat-cf {
        .warp-contract-create {
            .box-avatar {
                padding-top: 32px;
                display: block;
                margin: 0 auto;

                .icon-change {
                    margin: 0 auto;
                }

                .box-right {
                    margin: 0 auto;
                    padding-top: 32px;
                }
            }

            .warp-content-grid,
            .box-right {
                //padding: 16px;
            }

            .btn-action-offer {
                margin: 40px auto;
            }
        }
    }
}
</style>

