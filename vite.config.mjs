import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [

                'resources/css/app.css',
                'resources/css/fonts.css',
                'resources/css/toast.css',
                'resources/css/variables.css',

                'resources/css/admin/dashboard.css',
                'resources/css/admin/profile.css',

                'resources/css/admin/contractors/create.css',
                'resources/css/admin/contractors/edit.css',
                'resources/css/admin/contractors/index.css',
                'resources/css/admin/contractors/show.css',

                'resources/css/admin/incoming_entities/create.css',
                'resources/css/admin/incoming_entities/edit.css',
                'resources/css/admin/incoming_entities/index.css',
                'resources/css/admin/incoming_entities/show.css',

                'resources/css/admin/roles/create.css',
                'resources/css/admin/roles/edit.css',
                'resources/css/admin/roles/index.css',
                'resources/css/admin/roles/show.css',

                'resources/css/admin/users/create.css',
                'resources/css/admin/users/edit.css',
                'resources/css/admin/users/index.css',
                'resources/css/admin/users/show.css',

                'resources/css/auth/login.css',

                'resources/css/projects/create.css',
                'resources/css/projects/edit.css',
                'resources/css/projects/index.css',
                'resources/css/projects/show.css',

                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
