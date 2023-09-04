<template>

    <headerPanel></headerPanel>

    <div class="info">
        <div class="info_project">
            Project / Sprint
        </div>
        <div class="info_team">
            Team: Team name
        </div>
    </div>

    <div class="board">
            <div class="block">
                <h2>Todo</h2>
                <draggable
                    class="list-group"
                    :list="todo"
                    group="people"
                    @change="log"
                    itemKey="name"
                >
                    <template #item="{ element, index }">
                        <div class="list-group-item">
                            <div class="card-header">{{ element.name }}</div>
                            <p class="card-text">
                                {{ element.description }}
                            </p>
                            <div class="card-data">
                                <span>
                                    Assigned to: User
                                </span>
                            </div>
                        </div>
                    </template>
                </draggable>
            </div>
            <div class="block">
                <h2>In progress</h2>
                <draggable
                    class="list-group"
                    :list="inprogress"
                    group="people"
                    @change="log"
                    itemKey="name"
                >
                    <template #item="{ element, index }">
                        <div class="list-group-item">
                            <div class="card-header">{{ element.name }}</div>
                            <p class="card-text">
                                {{ element.description }}
                            </p>
                            <div class="card-data">
                                <span>
                                    Assigned to: User
                                </span>
                            </div>
                        </div>
                    </template>
                </draggable>
            </div>
            <div class="block">
                <h2>Tests</h2>
                <draggable
                    class="list-group"
                    :list="tests"
                    group="people"
                    @change="log"
                    itemKey="name"
                >
                    <template #item="{ element, index }">
                        <div class="list-group-item">
                            <div class="card-header">{{ element.name }}</div>
                            <p class="card-text">
                                {{ element.description }}
                            </p>
                            <div class="card-data">
                                <span>
                                    Assigned to: User
                                </span>
                            </div>
                        </div>
                    </template>
                </draggable>
            </div>
            <div class="block">
                <h2>Done</h2>
                <draggable
                    class="list-group"
                    :list="done"
                    group="people"
                    @change="log"
                    itemKey="name"
                >
                    <template #item="{ element, index }">
                        <div class="list-group-item">
                            <div class="card-header">{{ element.name }}</div>
                            <p class="card-text">
                                {{ element.description }}
                            </p>
                            <div class="card-data">
                                <span>
                                    Assigned to: User
                                </span>
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
            tickets: []
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
        log: function(evt) {
            console.log('drop')
        },
        logout () {
            localStorage.setItem('access_token', '');
            this.$store.state.authorized = false;
            router.push('/login');
        },
        getAccessToken(){
            if(localStorage.getItem('access_token')) {
                this.$store.state.authorized = true;
            } else {
                this.$store.state.authorized = false;
            }
        },
        getUserData() {
            if (localStorage.getItem('access_token')) {
                api.get('api/user/auth')
                    .then( response => {
                        this.name = response.data.User.name;
                    })
            }
        },
        showCurrentProject(sprint_id) {
            api.post('api/ticket/index-sprint', { id: sprint_id })
                .then(response => {
                    this.tickets = response.data.Tickets;
                    console.log(this.tickets);
                });
        },
        tasksFilter(type) {
            return this.tickets.filter(item => item.status === type);
        }
    },
    mounted() {
        // this.getUserData();
        this.showCurrentProject(1);

        setTimeout(()=>{
            this.todo = this.tasksFilter('todo');
            this.inprogress = this.tasksFilter('inprogress');
            this.tests = this.tasksFilter('tests');
            this.done = this.tasksFilter('done');
        }, 500);
    },
    updated() {
        // this.getUserData();
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
    background: rgb(244, 244, 244);
    //background: -moz-linear-gradient(313deg, rgba(226,0,255,1) 0%, rgba(0,245,255,1) 100%);
    //background: -webkit-linear-gradient(313deg, rgba(226,0,255,1) 0%, rgba(0,245,255,1) 100%);
    //background: linear-gradient(313deg, rgba(226,0,255,1) 0%, rgba(0,245,255,1) 100%);
    //filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#e200ff",endColorstr="#00f5ff",GradientType=1);
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

.info_project {
    font-size: 24px;
}

.info_team {
    font-size: 16px;
    margin-top: 12px;
}

</style>
