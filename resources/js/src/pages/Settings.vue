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
                    <input class="form_input_settings" v-model="newTeam" type="text" :class="{ 'validation_error': addNewTeamError }">
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
                                <select class="form_input_settings" v-model="team.selectedOption" >
                                    <option v-for="user in users" :key="user.id" :value="user.id">
                                        {{ user.email }}
                                    </option>
                                </select>
                                <button class="button" @click="addUserToTeam(team.id, team.selectedOption)">
                                    <div>Add user</div>
                                </button>
                            </div>
                        </div>
                        <div class="teams_card_list">
                            <span class="label">Team users list:</span>
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
                <div class="team_block">
                    <div class="new_project_block">
                        <span class="label">Enter new project name:</span>
                        <input class="new_project_input" v-model="newProject" type="text">
                        <span class="label">Assign a team:</span>

                        <select v-model="addNewTeam" class="form_input_settings">
                            <option v-for="team in teams" :key="team.id" :value="team.id">{{ team.name }}</option>
                        </select>
                        <div class="project_add_buttons">
                            <button @click="addTeamToProject" class="button">
                                <div>
                                    add
                                </div>
                            </button>
                            <button @click="saveNewProject" class="button">
                                <div>
                                    Save
                                </div>
                            </button>
                        </div>
                        <span class="label">Assigned teams:</span>
                        <div v-for="team of newTeamList" class="team_list">
                            <div>{{ getTeamNameById(team) }}</div>
                        </div>
                    </div>
                    <div class="projects_list">
                        <span class="label">Projects:</span>
                        <div v-for="project of projects" class="project_item">
                            <div>{{ project.name }}</div>
                            <button class="button" @click="deleteProject(project.id)">
                                <div>
                                    Delete
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="tabs.sprints">
                <h2>Sprints</h2>
                <div class="sprints_block">

                    <span class="label">Enter new sprint name:</span>

                    <input type="text" v-model="newSprint" class="new_project_input">
                    <span class="label">Choose project:</span>

                    <select v-model="project" class="form_input_settings">
                        <option v-for="project in projects" :key="project.id" :value="project.id">{{ project.name }}</option>
                    </select>
                    <span class="label">Choose time range:</span>
                    <div class="time_range_block">
                        <input type="date" v-model="startDate">
                        <input type="date" v-model="endDate">
                    </div>
                    <button @click="saveNewSprint" class="button">
                        <div>
                            Save
                        </div>
                    </button>


                    <div class="project_cards_container">
                        <div v-for="project of projects" class="project_card">
                            <span class="label">Project name:</span>

                            <h3>{{ project.name }}</h3>
                            <span class="label">Sprints:</span>
                            <div v-for="sprint of project.sprints" class="sprints_list">
                                <span>
                                    {{sprint.name}}
                                </span>
                                <button class="button" @click="deleteSprint(sprint.id)">
                                    <div>
                                        Delete
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div v-if="tabs.tickets">
                <h2>Tickets</h2>

                <div class="tickets_block">
                    <span class="label">Choose project:</span>
                    <select v-model="projectForSprint" class="form_input_settings">
                        <option v-for="project in projects" :key="project.id" :value="project">{{ project.name }}</option>
                    </select>
                    <span class="label" v-if="projectForSprint">Choose sprint:</span>
                    <select v-model="currentSprint" @change="getTickets" v-if="projectForSprint" class="form_input_settings">
                        <option v-for="sprint in projectForSprint.sprints" :key="sprint.id" :value="sprint.id">{{ sprint.name }}</option>
                    </select>
                    <span class="label">Name:</span>
                    <input type="text" v-model="newTicketName" class="new_project_input">
                    <span class="label">Description:</span>
                    <input type="text" v-model="newTicketDescription" class="new_project_input">
                    <span class="label">Estimation:</span>
                    <select v-model="newTicketEstimation" class="form_input_settings">
                        <option v-for="item in estimationList" :value="item">{{ item }}</option>
                    </select>

                    <button @click="addNewTicket" class="button">
                        <div>
                            Add
                        </div>
                    </button>
                    <div v-if="ticketsOfCurrentProject.length">
                        <span class="label">Tickets:</span>
                        <div class="tickets_list">
                            <div class="ticket" v-for="ticket of ticketsOfCurrentProject">
                                <input type="text" v-model="ticket.name" class="new_project_input">
                                <div class="tickets_buttons">
                                    <button class="button">
                                        <div>
                                            Update
                                        </div>
                                    </button>
                                    <button class="button" @click="deleteTicket(ticket.id)">
                                        <div>
                                            Delete
                                        </div>
                                    </button>
                                </div>
                            </div>
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
            newTeam: '',
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
            ticketsOfCurrentProject: [],
            addNewTeamError: false,
            updateTeamName: false,
            estimationList: [
                '250',
                '500',
                '1000',
                '2000',
                '3000'
            ]
        }
    },
    methods: {
        saveNewTeam() {
            this.addNewTeamError = false;
            if (this.newTeam !== null && this.newTeam.trim().length > 0) {
                    api.post('api/teams/create', { name: this.newTeam })
                    .then(response => {
                        //
                    });
                this.newTeam = null;
                this.showAllTeams();
            } else {
                this.addNewTeamError = true;
            }
        },
        showAllTeams() {
            api.get('api/teams/index')
                .then(response => {
                    this.teams = response.data.Teams;
                });
        },
        deleteTeam(id) {
                api.get(`api/teams/${id}/delete`)
                .then(response => {
                    //
                });
            this.showAllTeams();
        },
        updateTeam(team) {
            this.updateTeamName = false;
            if (team.name !== null && team.name.trim().length > 0) {
                api.post(`api/teams/${team.id}/update`, { name: team.name })
                    .then(response => {
                        /* if (response === undefined){
                             console.log("Error");
                         }
                         else if (response.status === 200){
                             console.log("Success");
                         }*/
                    });
                this.showAllTeams();
            } else {
                this.updateTeamName = true;
            }

        },
        getAllUsers() {
                api.get('api/users/index')
                .then(response => {
                    this.users = response.data.Users;
                });
        },
        addUserToTeam(teamId, userId) {

            if(userId) {
                api.get(`api/users/${userId}/add-to-team/${teamId}`)
                    .then(response => {
                        //
                    });
                this.showAllTeams();
            }
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
                api.get(`api/users/${userId}/remove-from-team/${teamId}`)
                .then(response => {
                    //
                });
            this.showAllTeams();
        },
        addTeamToProject() {
            this.newTeamList.push((this.addNewTeam));
        },
        saveNewProject() {
                api.post('api/projects/create', { name: this.newProject, team_list: this.newTeamList })
                .then(response => {
                    //
                });
            this.newProject = null;
            this.newTeamList = [];

            this.showAllProjects();
        },
        showAllProjects() {
            api.get('api/projects/index')
            .then(response => {
                this.projects = response.data.Projects;
            });
        },
        showCurrentProject(sprint_id) {
            api.get(`api/sprints/${sprint_id}/tickets`)
            .then(response => {
                this.ticketsOfCurrentProject = response.data.Tickets;
                console.log(this.ticketsOfCurrentProject);
            });
        },
        saveNewSprint() {
            api.post('api/sprints/create', {
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
            api.post('api/tickets/create', {
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
        deleteProject(id) {
            api.post('api/projects/destroy', { id: id })
                .then(response => {
                    //
                });
            this.showAllProjects();
        },
        getTeamNameById(id) {
            return this.teams.find(item => item.id === id).name;
        },
        deleteSprint(id) {
            api.post('api/sprints/destroy', { id: id })
                .then(response => {
                    //
                });
            this.showAllProjects();
        },
        deleteTicket(id) {
            api.post('api/tickets/destroy', { id: id })
                .then(response => {
                    //
                });
            this.getTickets();
        },
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
    color: grey;
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
    background-color: rgb(244, 244, 244);
    border-radius: 10px;
    margin-right: 10px;
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
    width: 100%;
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

.validation_error {
    border-color: red !important;
}

.team_block {
    display: flex;
    flex-direction: row;
    gap: 10px;
    padding: 10px;
    border-radius: 10px;
    background-color: rgb(244, 244, 244);
}

.new_project_block,
.projects_list {
    display: flex;
    flex-direction: column;
    border-radius: 10px;
    background-color: white;
    padding: 10px;
    width: 50%;
}

.new_project_input {
    padding: 5px;
    border-radius: 6px;
    border: 1px solid #a0aec0 !important;
}

.project_add_buttons {
    display: flex;
    flex-direction: row;
    gap: 10px;
}

.project_add_buttons button {
    height: 38px;
    width: calc(50% - 5px);
}

.team_list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.project_item {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
}

.project_item button {
    height: 38px !important;
}

.sprints_block {
    width: 50%;
    display: flex;
    flex-direction: column;
}

.project_cards_container {
    display: flex;
    flex-direction: column;
    border-radius: 10px;
    background-color: rgb(244, 244, 244);
    padding: 10px;
    margin-top: 10px;
    gap: 10px;
}

.time_range_block {
    display: flex;
    flex-direction: row;
    gap: 10px;
}

.sprints_block input {
    margin: 0 !important;
}

.sprints_block button {
    height: 38px !important;
}

.time_range_block input {
    width: calc(50% - 5px);
    margin: 0 0 10px !important;
    border-radius: 6px;
    border: 1px solid #a0aec0 !important;
}

.project_card {
    border-radius: 6px;
    background-color: white;
    padding: 10px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.sprints_list {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
}

.tickets_block {
    width: 50%;
    display: flex;
    flex-direction: column;
}

.tickets_block input {
    margin: 0;
}

.tickets_list {
    border-radius: 6px;
    background-color: rgb(244, 244, 244);
    padding: 10px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.ticket {
    border-radius: 6px;
    background-color: white;
    padding: 10px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}

.ticket input {
    flex-grow: 1;
}
.tickets_buttons {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    gap: 10px;
}
.tickets_buttons button {
    height: 32px !important;
    margin: 0 !important;
    width: calc(50% - 5px);
}
.tickets_buttons button div {
    padding: 0 5px !important;
}


</style>
