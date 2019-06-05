export default [
  {
    name: 'id',
    title: window.Lang.get('tables.id'),
    visible: true
  },
  {
    name: 'file_name',
    title: window.Lang.get('tables.name'),
    visible: true
  },
  {
    name: 'file_size',
    title: window.Lang.get('tables.size'),
    visible: true
  },
  {
    name: 'last_modified',
    title: window.Lang.get('tables.updated_at'),
    visible: false
  },
  {
    name: 'file_age',
    title: window.Lang.get('tables.age'),
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
