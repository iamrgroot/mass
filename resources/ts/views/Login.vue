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
                        <v-card min-width="420">
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
                                            label="Username"
                                        />
                                    </v-col>
                                    <v-col cols="12">
                                        <v-text-field
                                            v-model="password"
                                            name="password"
                                            label="Password"
                                            type="password"
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
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class Login extends Vue {
  private username = '';
  private password = '';
  private login_error = '';

  get csrf_token(): string {
    return document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')?.content || '';
  }

  login(): void {
    (this.$refs.form as HTMLFormElement).submit();
  }

  created(): void {
    this.login_error = (window.blade_errors.length > 0) ? window.blade_errors[0] : '';
    console.log(window.blade_errors);

  }
}
</script>