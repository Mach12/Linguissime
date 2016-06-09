Vue.use(VueRouter);
import exercise from './components/exercise/exercise';
import login    from './components/login/login';
import register from './components/register/register';

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
    }
});
export default router;