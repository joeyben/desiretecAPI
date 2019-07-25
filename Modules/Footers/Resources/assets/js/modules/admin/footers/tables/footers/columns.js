export default [
  {
    name: '__component:custom-link-by-id',
    title: window.Lang.get('tables.id'),
    sortField: 'id',
    visible: true
  },
  {
    name: 'name',
    title: window.Lang.get('tables.name'),
    sortField: 'name',
    visible: true
  },
  {
    name: 'url',
    title: window.Lang.get('tables.url'),
    sortField: 'url',
    visible: true
  },
  {
    name: 'position',
    title: window.Lang.get('tables.position'),
    sortField: 'position',
    visible: true
  },
  {
    name: 'whitelabel.display_name',
    title: window.Lang.get('tables.whitelabel'),
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
