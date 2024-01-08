import { get } from 'lodash'

export class UserModel {
    constructor (data) {
        this.id = get(data, 'id', 0)
        this.public_address_main = get(data, 'public_address_main', '')
        this.public_address_sub = get(data, 'public_address_sub', '')
        this.contract_address = get(data, 'contract_address', '')
        this.email = get(data, 'email', '')
        this.full_name = get(data, 'full_name', '')
        this.image_url = get(data, 'image_url', '')
        this.positions = get(data, 'positions', '')
        this.description = get(data, 'description', '')
        this.type = get(data, 'type', 1)
        this.status = get(data, 'status', 1)
        this.count_contract = get(data, 'count_contract', 0)
        this.is_deleted = get(data, 'is_deleted', 0)
    }
}
