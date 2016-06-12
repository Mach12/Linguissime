Vue.use(VueRouter);
import exercise     from './components/pages/exercise/exercise';
import login        from './components/pages/login/login';
import register     from './components/pages/register/register';
import dashboard    from './components/pages/dashboard/dashboard';

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
    }
});
export default router;