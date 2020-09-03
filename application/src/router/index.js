import Vue from 'vue';
import Router from 'vue-router';
Vue.use(Router);

const routes = [
  {
    name: 'marketplace',
    path: '/',
    component: () =>
      import(
        /* webpackChunkName: "marketplace" */ '@/components/marketplace/App'
      ),
    alias: '/index'
  },
  {
    name: 'home',
    path: '/home',
    component: () =>
      import(/* webpackChunkName: "home" */ '@/components/home/App')
  },
  {
    name: 'dashboard',
    path: '/dashboard',
    component: () =>
      import(/* webpackChunkName: "dashboard" */ '@/components/dashboards/App')
  },
  {
    name: 'courses',
    path: '/courses',
    component: () =>
      import(/* webpackChunkName: "courses" */ '@/components/courses/App')
  },
  {
    name: 'calendar',
    path: '/calendar',
    component: () =>
      import(/* webpackChunkName: "calendar" */ '@/components/calendar/App')
  },
  {
    name: 'invalidsession',
    path: '/invalidsession',
    component: () =>
      import(
        /* webpackChunkName: "invalidsession" */ '@/components/invalidsession/App'
      )
  },
  {
    name: 'categories',
    path: '/categories',
    component: () =>
      import(/* webpackChunkName: "categories" */ '@/components/categories/App')
  },
  {
    name: 'certificates',
    path: '/certificates',
    component: () =>
      import(
        /* webpackChunkName: "certificates" */ '@/components/certificates/App'
      )
  },
  {
    name: 'corrections',
    path: '/corrections',
    component: () =>
      import(
        /* webpackChunkName: "corrections" */ '@/components/corrections/App'
      )
  },
  {
    name: 'editcourse',
    path: '/editcourse/:id',
    component: () =>
      import(/* webpackChunkName: "editcourse" */ '@/components/editcourse/App')
  },
  {
    name: 'editprogram',
    path: '/editprogram/:id',
    component: () =>
      import(
        /* webpackChunkName: "editprogram" */ '@/components/editprogram/App'
      )
  },
  {
    name: 'auth',
    path: '/auth/:jwt',
    component: () =>
      import(/* webpackChunkName: "auth" */ '@/components/auth/App')
  },
  {
    name: 'group',
    path: '/group/:id',
    component: () =>
      import(/* webpackChunkName: "group" */ '@/components/group/App')
  },
  {
    name: 'groups',
    path: '/groups',
    component: () =>
      import(/* webpackChunkName: "groups" */ '@/components/groups/App')
  },
  {
    name: 'helpcenter',
    path: '/helpcenter',
    component: () =>
      import(/* webpackChunkName: "helpcenter" */ '@/components/helpcenter/App')
  },
  {
    name: 'integrations',
    path: '/integrations',
    component: () =>
      import(
        /* webpackChunkName: "integrations" */ '@/components/integrations/App'
      )
  },
  {
    name: 'leads',
    path: '/leads',
    component: () =>
      import(/* webpackChunkName: "leads" */ '@/components/leads/App')
  },
  {
    name: 'newcourse',
    path: '/newcourse',
    component: () =>
      import(/* webpackChunkName: "newcourse" */ '@/components/newcourse/App')
  },
  {
    name: 'newprogram',
    path: '/newprogram',
    component: () =>
      import(/* webpackChunkName: "newprogram" */ '@/components/newprogram/App')
  },
  {
    name: 'plans',
    path: '/plans',
    component: () =>
      import(/* webpackChunkName: "plans" */ '@/components/plans/App')
  },
  {
    name: 'product',
    path: '/product/:title',
    component: () =>
      import(/* webpackChunkName: "product" */ '@/components/product/App')
  },
  {
    name: 'products',
    path: '/products',
    component: () =>
      import(/* webpackChunkName: "products" */ '@/components/products/App')
  },
  {
    name: 'profile',
    path: '/profile',
    component: () =>
      import(/* webpackChunkName: "profile" */ '@/components/profile/App')
  },
  {
    name: 'programs',
    path: '/programs',
    component: () =>
      import(/* webpackChunkName: "programs" */ '@/components/programs/App')
  },
  {
    name: 'purchase',
    path: '/purchase/:status/:id',
    component: () =>
      import(
        /* webpackChunkName: "purchaseinprocess" */ '@/components/purchase/App'
      )
  },
  {
    name: 'records',
    path: '/records',
    component: () =>
      import(/* webpackChunkName: "records" */ '@/components/records/App')
  },
  {
    name: 'settings',
    path: '/settings',
    component: () =>
      import(/* webpackChunkName: "settings" */ '@/components/settings/App')
  },
  {
    name: 'site',
    path: '/site',
    component: () =>
      import(/* webpackChunkName: "site" */ '@/components/site/App')
  },
  {
    name: 'user',
    path: '/user/:id',
    component: () =>
      import(/* webpackChunkName: "user" */ '@/components/user/App')
  },
  {
    name: 'users',
    path: '/users',
    component: () =>
      import(/* webpackChunkName: "users" */ '@/components/users/App')
  },
  {
    name: 'viewcourse',
    path: '/viewcourse/:id',
    component: () =>
      import(/* webpackChunkName: "viewcourse" */ '@/components/viewcourse/App')
  },
  {
    name: 'viewprogram',
    path: '/viewprogram/:id',
    component: () =>
      import(
        /* webpackChunkName: "viewprogram" */ '@/components/viewprogram/App'
      )
  },
  {
    name: '404',
    path: '*',
    component: () =>
      import(/* webpackChunkName: "404" */ '@/components/404/App')
  }
];

const router = new Router({
  routes,
  mode: 'history',
  scrollBehavior() {
    return { x: 0, y: 0 };
  }
});
export default router;
