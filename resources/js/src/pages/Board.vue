<template>

    <headerPanel></headerPanel>

    <div class="info">
        <div class="info_project">
            {{ currentProject.name }} / {{ currentSprint.name }}
        </div>
        <div class="info_estimation">
            <span>Total estimation: {{sumAllEstimation(tickets)}}</span>
            <span>Date range: {{ parseDate(currentSprint.start_date) }} - {{ parseDate(currentSprint.end_date) }}</span>
        </div>
    </div>

    <div class="board">
            <div class="block">
                <div class="card_header">
                    <h2>Todo</h2>
                    <span>Est.: {{sumAllEstimation(todo)}}</span>
                </div>
                <draggable
                    class="list-group"
                    :list="todo"
                    group="people"
                    @change="updateTickets('todo')"
                    itemKey="name"
                >
                    <template #item="{ element, index }">
                        <div class="list-group-item">
                            <div class="card-header">
                                <span>{{ element.name }}</span>
                                <span>{{ element.estimation }}</span>
                            </div>
                            <p class="card-text">
                                {{ element.description }}
                            </p>
                            <div class="card-data">
                                <div>
                                    <span>
                                        Assigned to:
                                    </span>
                                    <select v-model="element.assigned_user_id" @change="updateTicket(element)">
                                        <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </template>
                </draggable>
            </div>
            <div class="block">
                <div class="card_header">
                    <h2>In progress</h2>
                    <span>Est.: {{sumAllEstimation(inprogress)}}</span>
                </div>
                <draggable
                    class="list-group"
                    :list="inprogress"
                    group="people"
                    @change="updateTickets('inprogress')"
                    itemKey="name"
                >
                    <template #item="{ element, index }">
                        <div class="list-group-item">
                            <div class="card-header">
                                <span>{{ element.name }}</span>
                                <span>{{ element.estimation }}</span>
                            </div>
                            <p class="card-text">
                                {{ element.description }}
                            </p>
                            <div class="card-data">
                                <div>
                                    <span>
                                        Assigned to:
                                    </span>
                                    <select v-model="element.assigned_user_id" @change="updateTicket(element)">
                                        <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </template>
                </draggable>
            </div>
            <div class="block">
                <div class="card_header">
                    <h2>Tests</h2>
                    <span>Est.: {{sumAllEstimation(tests)}}</span>
                </div>
                <draggable
                    class="list-group"
                    :list="tests"
                    group="people"
                    @change="updateTickets('tests')"
                    itemKey="name"
                >
                    <template #item="{ element, index }">
                        <div class="list-group-item">
                            <div class="card-header">
                                <span>{{ element.name }}</span>
                                <span>{{ element.estimation }}</span>
                            </div>
                            <p class="card-text">
                                {{ element.description }}
                            </p>
                            <div class="card-data">
                                <div>
                                    <span>
                                        Assigned to:
                                    </span>
                                    <select v-model="element.assigned_user_id" @change="updateTicket(element)">
                                        <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </template>
                </draggable>
            </div>
            <div class="block">
                <div class="card_header">
                    <h2>Done</h2>
                    <span>Est.: {{sumAllEstimation(done)}}</span>
                </div>
                <draggable
                    class="list-group"
                    :list="done"
                    group="people"
                    @change="updateTickets('done')"
                    itemKey="name"
                >
                    <template #item="{ element, index }">
                        <div class="list-group-item">
                            <div class="card-header">
                                <span>{{ element.name }}</span>
                                <span>{{ element.estimation }}</span>
                            </div>
                            <p class="card-text">
                                {{ element.description }}
                            </p>
                            <div class="card-data">
                                <div>
                                    <span>
                                        Assigned to:
                                    </span>
                                    <select v-model="element.assigned_user_id" @change="updateTicket(element)">
                                        <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </template>
                </draggable>
            </div>
    </div>
</template>

<script>

import draggable from 'vuedraggable'
import api from "../api.js";
import headerPanel from "../components/Header-panel.vue";
export default {
    components: {
        draggable,
        headerPanel
    },
    data() {
        return {
            todo: [],
            inprogress: [],
            tests: [],
            done: [],
            tickets: [],
            currentSprint: {},
            currentProject: {},
            users: []
        }
    },
    methods: {
        add: function() {
            this.list.push({ name: "Juan" });
        },
        replace: function() {
            this.list = [{ name: "Edgard" }];
        },
        clone: function(el) {
            return {
                name: el.name + " cloned"
            };
        },
        updateTickets(status) {
            for (let i = 0; i<this[status].length; i++) {
                this[status][i].status = status;
                this[status][i].order = i;
            }
            let arr = [];
            for (let ticket of this[status]) {
                arr.push(ticket);
            }

            api.post('/api/tickets/update', arr )
                .then(response => {
                    //
                });
        },
        updateTicket(ticket) {
            api.post('/api/tickets/update', [ticket] )
                .then(response => {
                    //
                });
        },
        showCurrentProject(id) {
            api.get(`/api/sprints/${id}/tickets`)
                .then(response => {
                    this.tickets = response.data.Tickets;
                });
        },

        tasksFilter(type) {
            return this.tickets.filter(item => item.status === type);
        },
        sumAllEstimation(array) {
            return array.reduce((accumulator, currentObject) => {
                return accumulator + currentObject.estimation;
            }, 0);
        },
        showSprint(id) {
            api.post('/api/sprints/show', { id: id })
                .then(response => {
                    this.currentSprint = response.data.Sprint;
                    this.showProject(this.currentSprint.project_id);
                });
        },
        showProject(id) {
            api.post('/api/projects/show', { id: id })
                .then(response => {
                    this.currentProject = response.data.Project;
                    this.getUsersOfProject(this.currentProject.id)
                });
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
        getUsersOfProject(project_id) {
            api.get(`/api/projects/${project_id}/users`)
                .then(response => {
                    for (let team of response.data.Users) {;
                        for(let user of team.users) {
                            if(!this.users.includes(user)) {
                                this.users.push(user)
                            }
                        }
                    }
                });
        },
    },
    mounted() {
        this.showCurrentProject(this.$route.params.id);
        setTimeout(()=>{
            this.todo = this.tasksFilter('todo');
            this.inprogress = this.tasksFilter('inprogress');
            this.tests = this.tasksFilter('tests');
            this.done = this.tasksFilter('done');
        }, 500);
        this.showSprint(this.$route.params.id);

    },
    updated() {
    }
}
</script>

<style>


</style>
