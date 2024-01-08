import {STATUS_CONTRACT_OFFER, STATUS_NFT_OFFER, TYPE_ARTIST_ROLE} from "@/utils/constants";
import moment from "moment";
import {mapActions} from "vuex";


export default {
    data() {
        return {
            contractInfo: {},
            token: '',
            statusContractOffer: STATUS_CONTRACT_OFFER,
            statusContractNFT: STATUS_NFT_OFFER,
        }
    },
    computed: {
        dateStartConvert() {
            try {
                return moment(this.contractInfo.date_start).format('YYYY.MM.DD')
            } catch (e) {
                return ""
            }
        },
        dateEndConvert() {
            try {
                return moment(this.contractInfo.date_start).format('YYYY.MM.DD')
            } catch (e) {
                return ""
            }
        },
        responsibility() {
            return Object.prototype.hasOwnProperty.call(this.contractInfo, 'responsibility')
            && this.contractInfo.responsibility ? this.contractInfo.responsibility : ''
        },
        contactInfo() {
            return Object.prototype.hasOwnProperty.call(this.contractInfo, 'contact_info')
            && this.contractInfo.contact_info ? this.contractInfo.contact_info : ''
        },
        contactInfoDescription() {
            return Object.prototype.hasOwnProperty.call(this.contractInfo, 'description')
            && this.contractInfo.description ? this.contractInfo.description.replaceAll('\n', '<br>') : ''
        }
    },
    methods: {
        ...mapActions({
            getOfferForArt: "offer-art/getOfferForArt",
        }),
        initCheckRoleOfArt() {
            if (!this.$auth || !this.$auth.user || !this.$auth.user.type || this.$auth.user.type !== TYPE_ARTIST_ROLE) {
                this.$nuxt.context.redirect('/mypage')
                this.$toast.info('続行するにはArtist役割の切り替えの必要です。')
                return;
            }
        },
        initValidateOffer(payload) {
            return this.getOfferForArt(payload).then(async data => {
                const result = Object.prototype.hasOwnProperty.call(data, 'result')
                && Object.prototype.hasOwnProperty.call(data.result, 'data') ? data.result.data : {}

                if (!Object.keys(result).length) {
                    throw new Error('Map data contract fail');
                }

                // Check status of Contract
                if (!Object.prototype.hasOwnProperty.call(result, 'status')) {
                    throw new Error('Map data contract status fail')
                }
                // 0 = waiting for signing, 1 = is in effect, 2 = reject, 3 = sold, 4 = Contract expiration
                switch (result.status) {
                    case this.statusContractOffer.IS_EFFECT:
                    case this.statusContractOffer.WAIT_FOR_SIGNING:
                        this.statusOffer = 'CONTRACT_OFFER'
                        break
                    case this.statusContractOffer.REJECT:
                        this.statusOffer = 'CONTRACT_OFFER_HANDLER'
                        await this.renderTypeOffer('art_reject')
                        break
                    case this.statusContractOffer.SOLD:
                        this.statusOffer = 'CONTRACT_OFFER_HANDLER'
                        await this.renderTypeOffer('art_finish_done')
                        break;
                    case this.statusContractOffer.CONTRACT_EXPIRATION:
                        this.statusOffer = 'CONTRACT_OFFER_HANDLER'
                        await this.renderTypeOffer('art_expired')
                        break
                    default:
                        this.statusOffer = 'CONTRACT_OFFER_HANDLER'
                        await this.renderTypeOffer('art_fail')
                }
                this.contractInfo = result

                return result
            }).catch(error => {
                this.statusOffer = 'CONTRACT_OFFER_HANDLER'
                this.renderTypeOffer('art_fail')
                return
            }).finally(() => {
                this.$forceUpdate()
            });
        },
        renderTypeOffer(statusOffer) {
            if (statusOffer === 'art_init_finish') {
                this.typeOffer = 'art_init_finish'
            } else if (statusOffer === 'art_reject') {
                this.typeOffer = 'art_reject'
            } else if (statusOffer === 'art_expired') {
                this.typeOffer = 'art_expired'
            } else if (statusOffer === 'art_fail') {
                this.typeOffer = 'art_fail'
            } else if (statusOffer === 'art_finish_done') {
                this.typeOffer = 'art_finish_done'
            } else {
                this.typeOffer = 'no_found'
            }
        },
        // ...mapActions({
        //     actionUpdateType: 'user/actionUpdateType'
        // }),
        // async logoutUser() {
        //     this.$store.commit('logout')
        //     this.form = {
        //         id: this.$auth.user.id,
        //         type: this.role_dad
        //     }
        //     await this.$auth.logout()
        //     const result = await this.actionUpdateType(this.form)
        //     if (result) {
        //         this.$auth.setUser(null)
        //         // /* await localStorage.clear();
        //         //  await this.$forceUpdate()*/
        //         await this.deleteAllCookies();
        //
        //         this.$router.push('/')
        //     }
        // },
        // deleteAllCookies() {
        //     const cookies = document.cookie.split(";");
        //
        //     for (let i = 0; i < cookies.length; i++) {
        //         const cookie = cookies[i];
        //         const eqPos = cookie.indexOf("=");
        //         const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        //         document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
        //     }
        // }
    }
}
