require("./bootstrap");

import Vue from 'vue';

const app = new Vue({
    el: "#app"
});

Vue.component("kanban-board", require("./components/KanbanBoard.vue").default);