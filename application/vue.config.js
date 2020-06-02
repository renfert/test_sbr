const path = require('path');
module.exports = {
    configureWebpack: {
        resolve: {
            alias: {
                "components": path.resolve(__dirname, 'src/components/'),
                "assets": path.resolve(__dirname, '../assets/'),
            }     
        },
    },
    devServer: {
        watchOptions: {
            ignored: [
                path.resolve(__dirname, 'dist'),
                path.resolve(__dirname, '**../../../assets/uploads/testimonial'),
                path.resolve(__dirname, '**../../../assets/uploads/builder/header'),
                path.resolve(__dirname, '**../../../assets/uploads/builder/body'),
                path.resolve(__dirname, '**../../../assets/uploads/settings'),
            ]
        }
    },
    publicPath: process.env.NODE_ENV === 'production' ? '/application/views/' : '/',
    outputDir: './views',
     pages: {
        'home': {
            entry: './src/pages/home/main.js',
            template: 'index.html',
            filename: 'index.html',
        },
        'categories': {
            entry: './src/pages/categories/main.js',
            template: 'categories.html',
            filename: 'categories.html',
        },
        'groups': {
            entry: './src/pages/groups/main.js',
            template: 'groups.html',
            filename: 'groups.html',
        },
        'helpcenter': {
            entry: './src/pages/helpcenter/main.js',
            template: 'helpcenter.html',
            filename: 'helpcenter.html',
        },
        'plans': {
            entry: './src/pages/plans/main.js',
            template: 'plans.html',
            filename: 'plans.html',
        },
        'newcourse': {
            entry: './src/pages/newcourse/main.js',
            template: 'newcourse.html',
            filename: 'newcourse.html',
        },
        'editcourse': {
            entry: './src/pages/editcourse/main.js',
            template: 'editcourse.html',
            filename: 'editcourse.html',
        },
        'users': {
            entry: './src/pages/users/main.js',
            template: 'users.html',
            filename: 'users.html',
        },
        'user': {
            entry: './src/pages/user/main.js',
            template: 'user.html',
            filename: 'user.html',
        },
        'settings': {
            entry: './src/pages/settings/main.js',
            template: 'settings.html',
            filename: 'settings.html',
        },
        'courses': {
            entry: './src/pages/courses/main.js',
            template: 'courses.html',
            filename: 'courses.html',
        },
        'site':{
            entry: './src/pages/site/main.js',
            template: 'site.html',
            filename: 'site.html',
        },
        'integrations':{
            entry: './src/pages/integrations/main.js',
            template: 'integrations.html',
            filename: 'integrations.html',
        },
        'viewcourse':{
            entry: './src/pages/viewcourse/main.js',
            template: 'viewcourse.html',
            filename: 'viewcourse.html',
        },
        'viewprogram':{
            entry: './src/pages/viewprogram/main.js',
            template: 'viewprogram.html',
            filename: 'viewprogram.html',
        },
        'leads':{
            entry: './src/pages/leads/main.js',
            template: 'leads.html',
            filename: 'leads.html',
        },
        'group':{
            entry: './src/pages/group/main.js',
            template: 'group.html',
            filename: 'group.html',
        },
        'programs':{
            entry: './src/pages/programs/main.js',
            template: 'programs.html',
            filename: 'programs.html',
        },
        'newprogram':{
            entry: './src/pages/newprogram/main.js',
            template: 'newprogram.html',
            filename: 'newprogram.html',
        },
        'profile':{
            entry: './src/pages/profile/main.js',
            template: 'profile.html',
            filename: 'profile.html',
        },
        'dashboard':{
            entry: './src/pages/dashboard/main.js',
            template: 'dashboard.html',
            filename: 'dashboard.html',
        },
        'product':{
            entry: './src/pages/product/main.js',
            template: 'product.html',
            filename: 'product.html',
        },
        'products':{
            entry: './src/pages/products/main.js',
            template: 'products.html',
            filename: 'products.html',
        },
        'corrections': {
            entry: './src/pages/corrections/main.js',
            template: 'corrections.html',
            filename: 'corrections.html',
        },
        'certificates': {
            entry: './src/pages/certificates/main.js',
            template: 'certificates.html',
            filename: 'certificates.html',
        },
        'records': {
            entry: './src/pages/records/main.js',
            template: 'records.html',
            filename: 'records.html',
        },
        'calendar': {
            entry: './src/pages/calendar/main.js',
            template: 'calendar.html',
            filename: 'calendar.html',
        }
    }
}