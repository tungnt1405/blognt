const routes = [
    { path: "/", name: "Home", component: () => import("../views/index.vue") },
    {
        path: "/about",
        name: "About",
        component: () => import("../views/about/index.vue"),
    },
];
export default routes;
