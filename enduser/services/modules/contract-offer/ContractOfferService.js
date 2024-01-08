import http from '@/utils/http'
import BaseService from '~/services/BaseService'

const HTTP = new http()

export class ContractOfferService extends BaseService {
    API = '/user/'

    get_list_contract_offer_by_user(payload) {
        return HTTP.get('/user/contract-offer/user/'+ payload.id, payload)
    }
}
