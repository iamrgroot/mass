<template>
    <user-requests-table />
</template>

<script lang="ts">
import { defineComponent } from '@vue/composition-api';

import UserRequestsTable from '@/components/user/request/UserRequestsTable.vue';

export default defineComponent({
    components: {
        UserRequestsTable
    }
});
</script>