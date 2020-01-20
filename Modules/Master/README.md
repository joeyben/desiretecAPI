What to update when a new whitelabel is created:

DB locally:
- alter table whitelabels, column id
- alter table whitelabels, column domain
- create table for llanguage line, a duplicate language_lines table with updated name

config.php:
- id

layer.js:
- baseUrl
- cssPath
- matchesUrl

popup.blade.php:
- both urls in autocomplete()

.gitignore
- add module folder