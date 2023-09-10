<template>

    <headerPanel></headerPanel>

    <div class="info">
        My projects
    </div>
    <div class="projects_block">
        <div v-for="project of projects">
            <span class="label">Project name: {{project.name}}</span>
<!--            <div v-for="sprint of project.sprints">-->
<!--                {{sprint.name}}-->
<!--            </div>-->
            <router-link class="link" :to="getSprintRoute(sprint.id)" v-for="sprint of project.sprints">
                {{sprint.name}}
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
                console.log(this.projects)
            });
        },
        getSprintRoute(id) {
            return `/sprints/${id}`;
        }
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

.projects_block {
    margin: 12px;
    border-radius: 20px;
    //min-height: 100px;
    background-color: white;
    display: flex;
    flex-direction: column;
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
