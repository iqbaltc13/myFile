Laravel/Nuxt.js integration

Instalation guide:

1. $ composer create-project laravel/laravel laravel 5.8 --prefer-dist
2. $ cd laravel/
3. $ composer require pallares/laravel-nuxt
4. create 'nuxt' folder in 'laravel/resources/' and copy 'assets, components, data, layouts, middleware, pages, plugins, static, store' folders from 'scutum/admin/vuejs/src/' to 'laravel/resources/nuxt/'
5. copy files from 'scutum/admin/vuejs/laravel-nuxt/' to 'laravel/' (replace files)
6. $ yarn install --ignore-engines
7. $ yarn start (dev)
7a. $ yarn start --hostname remote-server-ip (if you are using remote server) (dev)
8. $ yarn build (dist)
8a. after build copy files/folder from 'laravel/resources/nuxt/static/' to 'laravel/public/'