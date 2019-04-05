export default [
  {
    name: 'locale',
    title: window.Lang.get('tables.locale'),
    sortField: 'locale',
    visible: true
  },
  {
    name: 'description',
    title: window.Lang.get('tables.description'),
    sortField: 'description',
    visible: true
  },
  {
    name: 'group',
    title: window.Lang.get('tables.group'),
    sortField: 'group',
    visible: true
  },
  {
    name: 'key',
    title: window.Lang.get('tables.key'),
    sortField: 'group',
    visible: true
  },
  {
    name: 'text',
    title: window.Lang.get('tables.text'),
    sortField: 'text',
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