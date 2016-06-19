Vue.use(VueRouter);

import store            from './components/vuex/store'
import {isTokenValid}   from './components/vuex/getters';

import exercise         from './components/pages/exercise/exercise';
import login            from './components/pages/login/login';
import register         from './components/pages/register/register';
import dashboard        from './components/pages/dashboard/dashboard';
import statistics       from './components/pages/statistics/statistics';
import badges           from './components/pages/badges/badges';
import changepassword   from './components/pages/changepassword/changepassword';
import profile          from './components/pages/profile/profile';

var router = new VueRouter({
    history: false,
});
router.map({
    'exercise': {
        name: 'exercise',
        component: exercise
    },
    'login': {
        name: 'login',
        component: login,
        authpage: true
    },
    'register': {
        name: 'register',
        component: register,
        authpage: true
    },
    'dashboard': {
        name: 'dashboard',
        component: dashboard
    },
    'statistics': {
        name: 'statistics',
        component: statistics
    },
    'badges': {
        name: 'badges',
        component: badges
    },
    'changepassword': {
        name: 'changepassword',
        component: changepassword
    },
    'profile': {
        name: 'profile',
        component: profile
    }
});
router.redirect({
    '/': '/login'
});
router.beforeEach(function (transition) {
    if (!transition.to['authpage'] && !isTokenValid(store.state)) {
        transition.redirect('/login');
    }
    else if (transition.to['authpage'] && isTokenValid(store.state)) {
        transition.redirect('/dashboard');
    }
    transition.next();
});
export default router;