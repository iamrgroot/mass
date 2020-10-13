<template>
    <v-select
        :value="value"
        :items="profiles"
        :error-messages="errors"
        :label="label"
        item-value="id"
        item-text="name"
        chips
        v-bind="bind_parameters"
        @input="value => $emit('input', value)"
    />
</template>

<script lang="ts">
import { Component } from 'vue-property-decorator';
import TextField from '@/components/input/TextField.vue';
import { profile_store } from '@/store/profiles';
import { Profile } from '@/types/Item';

@Component
export default class SelectMovieProfile extends TextField {
    get profiles(): Profile[] {
        return profile_store.movie_profiles;
    }
}
</script>
