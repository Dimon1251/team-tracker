<template>

    <headerPanel></headerPanel>

    <div class="info">
        My Tasks
    </div>
    <div class="projects_block">
        <div v-for="team of tasksArray" class="project_cards_container">
            <h3 class="label">{{team.team}}:</h3>
            <div v-for="project of team.projects" class="tasks_project_card">
                <h3 class="label">{{project.project}}:</h3>
                <div class="sprints_of_projects_area">
                    <div v-for="sprint of project.sprints" class="tasks_project_card">
                        <h3 class="label">{{sprint.sprint}}:</h3>
                        <div class="sprints_of_projects_area">
                            <router-link class="sprint" :to="getSprintRoute(task.sprint_id)" v-for="task of sprint.tickets">
                                <div class="ticket_name">Name: {{task.name}}</div>
                                <div class="ticket_description">Description: {{task.description}}</div>
                                <div class="ticket_status">Status: {{statuses[task.status]}}</div>
                            </router-link>
                        </div>
                    </div>
                </div>

            </div>


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
            tasksArray: [],
            statuses: {
                todo: 'Todo',
                inprogress: 'In progress',
                stage: 'Stage',
                done: 'Done'
            }
        }
    },
    methods: {
        showAllTasks() {
            api.get('api/users/tickets')
            .then(response => {
                this.tasksArray = response.data.Tickets;
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
        }
    },
    mounted() {
        this.showAllTasks();
    },
    updated() {
        //
    }
}
</script>

<style>




</style>
