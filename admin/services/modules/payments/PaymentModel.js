import { get } from 'lodash'

export class PaymentModel {
    constructor (data) {
    this.id = get(data, 'id', null)
    this.contract_offer_id = get(data, 'contract_offer_id', null)
    this.contract_nft_id = get(data, 'contract_nft_id', null)
    this.dad_price = get(data, 'dad_price', null)
    this.artist_price = get(data, 'artist_price', null)
    this.status = get(data, 'status', null)
    this.created_at = get(data, 'created_at', null)
    this.updated_at = get(data, 'updated_at', null)
    }
}
