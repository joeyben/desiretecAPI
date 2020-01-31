import Columns from './columns'
import sort from './sort'
import Detail from './Detail'
import Actions from './Actions'
import CustomLinkById from './CustomLinkById'
import CustomLinkByName from './CustomLinkByName'
import CustomStatus from './CustomStatus'
import CustomDefault from './CustomDefault'
import CustomUsers from './CustomUsers'
export default {
  perPage: 10,
  fields: Columns,
  sortOrder: sort,
  moreParams: {},
  detail: Detail,
  actions: Actions,
  customLinkById: CustomLinkById,
  CustomLinkByName: CustomLinkByName,
  CustomStatus: CustomStatus,
  CustomDefault: CustomDefault,
  customUsers: CustomUsers
}
