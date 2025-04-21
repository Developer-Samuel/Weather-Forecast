import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import Layout from './Layout/App.vue';

createInertiaApp({
    resolve: async (name) => {
        const module = await import(/* @vite-ignore */ `./${name}.vue`);
        const page = module.default;
        page.layout = Layout;
        return page;
    },
    setup({ el, app, props }) {
        createApp({ render: () => h(app, props) }).mount(el);
    },
});
