<template>
    <v-dialog v-model="dialog">
        <template v-slot:activator="{ on, attrs }">
            <v-btn
                text
                v-bind="attrs"
                v-on="on"
            >
                Laravel <v-icon class="ml-3">
                    $mdiMessageAlert
                </v-icon>
            </v-btn>
        </template>

        <v-card>
            <v-card-title class="headline grey lighten-2">
                <v-row align="center">
                    <span>Laravel Log</span>
                    <v-spacer />
                    <v-select
                        v-model="selected"
                        :items="logs"
                        :loading="loading_options"
                        label="Log file"
                        style="max-width: 300px;"
                    />
                </v-row>
            </v-card-title>
            <v-card-text>
                <v-row>
                    <v-col cols="12">
                        <v-textarea
                            v-model="log"
                            :loading="loading"
                            auto-grow
                            readonly
                        />
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script lang="ts">
import { Component, Vue, Watch } from 'vue-property-decorator';
import { getLaravelLog, getLaravelLogs } from '@/api/system';

@Component
export default class LaravelLogsButton extends Vue {
    private logs = [] as string[];
    private dialog = false;
    private loading_options = false;
    private loading = false;
    private selected = '';
    private log = '';

    @Watch('dialog')
    async onChanged(): Promise<void> {
        if (this.dialog && ! this.loading) {
            this.loading_options = true;
            this.logs = await getLaravelLogs();
            this.loading_options = false;
        }
    }

    @Watch('selected')
    async onSelectedChange(): Promise<void> {
        this.loading = true;
        this.log = await getLaravelLog(this.logs.indexOf(this.selected));
        this.loading = false;
    }
}
</script>