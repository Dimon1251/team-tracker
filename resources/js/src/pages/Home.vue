<template>
    <header class="header">
        <div class="logo">
            TeamTracker
        </div>
        <div class="buttons">
            <div class="nav">
                <ul>
                    <li>
                        <span>Projects</span>
                    </li>
                    <li>
                        <span>My tasks</span>
                    </li>
                    <li>
                        <span>Settings</span>
                    </li>
                </ul>
            </div>
            <div class="user">
                <div class="email">
                    test@user.com
                </div>
                <div class="logout">
                    Logout
                </div>
            </div>
        </div>
    </header>
    <div class="info">

    </div>

    <div class="board">
            <div class="block">
                <h2>Todo</h2>
                <draggable
                    class="list-group"
                    :list="list1"
                    group="people"
                    @change="log"
                    itemKey="name"
                >
                    <template #item="{ element, index }">
                        <div class="list-group-item">
                            <div class="card-header">{{ element.name }}</div>
                            <p class="card-text">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur, quaerat.
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
                    :list="list2"
                    group="people"
                    @change="log"
                    itemKey="name"
                >
                    <template #item="{ element, index }">
                        <div class="list-group-item">
                            <div class="card-header">{{ element.name }}</div>
                            <p class="card-text">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur, quaerat.
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
                    :list="list3"
                    group="people"
                    @change="log"
                    itemKey="name"
                >
                    <template #item="{ element, index }">
                        <div class="list-group-item">
                            <div class="card-header">{{ element.name }}</div>
                            <p class="card-text">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur, quaerat.
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
                    :list="list4"
                    group="people"
                    @change="log"
                    itemKey="name"
                >
                    <template #item="{ element, index }">
                        <div class="list-group-item">
                            <div class="card-header">{{ element.name }}</div>
                            <p class="card-text">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur, quaerat.
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
export default {
    components: {
        draggable,
    },
    data() {
        return {
            list1: [
                { name: "John", id: 1 },
                { name: "Joao", id: 2 },
                { name: "Jean", id: 3 },
                { name: "Gerard", id: 4 }
            ],
            list2: [
                { name: "Juan", id: 5 },
                { name: "Edgard", id: 6 },
                { name: "Johnson", id: 7 }
            ],
            list3: [
                { name: "test1", id: 8 },
                { name: "test2", id: 9 },
                { name: "test3", id: 10 }
            ],
            list4: [
                { name: "test4", id: 11 },
                { name: "test5", id: 12 },
                { name: "test6", id: 13 }
            ]
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
            // window.console.log(evt);
            console.log('drop')
        }
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
.logo {
    font-size: 24px;
    font-weight: 600;
    height: 32px;
    padding-top: 3px;
    user-select: none;
}
.email {
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

</style>
