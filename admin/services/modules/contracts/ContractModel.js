import {get} from 'lodash'

export class ContractModel {
    constructor(data) {
        this.id = get(data, 'id', null)
        this.contract_offer_id = get(data, 'contract_offer_id', null)
        this.name = get(data, 'name', null)
        this.image_url = get(data, 'image_url', null)
        this.description = get(data, 'description', null)
        this.token_url = get(data, 'token_url', null)
        this.address_contract = get(data, 'address_contract', null)
        this.token_contract = get(data, 'token_contract', null)
        this.gas_fee = get(data, 'gas_fee', null)
        this.status = get(data, 'status', null)
        this.created_at = get(data, 'created_at', null)
        this.updated_at = get(data, 'updated_at', null)
    }
}
