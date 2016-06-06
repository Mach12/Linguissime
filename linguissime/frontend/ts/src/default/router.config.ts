Vue.use(VueRouter);
import exercise from './components/exercise/exercise';

var router = new VueRouter({
    history: true,
});
router.map({
    'exercise': {
        name: 'exercise',
        component: exercise
    }
});
export default router;