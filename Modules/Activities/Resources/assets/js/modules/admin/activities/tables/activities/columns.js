export default [
  {
        name: 'id',
            title: window.Lang.get('tables.id'),
            sortField: 'id'
    },
    {
        name: 'created_at',
        title: window.Lang.get('tables.created_at'),
        sortField: 'created_at'
    },
    {
        name: 'description',
        title: window.Lang.get('tables.action'),
        sortField: 'description'
    },
    {
        name: 'causer.full_name',
        title: window.Lang.get('tables.causer')
    },
    {
        name: '__component:custom-actions',
        title: 'Actions',
        titleClass: 'text-center',
        dataClass: 'text-center'
    }
    ]
