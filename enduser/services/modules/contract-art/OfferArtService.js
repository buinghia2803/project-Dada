import BaseService from '@/services/BaseService'
import http from '@/utils/http'

const HTTP = new http()

export class OfferArtService extends BaseService {
    API_CONTRACT_OFFER_BY_USER = '/user/offer'
    API_CONTRACT_CONFIRM_OFFER_BY_USER = '/user/token'

    async getOfferForArt(payload) {
        const config = {
            onUploadProgress: progressEvent => {
                // console.info('onUploadProgress', progressEvent)
                // Do whatever you want with the native progress event
            },

            // `onDownloadProgress` allows handling of progress events for downloads
            // browser only
            onDownloadProgress: progressEvent => {
                // Do whatever you want with the native progress event
                // console.info('onDownloadProgress', progressEvent)
            },
            timeout: 6000,
        }

        return HTTP.post(this.API_CONTRACT_OFFER_BY_USER, payload, {}, config).catch(err => Promise.reject(err))
    }

    async confirmOfferForArt(payload) {
        const config = {
            onUploadProgress: progressEvent => {
                // console.info('onUploadProgress', progressEvent)
                // Do whatever you want with the native progress event
            },

            // `onDownloadProgress` allows handling of progress events for downloads
            // browser only
            onDownloadProgress: progressEvent => {
                // Do whatever you want with the native progress event
                // console.info('onDownloadProgress', progressEvent)
            },
            timeout: 6000,
        }

        return HTTP.post(this.API_CONTRACT_CONFIRM_OFFER_BY_USER, payload, {}, config).catch(err => Promise.reject(err))
    }
}
