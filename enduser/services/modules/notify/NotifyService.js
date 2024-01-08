import BaseService from "@/services/BaseService";
import http from "@/utils/http";

const HTTP = new http();
export class NotifyService extends BaseService {
    API = "/user/notification-user";

    API_UPDATE_STATUS_NOTIFY = "/user/notification-update-status";

    /**
     * updateNotificationByUser
     * @param {*} data
     * @returns
     */
     updateStatusNotificationByUser(data) {
        return HTTP.post(this.API_UPDATE_STATUS_NOTIFY, data);
    }
}
