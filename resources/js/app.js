import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import {createGtm} from "vue-gtm";
import VueTheMask from 'vue-the-mask';
import { Money3Directive } from 'v-money3';
import Skeleton from '@brayamvalero/vue3-skeleton'
import '@brayamvalero/vue3-skeleton/dist/style.css'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

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
            .use(Toast)
            .use(
                createGtm({
                    id: 'GTM-P2TRXHK3',
                    enabled: true,
                    debug: false,
                })
            )
            .use(VueTheMask)
            .use(Skeleton)
            .directive('money3', Money3Directive)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
