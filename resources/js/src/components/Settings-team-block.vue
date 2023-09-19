<template>
    <div class="teams_card">
        <div class="teams_card_inputs">
            <div class="teams_card_inputs_team">
                <span class="label">Team name:</span>
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
</template>

<script>

import api from "../api.js";
export default {
    props: ['team'],
    data() {
        return {
            users: []
        }
    },
    methods: {
        updateTeam(team) {
            this.updateTeamName = false;
            if (team.name !== null && team.name.trim().length > 0) {
                api.post(`api/teams/${team.id}/update`, { name: team.name } )
                    .then(response => {
                        /* if (response === undefined){
                             console.log("Error");
                         }
                         else if (response.status === 200){
                             console.log("Success");
                         }*/
                    });
                this.$emit('callShowAllTeamsFunc')
            } else {
                this.updateTeamName = true;
            }

        },
        deleteTeam(id) {
            api.get(`api/teams/${id}/destroy`)
                .then(response => {
                    //
                });
            // this.showAllTeams();
            this.$emit('callShowAllTeamsFunc')
        },
        addUserToTeam(teamId, userId) {

            if(userId) {
                api.get(`api/users/${userId}/add-to-team/${teamId}` )
                    .then(response => {
                        //
                    });
                this.getAllUsers();
                this.$emit('callShowAllTeamsFunc')


            }
        },
        removeUserFormTeam(userId, teamId) {
            api.get(`api/users/${userId}/remove-from-team/${teamId}` )
                .then(response => {
                    //
                });
            this.getAllUsers();
            this.$emit('callShowAllTeamsFunc')

        },
        getAllUsers() {
            api.get(`api/teams/${this.team.id}/users`)
                .then(response => {
                    this.users = response.data.Users;
                });
        },
    },
    mounted() {
        this.getAllUsers();
    },
    updated() {
        //
    }
}
</script>

<style>

</style>
