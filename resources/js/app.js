import './bootstrap';
require('./unit');

$('.js-delete-item').on('click', function() {
    return confirm('Remove?');
})

import {createApp} from 'vue';

import CustomEditorComponent from './Editor/CustomEditorComponent';
import TaskComponent from "./TaskComponent.vue";
import UsersCompletedTask from "./UsersCompletedTask.vue";
import PaginationComponent from "./PaginationComponent.vue";
import TopComponent from "./top.vue"
import DashboardStats from "./DashboardStats.vue";
import UserGameStatComponent from "./UserGameStatComponent.vue";
import UserLanguagesComponent from "./UserLanguagesComponent.vue";
import UserGrowthComponent from "./UserGrowthComponent.vue";
import GameLaunchComponent from "./GameLaunchComponent.vue";

const app = createApp({});

app
    .component('custom-editor-component', CustomEditorComponent)
    .component('task-component', TaskComponent)
    .component('user-completed-task-component', UsersCompletedTask)
    .component('pagination-component', PaginationComponent)
    .component('top-component', TopComponent)
    .component('dashboard-stats-component', DashboardStats)
    .component('user-game-stat-component', UserGameStatComponent)
    .component('user-languages-chart-component', UserLanguagesComponent)
    .component('user-growth-chart-component', UserGrowthComponent)
    .component('game-launch-chart-component', GameLaunchComponent)
;

app.mount('#app');
