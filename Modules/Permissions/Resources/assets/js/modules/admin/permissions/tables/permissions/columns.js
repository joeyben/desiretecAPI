export default [
  {
    name: '__component:custom-link-by-id',
    title: window.Lang.get('tables.id'),
    sortField: 'id',
    visible: true
  },
  {
    name: '__component:custom-status',
    title: window.Lang.get('tables.status'),
    sortField: 'status',
    visible: true
  },
  {
    name: '__component:custom-link-by-name',
    title: window.Lang.get('tables.name'),
    sortField: 'name',
    visible: true
  },
  {
    name: 'display_name',
    title: window.Lang.get('tables.display_name'),
    sortField: 'display_name',
    visible: true
  },
  {
    name: 'owner.full_name',
    title: window.Lang.get('tables.owner'),
    visible: true
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
