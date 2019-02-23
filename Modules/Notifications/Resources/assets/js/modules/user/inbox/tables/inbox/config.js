import Columns from './columns'
import sort from './sort'
import Detail from './Detail'
import Actions from './Actions'
import CustomUserLetter from './CustomUserLetter'
import CustomLinkByFrom from './CustomLinkByFrom'
import CustomStatus from './CustomStatus'
export default {
  perPage: 10,
  fields: Columns,
  sortOrder: sort,
  moreParams: {},
  detail: Detail,
  actions: Actions,
  customUserLetter: CustomUserLetter,
  customLinkByFrom: CustomLinkByFrom,
  customStatus: CustomStatus
}
