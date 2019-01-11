export default [
  {
    name: '__component:custom-link-by-id',
    title: window.Lang.get('tables.id'),
    sortField: 'id',
    visible: true
  },
  {
    name: 'first_name',
    title: window.Lang.get('tables.first_name'),
    sortField: 'first_name',
    visible: true
  },
  {
    name: 'last_name',
    title: window.Lang.get('tables.last_name'),
    sortField: 'last_name',
    visible: true
  },
  {
    name: 'email',
    title: window.Lang.get('tables.email'),
    sortField: 'email',
    visible: true
  },
  {
    name: '__component:custom-confirmed',
    title: window.Lang.get('tables.confirmed'),
    sortField: 'confirmed',
    visible: true
  },
  {
    name: '__component:custom-status',
    title: window.Lang.get('tables.status'),
    sortField: 'status',
    visible: true
  },
  {
    name: '__component:custom-roles',
    title: window.Lang.get('tables.roles'),
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
