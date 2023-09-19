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
                <li @click="changeTab('tickets')">Tasks</li>
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
                    <SettingsTeamBlock v-for="team of teams" :team="team" @callShowAllTeamsFunc="showAllTeams"></SettingsTeamBlock>
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
                                    Add
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
                            <div class="x-btn" @click="deleteTeamFromList(team)">
                                x
                            </div>
                        </div>
                    </div>
                    <div class="projects_list">
                        <span class="label">Projects:</span>
                        <div class="sprints_of_projects_area">
                            <div v-for="project of projects" class="project_item">
                                <span class="label">Project name:</span>
                                <div class="project_buttons">
                                    <input class="new_project_input" type="text" v-model="project.name" />
                                    <button class="button" @click="updateProject(project)">
                                        <div>
                                            Update
                                        </div>
                                    </button>
                                    <button class="button" @click="deleteProject(project.id)">
                                        <div>
                                            Delete
                                        </div>
                                    </button>
                                </div>
                                <div class="add_team">
                                    <select v-model="project.newTeamId" class="form_input_settings">
                                        <option v-for="team in teams" :key="team.id" :value="team.id">{{ team.name }}</option>
                                    </select>
                                    <button class="button" @click="addTeamInExistingProject(project.id, project.newTeamId)">
                                        <div>
                                            Add
                                        </div>
                                    </button>
                                </div>

                                <span class="label">Assigned teams:</span>
                                <div v-for="team of project.teams" class="team_list">
                                    <div>{{ team.name }}</div>
                                    <div class="x-btn" @click="deleteTeamFromProject(project, team)">
                                        x
                                    </div>
                                </div>
                            </div>
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
                                <input type="text" v-model="sprint.name" class="new_project_input">
                                <input type="date" v-model="sprint.start_date" class="new_project_input">
                                <input type="date" v-model="sprint.end_date" class="new_project_input">

                                <button class="button" @click="updateSprint(sprint)">
                                    <div>
                                        Update
                                    </div>
                                </button>
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
                <h2>Tasks</h2>

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
                        <span class="label">Tasks:</span>
                        <div class="tickets_list">
                            <div class="ticket" v-for="ticket of ticketsOfCurrentProject">
                                <input type="text" v-model="ticket.name" class="ticket_list_input">
                                <input type="text" v-model="ticket.description" class="new_project_input">
                                <select v-model="ticket.estimation" class="form_input_settings">
                                    <option v-for="item in estimationList" :value="item">{{ item }}</option>
                                </select>
                                <div class="tickets_buttons">
                                    <button class="button"  @click="updateTicket(ticket)">
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
import SettingsTeamBlock from "../components/Settings-team-block.vue";

export default {
    components: {
        SettingsTeamBlock,
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
                    api.post('api/teams/create', { name: this.newTeam } )
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
            api.get('api/teams/index' )
                .then(response => {
                    this.teams = response.data.Teams;
                });
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

        addTeamToProject() {

            if (!this.newTeamList.includes(this.addNewTeam)) {
                this.newTeamList.push((this.addNewTeam));
            }
            this.addNewTeam = null;
        },
        saveNewProject() {
                api.post('api/projects/create', { name: this.newProject, team_list: this.newTeamList } )
                .then(response => {
                    //
                });
            this.newProject = null;
            this.newTeamList = [];

            this.showAllProjects();
        },
        showAllProjects() {
            api.get('api/projects/index' )
            .then(response => {
                let projects = response.data.Projects;

                for (let project of projects) {
                    for (let sprint of project.sprints) {
                        let startDate = new Date(sprint.start_date)
                        let startYear = startDate.getFullYear();
                        let startMonth = startDate.getMonth() + 1;
                        if (startMonth < 10) {
                            startMonth = `0${startMonth}`
                        }
                        let startDay = startDate.getDate();
                        if (startDay < 10) {
                            startDay = `0${startDay}`
                        }
                        sprint.start_date = `${startYear}-${startMonth}-${startDay}`;
                        let endDate = new Date(sprint.end_date)
                        let endYear = endDate.getFullYear();
                        let endMonth = endDate.getMonth() + 1;
                        if (endMonth < 10) {
                            endMonth = `0${endMonth}`
                        }
                        let endDay = endDate.getDate();
                        if (endDay < 10) {
                            endDay = `0${endDay}`
                        }
                        sprint.end_date = `${endYear}-${endMonth}-${endDay}`;
                    }
                }
                this.projects = projects;
                this.setTeamsOfProject();
                console.log(this.projects);
            });
        },
        showCurrentProject(sprint_id) {
            api.get(`api/sprints/${sprint_id}/tickets` )
            .then(response => {
                this.ticketsOfCurrentProject = response.data.Tickets;
                console.log(this.ticketsOfCurrentProject);
            });
        },
        saveNewSprint() {
            api.post('api/sprints/create',  {
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
            api.post('api/tickets/create',
                {
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
            api.get(`api/projects/${id}/destroy`)
                .then(response => {
                    //
                });
            this.showAllProjects();
        },
        updateProject(project) {
            console.log(project);
            api.post(`api/projects/${project.id}/update`, {name: project.name} )
                .then(response => {
                    //
                });
            this.showAllProjects();
        },
        getTeamNameById(id) {
            return this.teams.find(item => item.id === id).name;
        },
        updateSprint(sprint) {
            api.post(`api/sprints/${sprint.id}/update`, sprint )
                .then(response => {
                    //
                });
            this.showAllProjects();
        },
        deleteSprint(id) {
            api.get(`api/sprints/${id}/destroy` )
                .then(response => {
                    //
                });
            this.showAllProjects();
        },
        updateTicket(ticket) {
            api.post('api/tickets/update', [ticket])
                .then(response => {
                    //
                });
            this.getTickets();
        },
        deleteTicket(id) {
            api.get(`api/tickets/${id}/destroy`)
                .then(response => {
                    //
                });
            this.getTickets();
        },
        deleteTeamFromList(team) {
            let index = this.newTeamList.indexOf(team);
            this.newTeamList.splice(index, 1);
        },
        getTeamsOfProject(project_id, i) {
            api.get(`api/projects/${project_id}/teams`)
                .then(response => {
                    this.projects[i].teams = response.data.Teams;
                });
        },
        setTeamsOfProject() {
            for (let i = 0; i < this.projects.length; i++) {
                this.getTeamsOfProject(this.projects[i].id, i);
            }
        },
        deleteTeamFromProject(project, team) {
            api.get(`api/projects/${project.id}/remove-team/${team.id}`)
                .then(response => {
                    //
                });

            this.showAllProjects();
        },
        addTeamInExistingProject(project_id, team_id) {
            api.get(`api/projects/${project_id}/add-team/${team_id}`)
                .then(response => {
                    //
                });

            this.showAllProjects();
        }
    },
    mounted() {
        this.showAllTeams();
        this.showAllProjects();
    },
    updated() {
        //
    }
}
</script>

<style>

</style>
