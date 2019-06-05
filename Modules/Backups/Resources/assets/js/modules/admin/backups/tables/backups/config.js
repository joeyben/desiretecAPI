import Columns from './columns'
import sort from './sort'
import Detail from './Detail'
import Actions from './Actions'
import CustomLinkById from './CustomLinkById'
import CustomLinkByName from './CustomLinkByName'
import CustomUser from './CustomUser'
export default {
  perPage: 10,
  fields: Columns,
  sortOrder: sort,
  moreParams: {},
  detail: Detail,
  actions: Actions,
  customLinkById: CustomLinkById,
  customLinkByName: CustomLinkByName,
  customUser: CustomUser
}
