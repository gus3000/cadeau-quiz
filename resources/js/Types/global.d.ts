import { PageProps as InertiaPageProps } from '@inertiajs/core';
import { AxiosInstance } from 'axios';
import ziggyRoute, { Config as ZiggyConfig } from 'ziggy-js';
import { PageProps as AppPageProps } from './';
import {} from 'twitch-ext'

declare global {
    interface Window {
        axios: AxiosInstance;
        Twitch: Twitch;
    }

    var route: typeof ziggyRoute;
    var Ziggy: ZiggyConfig;
    var Pusher: Pusher;
    var Echo: Echo;
    var axios: AxiosInstance;
}

declare module 'vue' {
    interface ComponentCustomProperties {
        route: typeof ziggyRoute;
    }
}

declare module '@inertiajs/core' {
    interface PageProps extends InertiaPageProps, AppPageProps {}
}
