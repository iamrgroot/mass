<template>
    <div>
        <requests-table />
    </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

import RequestsTable from '@/components/request/RequestsTable.vue';

@Component({
    components: {
        RequestsTable
    }
})
export default class MainPage extends Vue {

}
</script>