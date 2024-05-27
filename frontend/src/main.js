import { createApp } from 'vue'
import App from './App.vue'
import { createRouter, createWebHistory } from 'vue-router'
import './index.css'
import store from './store'
import MainPage from './views/MainPage.vue'
import AuthForm from './views/userAuthForm.vue'
import registerPage from './views/registerPage.vue'
import addBooks from './views/addBooks.vue'
import editBooks from './views/editBooks.vue'

const router = createRouter({
  routes: [
    {
      path: '/',
      component: MainPage
    },
    {
      path: '/auth',
      component: AuthForm
    },
    {
      path: '/registerPage',
      component: registerPage
    },
    {
      path: '/addBooks',
      component: addBooks
    },
    {
      path: '/editBooks/:id',
      component: editBooks
    }
  ],
  history: createWebHistory()
})

const app = createApp(App)

app.use(router)
app.mount('#app')
app.use(store)
