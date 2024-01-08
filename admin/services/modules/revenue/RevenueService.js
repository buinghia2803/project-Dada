import Http from '@/utils/http'
const HTTP = new Http();
import BaseService from '@/services/BaseService'

export class RevenueService extends BaseService {
    API_GET_OVER_VIEW_REVENUE = '/admin/revenue'
    API_GET_LIST_REVENUE = '/admin/revenue/by-list-user'

    getOverViewRevenue(data) {
        return HTTP.get(this.API_GET_OVER_VIEW_REVENUE, data);
    }

    getListRevenue(data) {
        return HTTP.get(this.API_GET_LIST_REVENUE, data, );
    }
}
