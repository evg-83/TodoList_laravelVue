import * as VueRouter from "vue-router";

const routes = [
  {
    path: "/register",
    name: "register",
    component: () => import("../components/Auth/RegisterComponent.vue"),
  },
  {
    path: "/login",
    name: "login",
    component: () => import("../components/Auth/LoginComponent.vue"),
  },
  {
    path: "/",
    redirect: "/home",
    component: () => import("../components/HeaderComponent.vue"),
    children: [
      {
        path: '/home',
        name: "home",
        component: () => import("../components/Todo/HomeComponent.vue"),
      },
      // {
      //   path: '/home',
      //   name: "home",
      //   component: () => import("../components/Todo/HomeComponent.vue"),
      // },
    ],
  },
];

const router = VueRouter.createRouter({
  history: VueRouter.createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem("x_xsrf_token");

  if (!token) {
    if (to.name === "login" || to.name === "register") {
      return next();
    } else {
      return next({
        name: "login",
      });
    }
  }

  if (to.name === "login" || (to.name === "register" && token)) {
    return next({
      name: "home",
    });
  }

  next();
});

export default router;
