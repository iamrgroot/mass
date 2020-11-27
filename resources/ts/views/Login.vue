<template>
    <v-app>
        <v-main>
            <v-container fluid>
                <v-row
                    align="center"
                    justify="center"
                    :style="{
                        height: '100vh'
                    }"
                >
                    <form
                        ref="form"
                        action="/login"
                        method="POST"
                    >
                        <v-card
                            width="420"
                            max-width="90vw"
                        >
                            <v-card-text>
                                <v-row>
                                    <input
                                        id="csrf-token"
                                        type="hidden"
                                        name="_token"
                                        :value="csrf_token"
                                    >

                                    <v-col cols="12">
                                        <v-text-field
                                            v-model="username"
                                            name="username"
                                            prepend-icon="$mdiAccount"
                                        />
                                    </v-col>
                                    <v-col cols="12">
                                        <v-text-field
                                            v-model="password"
                                            name="password"
                                            type="password"
                                            prepend-icon="$mdiKey"
                                            @keydown.enter="login"
                                        />
                                    </v-col>
                                </v-row>
                                <v-alert
                                    :value="login_error !== ''"
                                    dense
                                    type="error"
                                    icon="$mdiAlert"
                                >
                                    {{ login_error }}
                                </v-alert>
                            </v-card-text>

                            <v-card-actions>
                                <v-btn
                                    text
                                    @click="login"
                                >
                                    Log in
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </form>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

<style lang="scss">
    @import '../../../node_modules/typeface-roboto/index.css';
</style>

<script lang="ts">
import { computed, defineComponent, reactive, toRefs } from '@vue/composition-api';

export default defineComponent({
    setup() {
        const store = reactive({
            username: '',
            password: '',
            login_error: (window.blade_errors.length > 0) ? window.blade_errors[0] : '',
        });

        const csrf_token = computed((): string => {
            return document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')?.content || '';
        });

        return {
            ...toRefs(store),
            csrf_token,
        };
    },
    methods: {
        login(): void {
            (this.$refs.form as HTMLFormElement).submit();
        },
    },
});
</script>
