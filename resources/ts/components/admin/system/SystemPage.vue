<template>
    <v-card
        :loading="loading"
        class="ma-3"
    >
        <v-card-title>
            <span>System</span>
            <v-spacer />
            <v-btn
                icon
                class="ma-2"
                @click="fetch"
            >
                <v-icon>$mdiRefresh</v-icon>
            </v-btn>
        </v-card-title>
        <v-divider class="mx-3" />
        <v-card-text>
            test
        </v-card-text>
    </v-card>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { getSystemData } from '@/api/system';
import { SystemData } from '@/types/System';

@Component
export default class SystemPage extends Vue {
    private loading = false;
    private data: SystemData | null = null;

    async fetch(): Promise<void> {
        this.loading = true;
        this.data = await getSystemData();
        this.loading = false;
    }
}
</script>