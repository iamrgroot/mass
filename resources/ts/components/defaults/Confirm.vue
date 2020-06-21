<template>
    <v-dialog 
        v-model="dialog"
        :max-width="options.width"
        :style="{ zIndex: options.zIndex }"
        @keydown.esc="cancel"
    >
    <v-card>
        <v-toolbar
            :color="options.color"
            dense
            flat
        >
            <v-toolbar-title>
                {{ title }}
            </v-toolbar-title>
        </v-toolbar>
        <v-card-text 
            v-show="message !== ''" 
            class="pa-4"
        >
            {{ message }}
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn 
                color="success darken-1"
                text
                @click.native="agree"
            >
                Yes
            </v-btn>
            <v-btn 
                color="error darken-1"
                text
                @click.native="cancel"
            >
                No
            </v-btn>
        </v-card-actions>
    </v-card>
  </v-dialog>
</template>


<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { ConfirmOptions } from '@/types/ConfirmOptions';

@Component
export default class Confirm extends Vue {
    private dialog = false;
    private resolve?: Function;
    private message = '';
    private title = '';
    private options = {
        color: 'white',
        width: 290,
        zIndex: 200
    } as ConfirmOptions;

    open(title: string, message?: string, options?: ConfirmOptions): Promise<boolean> {
        this.dialog = true;
        this.title = title;
        
        this.message = message || '';
        this.options = Object.assign(this.options, options);

        return new Promise((resolve) => {
            this.resolve = resolve;
        });
    }
    agree() {
        if (this.resolve !== undefined) this.resolve(true);
        this.dialog = false;
    }
    cancel() {
        if (this.resolve !== undefined) this.resolve(false);
        this.dialog = false;
    }
}
</script>