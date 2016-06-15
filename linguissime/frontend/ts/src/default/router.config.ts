Vue.use(VueRouter);
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
        component: login
    },
    'register': {
        name: 'register',
        component: register
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
export default router;