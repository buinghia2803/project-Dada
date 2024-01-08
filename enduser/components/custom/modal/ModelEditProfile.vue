<template>

    <a-modal v-model="visibleEditProfile" ok-text="" cancel-text="" :footer="null" :afterClose="afterClose"
        :dialogClass="'box-edit-profile'" :maskClosable="false" :closable="false">

        <template #title>
            <div class="ant-modal-title">
                <div class="act-close role-btn" @click="afterClose">
                    <svg width="25" height="27" viewBox="0 0 25 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <line y1="-1" x2="33.7205" y2="-1" transform="matrix(0.671075 0.741389 -0.712275 0.701901 0 2)"
                            stroke="black" stroke-width="2" />
                        <line y1="-1" x2="33.698" y2="-1"
                            transform="matrix(0.682632 -0.730763 0.701128 0.713035 1.99609 26.625)" stroke="black"
                            stroke-width="2" />
                    </svg>
                </div>
                <div class="act-edit">編集</div>
                <div class="act-keep" @click="editProfile">保存</div>
            </div>
        </template>
        <ValidationObserver ref="observer">
            <a-form class="d-edit-profile-form" :model="formState" :label-col="labelCol" :wrapper-col="wrapperCol"
                slot-scope="{ handleSubmit }" ref="observer" @submit.prevent="handleSubmit(editProfile)">
                <input type="file" name="image_url" id="image_url" hidden accept="image/*"
                    @change="avatarChange($event)">
                <div class="box-avatar-change">
                    <div class="icon-change d-flex" @click="uploadAvatar">
                        <div v-if="formState.image_url">
                            <img :src="file" alt="avatar" height="120px" width="120px"
                                style="border-radius: 50% !important;">
                        </div>
                        <template v-else>
                            <img class="image-avatar" src="~/assets/images/avatar.png" alt="avatar">
                        </template>
                    </div>
                    <button type="button" aria-label="Close" class="ant-modal-close" @click="removeImage($event)">
                        <span class="ant-modal-close-x text-white">
                            <span role="img" aria-label="close" class="anticon anticon-close ant-modal-close-icon">
                                <svg focusable="false" class="" data-icon="close" width="1em" height="1em"
                                    fill="currentColor" aria-hidden="true" viewBox="64 64 896 896">
                                    <path
                                        d="M563.8 512l262.5-312.9c4.4-5.2.7-13.1-6.1-13.1h-79.8c-4.7 0-9.2 2.1-12.3 5.7L511.6 449.8 295.1 191.7c-3-3.6-7.5-5.7-12.3-5.7H203c-6.8 0-10.5 7.9-6.1 13.1L459.4 512 196.9 824.9A7.95 7.95 0 00203 838h79.8c4.7 0 9.2-2.1 12.3-5.7l216.5-258.1 216.5 258.1c3 3.6 7.5 5.7 12.3 5.7h79.8c6.8 0 10.5-7.9 6.1-13.1L563.8 512z">
                                    </path>
                                </svg>
                            </span>
                        </span>
                    </button>
                </div>
                <div v-if="checkErrorFile" :class="['avatar-error']">{{ msgErrorFile }}</div>


                <div class="act-form">
                    <ValidationProvider name="full_name" rules="required|max:126">
                        <a-form-item label="名前" class="label-bold" slot-scope="{ errors }"
                            :validateStatus="errors[0] ? 'error' : 'success'" :help="errors[0]">
                            <a-input v-model="formState.full_name" placeholder="jou_muramoto" size="large" />
                        </a-form-item>
                    </ValidationProvider>
                    <ValidationProvider name="positions" rules="max:126">
                        <a-form-item label="肩書" class="label-bold" slot-scope="{ errors }"
                            :validateStatus="errors[0] ? 'error' : 'success'" :help="errors[0]">
                            <a-input v-model="formState.positions" placeholder="取締役 /designer / イラストレ..."
                                size="large" />
                        </a-form-item>
                    </ValidationProvider>
                    <ValidationProvider name="email" rules="email|max:255">
                        <a-form-item label="アドレス" class="label-bold" slot-scope="{ errors }"
                            :validateStatus="errors[0] ? 'error' : 'success'" :help="errors[0]">
                            <a-input v-model="formState.email" placeholder="aaa@aaa.com" size="large" />
                        </a-form-item>
                    </ValidationProvider>
                    <ValidationProvider name="description" rules="max:500">
                        <a-form-item label="自己紹介" class="label-bold" slot-scope="{ errors }"
                            :validateStatus="errors[0] ? 'error' : 'success'" :help="errors[0]">
                            <a-textarea v-model="formState.description" :rows="5"
                                placeholder="この文章はタイトルです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミーこの文章はタイトルです。文字の大きさ、量、字間、行間等を確認するために入れています。この文章はダミー" />
                        </a-form-item>
                    </ValidationProvider>
                </div>
            </a-form>
        </ValidationObserver>
    </a-modal>

