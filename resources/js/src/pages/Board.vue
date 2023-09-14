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
                                    <select>
                                        <option value="0">Nikita</option>
                                        <option value="1">Dima</option>
                                        <option value="2">Andrii</option>
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
                                    <select>
                                        <option value="0">Nikita</option>
                                        <option value="1">Dima</option>
                                        <option value="2">Andrii</option>
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
                                    <select>
                                        <option value="0">Nikita</option>
                                        <option value="1">Dima</option>
                                        <option value="2">Andrii</option>
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
                                    <select>
                                        <option value="0">Nikita</option>
                                        <option value="1">Dima</option>
                                        <option value="2">Andrii</option>
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
            currentProject: {}
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
            console.log(this[status]);
            for (let i = 0; i<this[status].length; i++) {
                this[status][i].status = status;
                this[status][i].order = i;
            }

            for (let ticket of this[status]) {
                api.post('/api/tickets/update', ticket )
                    .then(response => {
                        //
                    });
            }
        },
        showCurrentProject(id) {
            api.get(`/api/sprints/${id}/tickets`)
                .then(response => {
                    this.tickets = response.data.Tickets;
                    console.log(response.data.Tickets);
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
                });
        },
        parseDate(string) {
            const date = new Date(string);
            return `${date.getDate()}.${date.getMonth() + 1}.${date.getFullYear()}`;
        }
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
.header {
    height: 72px;
    width: 100%;
    background-color: white;
    padding: 20px;
    display: flex;
    flex-direction: row;
}
.buttons {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    font-size: 18px;
    margin-left: 20px;
    line-height: 24px;
}
.nav ul, .user {
    display: flex;
    flex-direction: row;
    gap: 15px;
}
.nav ul li {
    cursor: pointer;
}
.logo {
    font-size: 24px;
    font-weight: 600;
    height: 32px;
    padding-top: 3px;
    user-select: none;
}
.name {
    color: grey;
    margin-right: 20px;
}
.info {
    padding: 12px 12px 0;
}
.board {
    padding: 12px;
    display: flex;
    flex-direction: row;
    gap: 12px;
    width: 100%;
}
.block {
    padding: 20px 10px 10px;
    background-color: white;
    border-radius: 20px;
    flex-grow: 1;
    width: calc((100% - 36px) / 4);
}
.block h2 {
    margin-left: 12px;
}
.list-group-item {
    cursor: grab;
    border-radius: 10px;
    padding: 18px;
    background-color: white;
}
.list-group {
    margin-top: 9px;
    width: 100%;
    height: calc(100% - 26px);
    border-radius: 10px;
    padding: 10px;
    background: rgb(244, 244, 244);
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.card-header {
    font-weight: 600;
    margin-bottom: 12px;
    display: flex;
    flex-direction: row;
    gap: 10px;
    align-items: start;
    justify-content: space-between;
}
.card-text {
    line-height: 18px;
}
.card-data {
    width: 100%;
    margin-top: 12px;
    display: flex;
    flex-direction: row;
    align-items: end;
}
.card-data div {
    width: 100%;
    text-align: end;
    color: grey;
}

.card-data select {
    border: none;
    background-color: transparent;
    cursor: pointer;
    font-size: 14px;
    color: grey;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    font-weight: 700;
}
.logout {
    cursor: pointer;
}

.info_project {
    font-size: 24px;
}

.info_estimation {
    font-size: 16px;
    margin-top: 12px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
}

.card_header {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}
.card_header h2 {
    margin-bottom: 0;
}

.card_header span {
    font-weight: 600;
    margin-right: 12px;
}

</style>
