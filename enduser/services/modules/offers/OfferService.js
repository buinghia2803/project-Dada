import BaseService from "@/services/BaseService";
import http from "@/utils/http";

const HTTP = new http();
export class OfferService extends BaseService {
    API = "user/contract-offer";
}
