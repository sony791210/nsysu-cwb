import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from './components/Home';
import News from './components/News';
import About from './components/About';
import Activities from './components/Activities';
import Service from './components/Service';
import JoinUs from './components/JoinUs';
import Tide from './components/Tide';
import Traffic from './components/Traffic';
import Faq from './components/Faq';
import Contact from './components/Contact';
import NewsDetail from './components/NewsDetail';

const routerPush = VueRouter.prototype.push
VueRouter.prototype.push = function push(location) {
  return routerPush.call(this, location).catch(error=> error)
}

Vue.use(VueRouter);
const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path:'/',
            name: 'home',
            component: Home
        },
        {
            path:'/news',
            name: 'news',
            component: News
        },
        {
            path:'/news/:id',
            component: NewsDetail
        },
        {
            path:'/about',
            name: 'about',
            component: About
        },
        {
            path:'/about/tide',
            name: 'tide',
            component: Tide
        },
        {
            path:'/activities',
            name: 'activities',
            component: Activities
        },
        {
            path:'/service',
            name: 'service',
            component: Service
        },
        {
            path:'/joinUs',
            name: 'joinUs',
            component: JoinUs
        },
        {
            path:'/traffic',
            name: 'traffic',
            component: Traffic
        },
        {
            path:'/faq',
            name: 'faq',
            component: Faq
        },
        {
            path:'/contact',
            name: 'contact',
            component: Contact
        }
    ],
    scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 }
    }
});



export default router;