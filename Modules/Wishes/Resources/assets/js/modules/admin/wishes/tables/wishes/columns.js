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
    name: '__component:custom-status',
    title: window.Lang.get('tables.status'),
    sortField: 'status',
    visible: true
  },
  {
    name: '__component:custom-link-by-title',
    title: window.Lang.get('tables.title'),
    sortField: 'title',
    visible: true
  },
  {
    name: 'owner.full_name',
    title: window.Lang.get('tables.owner'),
    visible: false
  },
  {
    name: 'owner.email',
    title: window.Lang.get('tables.email'),
    visible: true
  },
  {
    name: 'whitelabel.display_name',
    title: window.Lang.get('tables.whitelabel'),
    visible: true
  },
  {
    name: 'group.display_name',
    title: window.Lang.get('tables.group'),
    visible: true
  },
  {
    name: 'airport',
    title: window.Lang.get('tables.airport'),
    sortField: 'airport',
    visible: false
  },
  {
    name: 'destination',
    title: window.Lang.get('tables.destination'),
    sortField: 'destination',
    visible: false
  },
  {
    name: 'earliest_start',
    title: window.Lang.get('tables.earliest_start'),
    sortField: 'earliest_start',
    callback: 'formatDate|DD.MM.YYYY',
    visible: false
  },
  {
    name: 'latest_return',
    title: window.Lang.get('tables.latest_return'),
    callback: 'formatDate|DD.MM.YYYY',
    sortField: 'latest_return',
    visible: false
  },
  {
    name: 'adults',
    title: window.Lang.get('tables.adults'),
    sortField: 'adults',
    visible: false
  },
  {
    name: 'kids',
    title: window.Lang.get('tables.kids'),
    sortField: 'kids',
    visible: false
  },
  {
    name: 'budget',
    title: window.Lang.get('tables.budget'),
    sortField: 'budget',
    callback: 'formatNumber',
    visible: false
  },
  {
    name: 'category',
    title: window.Lang.get('tables.category'),
    sortField: 'category',
    visible: false
  },
  {
    name: 'duration',
    title: window.Lang.get('tables.duration'),
    sortField: 'duration',
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
