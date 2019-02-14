export default [
  {
    name: '__checkbox'
  },
  {
    name: '__component:custom-status',
    title: window.Lang.get('tables.status'),
    visible: true
  },
  {
    name: '__component:custom-link-by-from',
    title: window.Lang.get('tables.from'),
    visible: true
  },
  {
    name: 'message',
    title: window.Lang.get('tables.message'),
    sortField: 'message',
    visible: true
  },
  {
    name: 'created_at',
    title: window.Lang.get('tables.ago'),
    sortField: 'created_at',
    callback: 'fromNow',
    visible: true
  },
  {
    name: 'created_at',
    title: window.Lang.get('tables.when'),
    sortField: 'created_at',
    callback: 'formatDate|D, MMM YYYY HH:mm',
    visible: true
  },
  {
    name: '__component:custom-actions',
    title: 'Actions',
    titleClass: 'text-center',
    dataClass: 'text-center',
    visible: true
  }
]
