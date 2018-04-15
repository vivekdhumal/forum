<template>
    <div>
        <input id="trix" type="hidden" :name="name" :value="value">
        <trix-editor ref="trix" input="trix" :placeholder="placeholder"></trix-editor>
    </div>
</template>

<script>
    import Trix from 'trix';
    import 'jquery.caret';
    import 'at.js';

    export default {
        props: ['name', 'value', 'placeholder', 'shouldClear'],

        mounted() {
            this.$refs.trix.addEventListener('trix-change', e => {
                this.$emit('input', e.target.innerHTML);
            });

            this.$watch('shouldClear', () => {
                this.$refs.trix.value = '';
            });

             $(this.$refs.trix).atwho({
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
        }
    }
</script>
