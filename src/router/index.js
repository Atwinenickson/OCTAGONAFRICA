import { createWebHistory, createRouter } from "vue-router"
import Login from '../views/Login.vue'
import Profile from '../views/Profile.vue'
import PageNotFound from '../views/PageNotFound.vue'
import Signup from '../views/Signup.vue'

// Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Login',
    component: Login
  },
  {
    path: '/profile',
    name: 'Profile',
    component: Profile
  },
  {
    path: '/signup',
    name: 'Signup',
    component: Signup
  },
  ,
  {
    path: '/:catchAll(.*)*',
    name: "PageNotFound",
    component: PageNotFound,
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router