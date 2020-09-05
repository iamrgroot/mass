<template>
    <user-requests-table />
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

import UserRequestsTable from '@/components/user/request/UserRequestsTable.vue';

@Component({
    components: {
        UserRequestsTable
    }
})
export default class MainPage extends Vue {

}
</script>