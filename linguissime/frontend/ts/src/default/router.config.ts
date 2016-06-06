Vue.use(VueRouter);
import exercise from './components/exercise/exercise';
import login    from './components/login/login';

var router = new VueRouter({
    history: true,
});
router.map({
    'exercise': {
        name: 'exercise',
        component: exercise
    },
    'login': {
        name: 'login',
        component: login
    }
});
export default router;