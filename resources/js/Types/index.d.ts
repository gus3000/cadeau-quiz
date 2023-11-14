export interface User {
    id: number;
    name: string;
    twitch_id: number;
    admin: boolean;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};
