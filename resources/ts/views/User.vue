<template>
    <v-app>
        <Main />
    </v-app>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import Main from '@/views/Main.vue';

@Component({
    components: {
        Main
    }
})
export default class User extends Vue {
}
</script>
