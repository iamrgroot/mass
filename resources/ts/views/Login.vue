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
                                <v-col cols="12">
                                    <v-text-field
                                        label="Username"
                                        v-model="username"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        label="Password"
                                        type="password"
                                        v-model="password"
                                        @keydown.enter="login"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
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
import { Component, Vue } from 'vue-property-decorator';
import axios from "@/plugins/axios";

@Component
export default class Login extends Vue {
  private username = '';
  private password = '';

  login(): void {
    axios.post('/login', {
        username: this.username,
        password: this.password
    }).then(() => {
        window.location.replace(window.location.protocol + '//' + window.location.host);
    });
  }
}
</script>