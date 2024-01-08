import { get } from 'lodash'
import { PAGE_SIZES } from '../utils/constants'

export default class paginator {
  constructor(props) {
    this.total = get(props, 'total', 0)
    this.pageSize = get(props, 'pageSize', PAGE_SIZES[0])
    this.page = get(props, 'page', 1)
    this.doubleArrows = get(props, 'doubleArrows', true)
    this.arrows = get(props, 'arrows', true)
    this.dots = get(props, 'dots', true)
    this.size = get(props, 'size', null)
    this.align = get(props, 'align', 'end')
    this.disabled = get(props, 'disabled', false)
    this.itemName = get(props, 'itemName', '')
    this.currentPage = get(props, 'currentPage', 1)
    this.totalPage = Math.ceil(+this.total / +this.pageSize)
  }
}