</template>

<script>
import { mapActions } from 'vuex'
import { UserModel } from '~/services/modules/users/UserModel'


export default {
    name: 'ModelEditProfile',
    event: [
        'funcEditProfile'
    ],
    props: {
        visibleEditProfile: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            labelCol: { span: 4 },
            wrapperCol: { span: 20 },
            file: '',
            checkErrorFile: false,
            msgErrorFile: '',
            formState: new UserModel(),
            previousInfo: new UserModel()
        }
    },

    mounted() {
        if (this.$auth.loggedIn) {
            this.formState = new UserModel(this.$auth.user)
            this.previousInfo = new UserModel(this.$auth.user)
            // this.file = this.formState.image_url ? this.$nuxt.context.env.IMAGE_URL + this.formState.image_url : ''
            this.file = this.formState.image_url ? this.$nuxt.context.env.IMAGE_URL + this.formState.image_url : ''
        }
    },

    methods: {
        ...mapActions({
            actionEditProfile: "user/actionEditProfile",
        }),

        uploadAvatar() {
            document.querySelector('#image_url').click()
        },

        afterClose() {
            this.formState = this.previousInfo
            this.$emit('funcEditProfile', {})
        },

        async editProfile() {
            const isValid = await this.$refs.observer.validate();

            if (!isValid) {
                return
            }

            this.loading = true
            // send api update profile
            const data = await this.actionEditProfile(this.formState)
            this.$auth.setUser(data.data)
            this.formState = new UserModel(data.data)
            this.previousInfo = new UserModel(data.data)
            this.loading = false
            this.afterClose()
        },

        avatarChange(event) {
            const file = event.target.files[0];

            this.checkErrorFile = false;
            if (file) {
                // validate file
                if (file.type != 'image/jpeg' && file.type != 'image/jpg' && file.type != 'image/png') {
                    this.resetImage()
                    this.checkErrorFile = true;
                    this.msgErrorFile = this.$t('messages.error.invalid_image')
                    return;
                }
                if (file.size > 1000000) {
                    this.resetImage()
                    this.checkErrorFile = true;
                    this.msgErrorFile = this.$t('messages.error.max_file_size')
                    return;
                }
                this.formState.image_url = file;
                var reader = new FileReader();
                reader.readAsDataURL(file);
                let $this = this;
                reader.onload = function () {
                    $this.file = reader.result
                };
            } else {
                this.resetImage();
            }
        },

        removeImage(event) {
            this.resetImage();
        },

        resetImage() {
            if (this.previousInfo.image_url) {
                this.file = this.$nuxt.context.env.IMAGE_URL + this.previousInfo.image_url
                this.previousInfo.image_url = ''
            } else {
                this.file = ''
                this.formState.image_url = ''
                document.getElementById('image_url').value = ''
            }
        }
    }
}
</script>

<style lang="less" scoped>
.box-edit-profile {
    .ant-modal-title {
        display: flex;
        justify-content: space-around;
        align-items: center;

        .act-edit {
            width: 100%;
            text-align: center;
            cursor: pointer;
        }

        .act-keep {
            width: 40px;
            cursor: pointer;
        }
    }

    .avatar-error {
        color: red;
        text-align: center;
        margin-left: 15px;
    }

    .box-avatar-change {
        display: grid;
        justify-content: center;
        position: relative;

        .icon-change {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            justify-content: center;

            svg.default {
                align-self: center;
            }

            img.image-avatar {
                height: 100%;
                width: 100%;
                border-radius: 50%;
                overflow: hidden;
                object-fit: contain;
            }

        }

        .ant-modal-close {
            top: 1px;
            right: 180px;

            span.ant-modal-close-x {
                background: black;
                width: 25px;
                height: 25px;
                line-height: 28px;
                border-radius: 50%;

                svg {
                    top: 10px;
                }
            }
        }
    }

    .act-form {
        margin-top: 32px;

        .ant-form-item {
            margin-bottom: 0;
            padding: 8px 0;
            border-top: 1px solid #B3B3B3;

            &:last-child {
                border-bottom: 1px solid #B3B3B3
            }
        }

        input {
            border: unset;
            height: 3rem;
        }
    }

}
</style>
