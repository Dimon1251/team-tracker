<template>

    <headerPanel></headerPanel>

    <div class="info">
        Settings
    </div>
    <div class="settings">
        <div class="settings_menu">
            <ul>
                <li @click="changeTab('teams')">Teams</li>
                <li @click="changeTab('projects')">Projects</li>
                <li @click="changeTab('sprints')">Sprints</li>
                <li @click="changeTab('tickets')">Tickets</li>
            </ul>
        </div>
        <div class="settings_content">

            <div v-if="tabs.teams">

                <h2>Teams</h2>
                <div class="new_team_input">
                    <span class="label">Add new team name:</span>
                    <input class="form_input_settings" v-model="newTeam" type="text">
                    <button @click="saveNewTeam" class="button settings_button">
                        <div>Save</div>
                    </button>
                </div>

                <div class="teams_list">
                    <div v-for="team of teams" class="teams_card">
                        <div class="teams_card_inputs">
                            <div class="teams_card_inputs_team">
                                <span class="label">Enter team name:</span>
                                <input class="form_input_settings" type="text" v-model="team.name" />
                                <button class="button" @click="updateTeam(team)">
                                    <div>Update</div>
                                </button>
                                <button class="button" @click="deleteTeam(team.id)">
                                    <div>Delete</div>
                                </button>
                            </div>
                            <div class="teams_card_inputs_members">
                                <span class="label">Choose user:</span>
                                <select class="form_input_settings" v-model="team.selectedOption">
                                    <option v-for="user in users" :key="user.id" :value="user.id"
                                    v-if="teamIncludesUser(user)">
                                        {{ user.email }}
                                    </option>
                                </select>
                                <button class="button" @click="addUserToTeam(team.id, team.selectedOption)">
                                    <div>Add user</div>
                                </button>
                            </div>
                        </div>
                        <div class="teams_card_list">
                            <span class="label">Enter team name:</span>
                            <div v-for="user_of_team of team.users" class="teams_card_list_row">
                                <span class="user_of_team">{{user_of_team.email}}</span>
                                <button class="button" @click="removeUserFormTeam(user_of_team.id, team.id)"
                                        v-if="this.$store.state.user_email !== user_of_team.email">
                                    <div>Delete</div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div v-if="tabs.projects">
                <h2>Projects</h2>
                <input v-model="newProject" type="text">
                <select v-model="addNewTeam">
                    <option v-for="team in teams" :key="team.id" :value="team.id">{{ team.name }}</option>
                </select>
                <button @click="addTeamToProject">add</button>
                <button @click="saveNewProject">Save</button>

                <div v-for="team of newTeamList">
                    <div>{{ team }}</div>
                </div>

                <div v-for="project of projects">
                    <div>{{ project.name }}</div>
                </div>

            </div>

            <div v-if="tabs.sprints">
                <h2>Sprints</h2>
                <input type="text" v-model="newSprint">
                <select v-model="project" style="min-width: 300px">
                    <option v-for="project in projects" :key="project.id" :value="project.id">{{ project.name }}</option>
                </select>

                <input type="date" v-model="startDate">
                <input type="date" v-model="endDate">
                <button @click="saveNewSprint">Save</button>


                <div>
                    <div v-for="project of projects">
                        <h3>Project: {{ project.name }}</h3>
                        <p v-for="sprint of project.sprints" style="margin-left: 10px">{{sprint.name}}</p>
                    </div>
                </div>
            </div>

            <div v-if="tabs.tickets">
                <h2>Tickets</h2>
                <div>
                    Choose project:

                    <select v-model="projectForSprint">
                        <option v-for="project in projects" :key="project.id" :value="project">{{ project.name }}</option>
                    </select>
                </div>
                <div v-if="projectForSprint">
                    Choose sprint:

                    <select v-model="currentSprint" @change="getTickets">
                        <option v-for="sprint in projectForSprint.sprints" :key="sprint.id" :value="sprint.id">{{ sprint.name }}</option>
                    </select>
                </div>

                <div>Name:</div>
                <input type="text" v-model="newTicketName">
                <div>Description:</div>
                <input type="text" v-model="newTicketDescription">
                <div>Estimation:</div>
                <input type="number" v-model="newTicketEstimation">
                <button @click="addNewTicket">Add</button>

