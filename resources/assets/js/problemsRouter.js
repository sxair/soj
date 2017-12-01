export default [
    {path: '/problems', component: require('./problems/problems.vue')},
    {path: '/status', component: require('./problems/status.vue')},
    {path: '/rank', component: require('./problems/rank.vue')},
    {path: '/problem/:id', component: require('./components/showProblem.vue'), props: true},
    {path: '/submit/:id', component: require('./problems/submit.vue'), props: true},
    {path: '/showcode/:id', component: require('./problems/showCode.vue'), props:true}
]