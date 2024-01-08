import { get } from 'lodash'

export class OfferModel {
    constructor (data) {
    this.id = get(data, 'id', null)
    this.dad_id = get(data, 'dad_id', null)
    this.artist_id = get(data, 'artist_id', null)
    this.email = get(data, 'email', null)
    this.date_start = get(data, 'date_start', null)
    this.date_end = get(data, 'date_end', null)
    this.selling_price = get(data, 'selling_price', null)
    this.dad_percent = get(data, 'dad_percent', null)
    this.artist_percent = get(data, 'artist_percent', null)
    this.dad_price = get(data, 'dad_price', null)
    this.artist_price = get(data, 'artist_price', null)
    this.system_price = get(data, 'system_price', null)
    this.opensea_price = get(data, 'opensea_price', null)
    this.system_percent = get(data, 'system_percent', null)
    this.opensea_percent = get(data, 'opensea_percent', null)
    this.responsibility = get(data, 'responsibility', null)
    this.contact_info = get(data, 'contact_info', null)
    this.status = get(data, 'status', null)
    this.created_at = get(data, 'created_at', null)
    this.updated_at = get(data, 'updated_at', null)
    }
}