<!--                <div v-for="ticket of currentSprint.tickets">{{ ticket.name }}</div>-->

            </div>

        </div>
    </div>

</template>
<script>

import api from "../api.js";
import headerPanel from "../components/Header-panel.vue";
export default {
    components: {
        headerPanel
    },
    data() {
        return {
            tabs: {
                teams: true,
                projects: false,
                sprints: false,
                tickets: false
            },
            newTeam: null,
            newProject: null,
            teams: [],
            users: [],
            addNewTeam: null,
            newTeamList: [],
            allProjects: null,
            projects: [],
            newSprint: null,
            project: null,
            startDate: null,
            endDate: null,
            sprints: [],
            projectForSprint: null,
            currentSprint: null,
            newTicketName: null,
            newTicketDescription: null,
            newTicketEstimation: 0,
            ticketsOfCurrentProject: []
        }
    },
    methods: {
        saveNewTeam() {
            if (this.newTeam.trim().length > 0) {
                api.post('api/team/create', { name: this.newTeam })
                    .then(response => {
                        //
                    });
                this.newTeam = null;
                this.showAllTeams();
            }
        },
        showAllTeams() {
        api.get('api/team/index')
                .then(response => {
                    this.teams = response.data.Teams;
                });
        },
        deleteTeam(id) {
            api.post('api/team/destroy', { id: id })
                .then(response => {
                    //
                });
            this.showAllTeams();
        },
        updateTeam(team) {
            api.post('api/team/update', { id: team.id, name: team.name })
                .then(response => {
                    //
                });
            this.showAllTeams();
        },
        getAllUsers() {
            api.get('api/user/index')
                .then(response => {
                    this.users = response.data.Users;
                });
        },
        addUserToTeam(teamId, userId) {
            api.post('api/user/addToTeam', { user_id: userId, team_id: teamId })
                .then(response => {
                    //
                });
            this.showAllTeams();
        },
        changeTab(tab) {
            for (let key in this.tabs) {
                if (key === tab) {
                    this.tabs[tab] = true;
                } else {
                    this.tabs[key] = false;
                }
            };
        },
        removeUserFormTeam(userId, teamId) {
            api.post('api/user/removeFromTeam', { user_id: userId, team_id: teamId })
                .then(response => {
                    //
                });
            this.showAllTeams();
        },
        addTeamToProject() {
            this.newTeamList.push((this.addNewTeam));
        },
        saveNewProject() {
            api.post('api/project/create', { name: this.newProject, team_list: this.newTeamList })
                .then(response => {
                    //
                });
            this.newProject = null;
            this.newTeamList = [];

            this.showAllProjects();
        },
        showAllProjects() {
            api.get('api/project/index')
                .then(response => {
                    this.projects = response.data.Projects;
                    // console.log(this.projects)
                });
        },
        showCurrentProject(sprint_id) {
            console.log(sprint_id)
            api.post('api/ticket/index-sprint', { id: sprint_id })
                .then(response => {
                    this.ticketsOfCurrentProject = response.data.Tickets;
                    console.log(response);
                    console.log(this.ticketsOfCurrentProject);
                });
        },
        saveNewSprint() {
            api.post('api/sprint/create', {
                name: this.newSprint,
                project_id: this.project,
                start_date: this.startDate,
                end_date: this.endDate
            })
                .then(response => {
                    //
                });
            this.newSprint = null;
            this.project = null;
            this.startDate = null;
            this.endDate = null;

            this.showAllProjects();

        },
        addNewTicket() {
            api.post('api/ticket/create', {
                name: this.newTicketName,
                sprint_id: this.currentSprint,
                estimation: this.newTicketEstimation,
                description: this.newTicketDescription
            })
                .then(response => {
                    //
                });
            this.newSprint = null;
            this.project = null;
            this.startDate = null;

            this.showCurrentProject(this.currentSprint);
        },
        getTickets() {
            if (this.currentSprint) {
                this.showCurrentProject(this.currentSprint);
            }
        },
        teamIncludesUser(user) {
            console.log(user);
            return true;
            // return users.includes(user);
        }
    },
    mounted() {
        this.showAllTeams();
        this.getAllUsers();
        this.showAllProjects();
    },
    updated() {
        //
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
    color: gray;
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
    //margin: 10px;
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
    background: rgb(226,0,255);
    background: -moz-linear-gradient(313deg, rgba(226,0,255,1) 0%, rgba(0,245,255,1) 100%);
    background: -webkit-linear-gradient(313deg, rgba(226,0,255,1) 0%, rgba(0,245,255,1) 100%);
    background: linear-gradient(313deg, rgba(226,0,255,1) 0%, rgba(0,245,255,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#e200ff",endColorstr="#00f5ff",GradientType=1);
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.card-header {
    font-weight: 600;
    margin-bottom: 12px;
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
.card-data span {
    width: 100%;
    text-align: end;
    color: gray;
}
.logout {
    cursor: pointer;
}

.info {
    font-size: 32px;
    margin-top: 12px;
    margin-bottom: 12px;
    color: white;
    font-weight: 600;
}

.settings {
    margin: 12px;
    border-radius: 20px;
    min-height: 100px;
    background-color: white;
    display: flex;
    flex-direction: row;
    overflow: hidden;
    padding: 10px;
    min-height: calc(100vh - 150px);
}

.settings_menu {
    width: 300px;
    display: flex;
    flex-direction: column;
    background: rgb(226,0,255);
    background: -moz-linear-gradient(313deg, rgba(226,0,255,1) 0%, rgba(0,245,255,1) 100%);
    background: -webkit-linear-gradient(313deg, rgba(226,0,255,1) 0%, rgba(0,245,255,1) 100%);
    background: linear-gradient(313deg, rgba(226,0,255,1) 0%, rgba(0,245,255,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#e200ff",endColorstr="#00f5ff",GradientType=1);
    border-radius: 10px;
    margin-right: 10px;
}

.settings_menu ul {
    //margin: 2px;
    //border-radius: 16px;
}

.settings_menu ul li {
    margin: 10px;
    background-color: white;
    border-radius: 10px;
    font-size: 18px;
    padding: 10px 18px;
    cursor: pointer;
}

.settings_menu ul li:active {
    background-color: rgba(255,255,255, 0.5);
}

.settings_content {
    flex-grow: 1;
    padding: 10px;
}

.settings_content input {
  border: 1px solid black;
    margin-right: 5px;
    padding: 5px;
}

.teams_list input {
    color: black;
}

.new_team_input {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: start;
    gap: 10px;
    margin-top: 16px;
}

.form_input_settings {
    height: 36px;
    border-radius: 6px;
    border: 1px solid #a0aec0 !important;
    padding: 0 9px;
    margin: 0 !important;
    background-color: white;
}

.settings_button {
    margin: 0 !important;
    height: 36px !important;
}

.label {
    line-height: 38px;
    font-size: 16px;
    font-weight: 600 !important;
}

.teams_list {
    margin-top: 20px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding: 10px;
    background-color: rgb(244, 244, 244);
    border-radius: 10px;
    width: 70%;
}

.teams_card {
    background-color: white;
    padding: 10px;
    border-radius: 10px;
    align-items: flex-start;
    display: flex;
    flex-direction: row;
    gap: 10px;
}

.teams_card > div {
    width: 50%;
}

.teams_card_inputs {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.teams_card_inputs_team,
.teams_card_inputs_members {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    gap: 10px;
}

.teams_card_inputs_team input {
    width: 100%;
    margin: 0;
}

.teams_card_inputs_team button {
    width: calc(50% - 5px);
    height: 38px !important;
    margin: 0 !important;
}

.teams_card_inputs_members select,
.teams_card_inputs_members button {
    width: 100%;
    margin: 0 !important;
}

.teams_card_list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.teams_card_list span {
    font-size: 16px;
    font-weight: 500;
    flex-grow: 1;
}

.teams_card_list button {
    height: 38px;
    margin: 0;
}

.teams_card_list_row {
    display: flex;
    flex-direction: row;
    gap: 10px;
    align-items: center;
}


</style>
