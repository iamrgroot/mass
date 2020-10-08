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
import { namespace } from 'vuex-class';
import { Profile } from '@/types/Item';

const Profiles = namespace('Profiles');

@Component
export default class SelectMultiple extends TextField {
    @Profiles.State private profiles!: Profile[];
}
</script>
