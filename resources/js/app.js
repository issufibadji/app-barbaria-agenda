import '../css/app.css';
import './bootstrap';
import '@fortawesome/fontawesome-free/css/all.min.css';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css'
import '@fortawesome/fontawesome-free/css/all.min.css'

const appName =
    import.meta.env.VITE_APP_NAME || 'AgendaBarbaria';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(toast)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});