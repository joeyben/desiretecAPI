import Columns from './columns'
import sort from './sort'
import Detail from './Detail'
import Actions from './Actions'
import CustomLinkById from './CustomLinkById'
import CustomLinkByTitle from './CustomLinkByTitle'
import CustomStatus from './CustomStatus'
import CustomUser from './CustomUser'
export default {
  perPage: 10,
  fields: Columns,
  sortOrder: sort,
  moreParams: {},
  detail: Detail,
  actions: Actions,
  customLinkById: CustomLinkById,
  CustomLinkByTitle: CustomLinkByTitle,
  CustomStatus: CustomStatus,
  customUser: CustomUser
}
