<template>

    <headerPanel></headerPanel>

    <div class="info">
        My projects
    </div>
    <div class="projects_block">
        <div v-for="project of projects" class="project_cards_container">
            <h3 class="label">{{project.name}}:</h3>
            <router-link class="sprint" :to="getSprintRoute(sprint.id)" v-for="sprint of project.sprints">
                <div>Name: {{sprint.name}}</div>
                <div>Start-End: {{parseDate(sprint.start_date)}} - {{parseDate(sprint.end_date)}}</div>
            </router-link>
        </div>
    </div>

</template>
<script>

import api from "../api.js";
import headerPanel from "../components/Header-panel.vue";
import router from "../router/router.js";

export default {
    components: {
        headerPanel
    },
    data() {
        return {
            projects: [],
        }
    },
    methods: {
        showAllProjects() {
            api.get('api/projects/index')
            .then(response => {
                this.projects = response.data.Projects;
            });
        },
        getSprintRoute(id) {
            return `/sprints/${id}`;
        },
        parseDate(string) {
            const date = new Date(string);
            let day = date.getDate();
            if (day < 10) {
                day = '0' + String(day);
            }
            let month = date.getMonth() + 1;
            if (month < 10) {
                month = '0' + String(month);
            }
            let year = date.getFullYear();

            return `${day}.${month}.${year}`;
        },
    },
    mounted() {
        this.showAllProjects();
    },
    updated() {
        //
    }
}
</script>

<style>




</style>
