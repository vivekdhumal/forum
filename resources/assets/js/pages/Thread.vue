<script>
    import Replies from '../components/Replies.vue';
    import SubscribeButton from '../components/SubscribeButton.vue';

    export default {
        props: ['thread'],

        data () {
            return {
                repliesCount: this.thread.replies_count,
                locked: this.thread.locked,
                editing: false,
                form: {},
                title: this.thread.title,
                body: this.thread.body
            }
        },

        created() {
            this.resetForm();
        },

        components: { Replies, SubscribeButton },

        methods: {
            toggleLock() {
                axios[this.locked ? 'delete' : 'post']('/locked-threads/' + this.thread.slug);

                this.locked = ! this.locked;
            },

            update() {
                let uri = `/threads/${this.thread.channel.slug}/${this.thread.slug}`;

                axios.patch(uri, this.form).then(() => {
                    this.title = this.form.title;
                    this.body = this.form.body;
                    this.editing = false;
                    flash('Your thread has been updated.');
                });
            },

            resetForm() {
                this.form = {
                    title: this.thread.title,
                    body: this.thread.body
                };

                this.editing = false;
            }
        }
    }
</script>
