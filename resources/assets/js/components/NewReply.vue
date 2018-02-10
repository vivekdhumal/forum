<template>
    <div>
        <div v-if="signedIn">
            <div class="form-group">
                <textarea  name="body"
                        class="form-control"
                        id="body"
                        required
                        rows="5"
                        placeholder="Have something to say?"
                        v-model="body"></textarea>
            </div>

            <button type="submit" class="btn btn-default" @click="addReply">Post</button>
        </div>

        <p v-else class="text-center">Please <a href="/login">sign in</a> to participate in this discussion.</p>
    </div>
</template>
<script>
    import 'jquery.caret';
    import 'at.js';

    export default {
        data() {
            return {
                body: ''
            };
        },

        mounted() {
            $('#body').atwho({
                at: "@",
                delay: 750,
                callbacks: {
                    remoteFilter: function(query, callback) {
                        $.getJSON("/api/users", {name: query}, function(username) {
                            callback(username)
                        });
                    }
                }
            });
        },

        computed: {
            signedIn() {
                return window.App.signedIn;
            }
        },

        methods: {
            addReply() {
                axios.post(location.pathname + '/replies', { body: this.body })
                    .catch(error => {
                        flash(error.response.data.message, "danger");
                    })
                    .then(({data}) => {
                        this.body = '';

                        flash("Your reply has been posted");

                        this.$emit('created', data);
                    });
            }
        }
    }
</script>
