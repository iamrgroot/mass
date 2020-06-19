<template>
    <v-app>
        <toolbar />

        <v-main transition="slide-x-transition">
            <router-view></router-view>
        </v-main>

        <confirm ref="confirm" />
    </v-app>
</template>

<style lang="scss">
    @import '../../../node_modules/typeface-roboto/index.css';
</style>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import Toolbar from '@/components/navigation/Toolbar.vue';
import Confirm from '@/components/defaults/Confirm.vue';

@Component({
  components: {
    Toolbar,
    Confirm,
  }
})
export default class Home extends Vue { }
</script>
