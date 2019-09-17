export default [
  {
    name: '__checkbox'
  },
  {
    name: '__component:custom-link-by-id',
    title: window.Lang.get('tables.id'),
    sortField: 'id',
    visible: true
  },
  {
    name: '__component:custom-link-by-name',
    title: window.Lang.get('tables.name'),
    sortField: 'title',
    visible: true
  },
  {
    name: 'region_code',
    title: window.Lang.get('tables.region_code'),
    sortField: 'region_code',
    visible: true
  },
  {
    name: 'country_code',
    title: window.Lang.get('tables.country_code'),
    sortField: 'country_code',
    visible: true
  },
  {
    name: 'type',
    title: window.Lang.get('tables.type'),
    sortField: 'type',
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
