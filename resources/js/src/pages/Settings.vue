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
                <input v-model="newTeam" type="text">
                <button @click="saveNewTeam">Save</button>

                <div class="teams_list">
                    <div v-for="team of teams">
                        <input type="text" v-model="team.name" />
                        <button @click="updateTeam(team)">Update</button>
                        <button @click="deleteTeam(team.id)">Delete</button>

                        <select v-model="team.selectedOption">
                            <option v-for="user in users" :key="user.id" :value="user.id">{{ user.email }}</option>
                        </select>
                        <button @click="addUserToTeam(team.id, team.selectedOption)">Add user</button>


                    </div>
                </div>
            </div>

            <div v-if="tabs.projects">
                <h2>Projects</h2>

            </div>

            <div v-if="tabs.sprints">
                <h2>Sprints</h2>

            </div>

            <div v-if="tabs.tickets">
                <h2>Tickets</h2>

            </div>



        </div>
    </div>

</template>
<script>

import api from "../api.js";
import headerPanel from "../components/Header-panel.vue";
import {inject} from 'vue'

export default {
    components: {
        headerPanel
    },
    data() {
        return {
            LoginUser: inject('LoginUser'),
            tabs: {
                teams: true,
                projects: false,
                sprints: false,
                tickets: false
            },
            newTeam: null,
            teams: [],
            users: []
        }
    },
    methods: {
        saveNewTeam() {
            if (this.newTeam.trim().length > 0) {
                api.post('api/team/create', { name: this.newTeam, user_creator: this.LoginUser.Id })
                    .then(response => {
                        //
                    });
                this.newTeam = null;
                this.showAllTeams();
            }
        },
        showAllTeams() {
            api.post('api/team/show', {id: this.LoginUser.Id })
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
            console.log(teamId, userId);
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
        }
    },
    mounted() {
        this.showAllTeams();
        this.getAllUsers();
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
    height: calc(100vh - 150px);
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


</style>
