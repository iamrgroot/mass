<template>
    <v-app>
        <v-content>
             <v-container fluid>
                <v-row
                    align="center"
                    justify="center"
                    :style="{
                        height: '100vh'
                    }"
                >
                    <v-card>
                        <v-card-text>
                            <v-row>
                                <form 
                                    ref="form"
                                    action="/login"
                                    method="POST"
                                >
                                    <input
                                        id="csrf-token"
                                        type="hidden"
                                        name="_token"
                                        :value="csrf_token"
                                    >

                                    <v-col cols="12">
                                        <v-text-field
                                            name="username"
                                            label="Username"
                                            v-model="username"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-text-field
                                            name="password"
                                            label="Password"
                                            type="password"
                                            v-model="password"
                                            @keydown.enter="login"
                                        ></v-text-field>
                                    </v-col>
                                </form>
                            </v-row>
                            <v-alert
                                :value="error_message !== ''"
                                dense
                                type="error"
                                icon="mdi-alert"
                            >
                                {{ error_message }}
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
                </v-row>
            </v-container>
        </v-content>
    </v-app>
</template>

<style lang="scss">
    @import '../../../node_modules/typeface-roboto/index.css';
</style>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import axios from "@/plugins/axios";

@Component
export default class Login extends Vue {
  @Prop({ default: () => [] }) private login_errors!: Array<string>;

  private username = '';
  private password = '';

  get csrf_token(): string {
    return document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')?.content || '';
  }
  get error_message(): string {
    return this.login_errors.length > 0 ? this.login_errors[0] : '';
  }

  login() {
    (this.$refs.form as HTMLFormElement).submit();
  }
}
</script>