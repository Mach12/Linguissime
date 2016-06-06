Vue.use(VueRouter);
import one      from './components/partone/partone';
import two      from './components/parttwo/parttwo';
import exercise from './components/exercise/exercise';

var router = new VueRouter({
    history: true,
});
router.map({
    'partone': {
        name: 'one',
        component:one
        
    },
    'parttwo':{
        name: 'two',
        component:two
    },
    'exercise': {
        name: 'exercise',
        component: exercise
    }
});
export default router;