export default [
  {
    name: '__component:custom-link-by-id',
    title: window.Lang.get('tables.id'),
    sortField: 'id',
    visible: true
  },
  {
    name: '__component:custom-link-by-name',
    title: window.Lang.get('tables.name'),
    sortField: 'name',
    visible: true
  },
  {
    name: '__component:custom-permissions',
    title: window.Lang.get('tables.permissions'),
    visible: true
  },
  {
    name: '__component:custom-users',
    title: window.Lang.get('tables.users'),
    visible: true
  },
  {
    name: 'owner.full_name',
    title: window.Lang.get('tables.owner'),
    visible: false
  },
  {
    name: 'updated_at',
    title: window.Lang.get('tables.updated_at'),
    sortField: 'updated_at',
    callback: 'formatDate|D, MMM YYYY HH:mm',
    visible: false
  },
  {
    name: 'created_at',
    title: window.Lang.get('tables.created_at'),
    sortField: 'created_at',
    callback: 'formatDate|D, MMM YYYY HH:mm',
    visible: false
  },
  {
    name: '__component:custom-actions',
    title: 'Actions',
    titleClass: 'text-center',
    dataClass: 'text-center',
    visible: true
  }
]
