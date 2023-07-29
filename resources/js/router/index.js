import * as VueRouter from "vue-router";

const routes = [
  {
    path: "/users/register",
    name: "user.register",
    component: () => import("../components/User/RegisterComponent.vue"),
  },
  {
    path: "/users/login",
    name: "user.login",
    component: () => import("../components/User/LoginComponent.vue"),
  },
  {
    path: "/",
    redirect: "/home",
    component: () => import("../components/HeaderComponent.vue"),
    children: [
      {
        path: "/home",
        name: "home",
        component: () => import("../components/Todo/HomeComponent.vue"),
      },
      {
        path: "/profile",
        name: "user.profile",
        component: () => import("../components/User/ProfileComponent.vue"),
      },
      {
        path: "/:todolistId(\\d+)",
        name: "todolist",
        component: () => import("../components/Todo/TodolistComponent.vue"),
        props: true,
      },
      //TODO всегда нижний
      {
        path: "/:pathMatch(.*)*",
        name: "404",
        // TODO заменить компонент на 404ый!!!
        component: () => import("../components/Todo/HomeComponent.vue"),
      },
    ],
  },
];

const router = VueRouter.createRouter({
  history: VueRouter.createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const accessToken = localStorage.getItem("access_token");

  if (!accessToken) {
    if (to.name === "user.login" || to.name === "user.register") {
      return next();
    } else {
      return next({
        name: "user.login",
      });
    }
  }

  if (
    (to.name === "user.login" || to.name === "user.register") &&
    accessToken
  ) {
    return next({
      name: "home",
    });
  }

  next();
});

export default router;
