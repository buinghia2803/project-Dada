import moment from "moment";
import {CONTRACT_STATUS} from "~/utils/constants";

export default {
  data() {
    return {
      paramter: {
        page: '1',
        limit: '10'
      }
    }
  },

  computed: {
  },

  watch: {
    /**
     * Watching changes of route
     */
  },

  methods: {

    /**
     * Replace query
     *
     * @param {Object} Data query
     */
    replaceQuery( data, merged = true ) {
      const query = {}
      const newQuery = merged ? { ...this.$route.query, ...data } : { ...data }
      Object.entries( newQuery ).forEach( ( [ key, value ] ) => {
        if ( value !== '' && value !== null && value !== undefined ) {
          query[ key ] = value
        }
      } )

      if ( JSON.stringify( query ) != JSON.stringify( this.$route.query ) ) {
        this.$router.push( { query: query } )
      }
      return query
    },

      /**
       * Get contract status
       *
       * @param record
       * @returns {*}
       */
      getContractStatus(record = {
          contractOffer: {
              date_end: ''
          }
      }) {
          let statusId = null;
          switch (record.status) {
              case 0:
              case 1:
                  statusId = 1;
                  break;
              case 2:
                  statusId = 2;
                  break;
              case 3:
                  if (record.contractOffer.date_end) {
                      let endDate = moment(record.contractOffer.date_end).format('YYYY-MM-DD');
                      let now = moment(new Date()).format('YYYY-MM-DD');
                      if (endDate < now) {
                          statusId = 4;
                          break;
                      }
                  }
                  if (record.contractOffer.status && record.contractOffer.status == 3) {
                      statusId = 5;
                      break;
                  }
                  statusId = 3;
                  break;
              case 4:
                  statusId = 3;
                  break;
              default:
                  statusId = 6;
          }
          const statusLabel = CONTRACT_STATUS.find(element => element.id == statusId);

          return statusLabel.label;
      }

  }
}
