import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

const routes = [
    {
        name: 'marketplace',
        path: '/',
        component: () => 
        import(/* webpackChunkName: "marketplace" */ '@/pages/marketplace/App'),    
    },
    {
        name: 'home',
        path: '/home',
        component: () => 
        import(/* webpackChunkName: "home" */ '@/pages/home/App'), 
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: () => 
        import(/* webpackChunkName: "dashboard" */ '@/pages/dashboard/App'), 
    },
    {
        name: 'courses',
        path: '/courses',
        component: () => 
        import(/* webpackChunkName: "courses" */ '@/pages/courses/App'), 
    },
    {
        name: 'calendar',
        path: '/calendar',
        component: () => 
        import(/* webpackChunkName: "calendar" */ '@/pages/calendar/App'), 
    },
    {
        name: 'invalidsession',
        path: '/invalidsession',
        component: () => 
        import(/* webpackChunkName: "invalidsession" */ '@/pages/invalidsession/App'), 
    },
    {
        name: 'categories',
        path: '/categories',
        component: () => 
        import(/* webpackChunkName: "categories" */ '@/pages/categories/App'), 
    },
    {
        name: 'certificates',
        path: '/certificates',
        component: () => 
        import(/* webpackChunkName: "certificates" */ '@/pages/certificates/App'), 
    },
    {
        name: 'corrections',
        path: '/corrections',
        component: () => 
        import(/* webpackChunkName: "corrections" */ '@/pages/corrections/App'), 
    },
    {
        name: 'editcourse',
        path: '/editcourse',
        component: () => 
        import(/* webpackChunkName: "editcourse" */ '@/pages/editcourse/App'), 
    },
    {
        name: 'group',
        path: '/group',
        component: () => 
        import(/* webpackChunkName: "group" */ '@/pages/group/App'), 
    },
    {
        name: 'groups',
        path: '/groups',
        component: () => 
        import(/* webpackChunkName: "groups" */ '@/pages/groups/App'), 
    },
    {
        name: 'helpcenter',
        path: '/helpcenter',
        component: () => 
        import(/* webpackChunkName: "helpcenter" */ '@/pages/helpcenter/App'), 
    },
    {
        name: 'integrations',
        path: '/integrations',
        component: () => 
        import(/* webpackChunkName: "integrations" */ '@/pages/integrations/App'), 
    },
    {
        name: 'leads',
        path: '/leads',
        component: () => 
        import(/* webpackChunkName: "leads" */ '@/pages/leads/App'), 
    },
    {
        name: 'newcourse',
        path: '/newcourse',
        component: () => 
        import(/* webpackChunkName: "newcourse" */ '@/pages/newcourse/App'), 
    },
    {
        name: 'newprogram',
        path: '/newprogram',
        component: () => 
        import(/* webpackChunkName: "newprogram" */ '@/pages/newprogram/App'), 
    },
    {
        name: 'plans',
        path: '/plans',
        component: () => 
        import(/* webpackChunkName: "plans" */ '@/pages/plans/App'), 
    },
    {
        name: 'product',
        path: '/product',
        component: () => 
        import(/* webpackChunkName: "product" */ '@/pages/product/App'), 
    },
    {
        name: 'products',
        path: '/products',
        component: () => 
        import(/* webpackChunkName: "products" */ '@/pages/products/App'), 
    },
    {
        name: 'profile',
        path: '/profile',
        component: () => 
        import(/* webpackChunkName: "profile" */ '@/pages/profile/App'), 
    },
    {
        name: 'programs',
        path: '/programs',
        component: () => 
        import(/* webpackChunkName: "programs" */ '@/pages/programs/App'), 
    },
    {
        name: 'purchaseinprocess',
        path: '/purchaseinprocess',
        component: () => 
        import(/* webpackChunkName: "purchaseinprocess" */ '@/pages/purchaseinprocess/App'), 
    },
    {
        name: 'purchasesuccess',
        path: '/purchasesuccess',
        component: () => 
        import(/* webpackChunkName: "purchasesuccess" */ '@/pages/purchasesuccess/App'), 
    },
    {
        name: 'records',
        path: '/records',
        component: () => 
        import(/* webpackChunkName: "records" */ '@/pages/records/App'), 
    },
    {
        name: 'settings',
        path: '/settings',
        component: () => 
        import(/* webpackChunkName: "settings" */ '@/pages/settings/App'), 
    },
    {
        name: 'site',
        path: '/site',
        component: () => 
        import(/* webpackChunkName: "site" */ '@/pages/site/App'), 
    },
    {
        name: 'user',
        path: '/user',
        component: () => 
        import(/* webpackChunkName: "user" */ '@/pages/user/App'), 
    },
    {
        name: 'users', 
        path: '/users',
        component: () => 
        import(/* webpackChunkName: "users" */ '@/pages/users/App'), 
    },
    {
        name: 'viewcourse',
        path: '/viewcourse',
        component: () => 
        import(/* webpackChunkName: "viewcourse" */ '@/pages/viewcourse/App'), 
    },
    {
        name: 'viewprogram',
        path: '/viewprogram',
        component: () => 
        import(/* webpackChunkName: "viewprogram" */ '@/pages/viewprogram/App'), 
    },
    {
        name: '404',
        path: '*',
        component: () => 
        import(/* webpackChunkName: "404" */ '@/pages/404/App'), 
    },
]

const router = new Router({routes, mode: 'history'})
export default router       