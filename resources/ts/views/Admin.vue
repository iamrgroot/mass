<template>
    <v-app>
        <toolbar />

        <Main />
    </v-app>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import Main from '@/views/Main.vue';
import Toolbar from '@/components/navigation/AdminToolbar.vue';

@Component({
    components: {
        Main,
        Toolbar
    }
})
export default class Admin extends Vue {
}
</script>
