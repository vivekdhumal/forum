<template>
    <li class="dropdown" v-show="notifications.length">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
            <span class="glyphicon glyphicon-bell"></span>
        </a>

        <ul class="dropdown-menu">
            <li v-for="notification in notifications" v-bind:key="notification.id">
                <a :href="notification.data.link" @click="markAsRead(notification)">
                    <span class="glyphicon glyphicon-comment"></span> {{ notification.data.message }}
                </a>
            </li>
        </ul>
    </li>
</template>
<script>
    export default {
        data() {
            return {
                notifications: false
            };
        },

        created() {
            axios.get("/profiles/" + window.App.user.name + "/notifications")
                .then(response => this.notifications = response.data);
        },

        methods: {
            markAsRead(notification) {
                axios.delete("/profiles/" + window.App.user.name + "/notifications/" + notification.id);
            }
        }
    }
</script>
